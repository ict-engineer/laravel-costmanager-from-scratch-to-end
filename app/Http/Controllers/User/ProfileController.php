<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Provider;
use App\Models\Client;
use App\Models\Payment;
use App\Service;
use App\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use File;
use Lang;
use Session;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    
    // get payment and service list
    public function getServicePaymentList(Request $request)
    {
        $index = $request->language;
        $languagelist1 = ["name", "spanish", "french", "italian", "russian", "german"];
        
        $services = Service::pluck($languagelist1[$index]);
        $payments = Payment::where('country', $request->country)->pluck('name');
        return Response()->json([
            "services" => $services,
            "payments" => $payments,
        ]);   
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $isProvider = 1;
        $isClient = 1;
        $user = Auth::user();
        $provider = [];
        $client = [];
        $client['service'] = "";
        
        if(Auth::user()->hasRole('Provider'))
        {
            $isProvider = 2;
            // $users = Provider::join('users', 'users.id', '=', 'user_id')
            //         ->select('users.email as email', 'users.name as name', 'users.phone as phone', 'users.password as password', 'providers.id', 'companyname', 'addline1', 'addline2', 'country', 'cp', 'user_id')
            //         ->where('users.id', Auth::user()->id)->get();
            //         $user = $users[0];
            $providers = Provider::where('user_id', Auth::user()->id)->get();

            $provider = $providers[0];

            if($provider->api_token == null || $provider->api_token == '')
            {
                $provider->api_token = 'hq_token_'.md5($provider->id . time());
                $provider->update();
            }
        }
        if(Auth::user()->hasRole('Client') && !(Auth::user()->hasPermissionTo('Employee Administrative') || Auth::user()->hasPermissionTo('Employee Sales')))
        {
            $isClient = 2;
            // $users = Client::join('users', 'users.id', '=', 'user_id')
            //         ->select('users.email as email', 'users.name as name', 'users.phone as phone', 'users.password as password', 'clients.id', 'companyname', 'addline1', 'addline2', 'country', 'cp', 'user_id', 'numberofemployees', 'service', 'payment')
            //         ->where('users.id', Auth::user()->id)->get();
            //         $user = $users[0];
            $clients = Client::where('user_id', Auth::user()->id)->get();
            $client = $clients[0];
        }
        $phoneTmp = $user['phone'];
        $countrycode = Str::substr($phoneTmp, 0, strlen($phoneTmp) - 10);
        $phone = Str::substr($phoneTmp, -10);
        $user['countryCode'] = $countrycode;
        $user['phone'] = '('.Str::substr($phone, 0, 3).') '.Str::substr($phone, 3, 3).'-'.Str::substr($phone, 6);
        
        return view('user.profile.index')->with('user', $user)->with('provider', $provider)->with('client', $client);
    }

    public function saveUserInfo(Request $request)
    {
        $request->merge(['phone' => preg_replace('/[^0-9]/', '', $request->input('phone'))]);
        $phone = $request->phone;
        $request->merge(['phone' => $request->input('countryCode') . $request->input('phone')]);
        
        request()->validate([
            'email'      => 'required|unique:users,email,'.Auth::user()->id.',id,isdelete,0',
            'phone'      => ['required', 'min:11', 'numeric', 'unique:users,phone,'.Auth::user()->id.',id,isdelete,0',
                                function ($attribute, $value, $fail) use ($phone) {
                                    if (strlen($phone) != 10) {
                                        $fail('Incorrect phone number.');
                                    }
                                },
                            ],
            'name'      => 'required',
        ]);

        $user = Auth::user();
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->name = $request->name;
        $user->update();
        
        return Response()->json([
            "success" => true,
            "text" => Lang::get('messages.Saved Successfully.'),
            "name" => Auth::user()->name
        ]);   
    }

    public function saveProvider(Request $request)
    {
        $request->merge(['phone' => preg_replace('/[^0-9]/', '', $request->input('phone'))]);
        $request->merge(['phone' => $request->input('countryCode') . $request->input('phone')]);
        request()->validate([
            // 'companyname'  => [
            //     'required',
            //     Rule::unique('providers'),
            // ],
            'companyname'      => 'required|unique:providers,companyname,'.Auth::user()->id.',user_id',
            'addline1'  => 'required',
            'country'  => 'required',
            'cp'  => 'required',
        ]);
        $user = Auth::user();
        if(Auth::user()->hasRole('Provider'))
        {
            $provider = Provider::where('user_id', Auth::user()->id)->first();
            $provider->companyname = $request->companyname;
            $provider->addline1 = $request->addline1;
            $provider->country = $request->country;
            $provider->cp = $request->cp;
            $provider->update();
        }
        else
        {
            Provider::where('user_id', Auth::user()->id)->delete();
            Provider::create([
                'companyname' => $request->companyname,
                'addline1' => $request->addline1,
                'country' => $request->country,
                'cp' => $request->cp,
                'user_id' => $user->id,
            ]);
            $user->removeRole('Test');
            $user->assignRole('Provider');
        }

        return Response()->json([
            "success" => true,
            'text'=>Lang::get('messages.Saved Successfully')
        ]);   
    }

    public function saveClient(Request $request)
    {
        request()->validate([
            'companyname'      => 'required|unique:clients,companyname,'.Auth::user()->id.',user_id',
            'addline1'  => 'required',
            'country'  => 'required',
            'cp'  => 'required',
            'numberofemployees'  => 'required',
            'service'  => 'required',
        ]);
        $folderPath = storage_path('/app/public/companylogos/');

        if(!File::isDirectory($folderPath))
            File::makeDirectory($folderPath, $mode = 0777, true, true);
        if ($request->hasFile('image')) {
            if ($request->file('image')->isValid()) {
                //
                $validated = $request->validate([
                    'image' => 'mimes:jpeg,png|max:1024',
                ]);
                $tmps = explode('/', Auth::user()->logoimage);
                $image_path = '/companylogos/' . $tmps[count($tmps) - 1];  // Value is not URL but directory file path
                Storage::delete('/public' . $image_path);
                $file = request()->file('image');
                $name = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $request->image->storeAs('/public/companylogos', $name);
                $url = asset("storage/companylogos/" . $name);
                $user = Auth::user();
                $user->logoimage = '/storage/companylogos/'.$name;
                $user->save();
            }
        }

        $user = Auth::user();
        Session::put('isMexican', '');
        if(Auth::user()->hasRole('Client'))
        {
            $client = Client::where('user_id', Auth::user()->id)->first();
            $client->companyname = $request->companyname;
            $client->addline1 = $request->addline1;
            $client->country = $request->country;
            $client->numberofemployees = $request->numberofemployees;
            $client->service = $request->service;
            $client->lat = $request->lat;
            $client->lng = $request->lng;
            $client->update();

            if($client->country == "Mexico")
                Session::put('isMexican', 'yes');

        }
        else
        {
            Client::where('user_id', Auth::user()->id)->delete();
            $client = Client::create([
                'companyname' => $request->companyname,
                'addline1' => $request->addline1,
                'country' => $request->country,
                'cp' => $request->cp,
                'numberofemployees' => $request->numberofemployees,
                'service' => $request->service,
                'lat' => $request->lat,
                'lng' => $request->lng,
                'user_id' => $user->id,
            ]);
            $user->removeRole('Test');
            $user->assignRole('Client');

            if($client->country == "Mexico")
                Session::put('isMexican', 'yes');

        }
        
        
        return Response()->json([
            "success" => true,
            'text'=>Lang::get('messages.Saved Successfully')
        ]);   
    }
    
    public function savePassword(Request $request)
    {
        $password = Auth::user()->password;
        request()->validate([
            'password'      => ['required',
                                    function ($attribute, $value, $fail) use ($password) {
                                        if (!Hash::check($value, $password)) {
                                            $fail('Current Password is not correct.');
                                        }
                                    },
                                ],
            'newPassword'         => ['required', 'string', 'min:8'],
            'confirmPassword' => ['required', 'string', 'min:8', 'same:newPassword'],
        ]);
        $user = Auth::user();
        $user->password = Hash::make($request->newPassword);
        $user->update();
        
        return Response()->json([
            "success" => true,
            'text'=>Lang::get('messages.Saved Successfully')
        ]);   
    }

    public function uploadImage(Request $request)
    {
        $folderPath = storage_path('/app/public/avatars/');

        if(!File::isDirectory($folderPath))
            File::makeDirectory($folderPath, $mode = 0777, true, true);
 
        $image_parts = explode(";base64,", $request->image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
 
        $imageName = md5(time()) . '.png';
 
        $imageFullPath = $folderPath.$imageName;

        file_put_contents($imageFullPath, $image_base64);

        $tmps = explode('/', Auth::user()->image);
        $image_path = '/avatars/' . $tmps[count($tmps) - 1];  // Value is not URL but directory file path
        Storage::delete('/public' . $image_path);

        $user = Auth::user();
         $user->image = '/storage/avatars/'.$imageName;
         $user->save();
    
        return response()->json(['img' => asset($user->image)]);
    }

    public function uploadLogoImage(Request $request)
    {
        $folderPath = storage_path('/app/public/companylogos/');

        if(!File::isDirectory($folderPath))
            File::makeDirectory($folderPath, $mode = 0777, true, true);
        if ($request->file('image')->isValid()) {
            //
            $validated = $request->validate([
                'image' => 'mimes:jpeg,png|max:1014',
            ]);
            $tmps = explode('/', Auth::user()->logoimage);
            $image_path = '/companylogos/' . $tmps[count($tmps) - 1];  // Value is not URL but directory file path
            Storage::delete('/public' . $image_path);
            $file = request()->file('image');
            $name = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
            $request->image->storeAs('/public/companylogos', $name);
            $url = asset("storage/companylogos/" . $name);
            $user = Auth::user();
            $user->logoimage = '/storage/companylogos/'.$name;
            $user->save();
            return response()->json(['img' => asset($user->logoimage)]);
        }
        
        return response()->json(['message' => "failed"]);
        // $image_parts = explode(";base64,", $request->image);
        // $image_type_aux = explode("image/", $image_parts[0]);
        // $image_type = $image_type_aux[1];
        // $image_base64 = base64_decode($image_parts[1]);
 
        // $imageName = md5(time()) . '.png';
 
        // $imageFullPath = $folderPath.$imageName;

        // file_put_contents($imageFullPath, $image_base64);

        // $tmps = explode('/', Auth::user()->logoimage);
        // $image_path = '/companylogos/' . $tmps[count($tmps) - 1];  // Value is not URL but directory file path
        // Storage::delete('/public' . $image_path);

    }
}
