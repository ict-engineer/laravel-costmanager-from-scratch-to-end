<?php

namespace App\Http\Controllers\Admin;

use App\Provider;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Classes\UserControlClass;
use App\User;

class ProviderController extends Controller
{
    //Check if user has list permission
    public function __construct()
    {
        $this->middleware(['permission:List Providers']);
    }

    public function index(Request $request)
    {
        //
        $agent = new Agent();
        
        $providers = Provider::join('users', 'users.id', '=', 'user_id')
                        ->select('users.email as email', 'users.name as name', 'users.phone as phone', 'users.password as password', 'providers.id', 'companyname', 'addline1', 'addline2', 'country', 'cp', 'user_id')
                        ->orderby('companyname')->get();
        
        if($agent->isMobile())
            $i = -1;
        else
            $i = (request()->input('page', 1) - 1) * 10;
        return view('admin.provider.index',compact('providers'))
            ->with('i', $i);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.provider.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->merge(['phonetmp' => $request->input('phone')]);
        $request->merge(['phone' => preg_replace('/[^0-9]/', '', $request->input('phone'))]);
        $request->merge(['phone' => $request->input('countryCode') . $request->input('phone')]);
        $this->validate($request, [
            'name'                 => [
                'required',
            ],
            'phone'                 => 'required|numeric|unique:users,phone,'.$request->input('email').',email,isdelete,0',
            'new_password'         => 'required',
            'confirm_password' => 'required|same:new_password',
            'email' => [
                'required',
                function ($attribute, $value, $fail) {
                    $allusers = User::where('isdelete', false)->where('email', $value)->with('roles')->get();
                    $users = $allusers->reject(function ($user, $key) {
                        return !($user->hasRole('Provider'));
                    });
                    if (count($users)) {
                        $fail('This email is already exist.');
                    }
                },
            ],
            'companyname'   =>[
                'required',
                Rule::unique('providers'),
            ],
            'addline1'      =>'required',
            'addline2'      =>'required',
            'country' => 'required',
        ]);
        //
        
        $data = $request->input();
        $userClass = new UserControlClass();
        $userClass->saveProvider($data);
        return redirect()->route('providers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $providers = Provider::join('users', 'users.id', '=', 'user_id')
                        ->select('users.email as email', 'users.name as name', 'users.phone as phone', 'users.password as password', 'providers.id', 'companyname', 'addline1', 'addline2', 'country', 'cp', 'user_id')
                        ->where('providers.id', $id)
                        ->orderby('companyname')->get();
        $provider = $providers[0];                        
        return view('admin.provider.show')->with('provider',$provider);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $providers = Provider::join('users', 'users.id', '=', 'user_id')
                        ->select('users.email as email', 'users.name as name', 'users.phone as phone', 'users.password as password', 'providers.id', 'companyname', 'addline1', 'addline2', 'country', 'cp', 'user_id')
                        ->where('providers.id', $id)
                        ->orderby('companyname')->get();
        $provider = $providers[0];
        $phoneTmp = $provider['phone'];
        $countrycode = Str::substr($phoneTmp, 0, strlen($phoneTmp) - 10);
        $phone = Str::substr($phoneTmp, -10);
        $provider['countryCode'] = $countrycode;
        $provider['phone'] = '('.Str::substr($phone, 0, 3).') '.Str::substr($phone, 3, 3).'-'.Str::substr($phone, 6);
        return view('admin.provider.edit')->with('provider',$provider);
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)   
    {
        $provider = Provider::find($id);
        $request->merge(['phonetmp' => $request->input('phone')]);
        $request->merge(['phone' => preg_replace('/[^0-9]/', '', $request->input('phone'))]);
        $request->merge(['phone' => $request->input('countryCode') . $request->input('phone')]);
        $this->validate($request, [
            'name'                 => [
                'required',
            ],
            'phone'                 => 'required|numeric|unique:users,phone,'.$request->input('email').',email,isdelete,0',
            'confirm_password' => 'same:new_password',
            'email' => [
                'required',
                function ($attribute, $value, $fail)  use ($provider) {
                    $allusers = User::where('isdelete', false)->where('email', $value)->where('id', '!=', $provider->user_id)->with('roles')->get();
                    $users = $allusers->reject(function ($user, $key) {
                        return !($user->hasRole('Provider'));
                    });
                    if (count($users)) {
                        $fail('This email is already exist.');
                    }
                },
            ],
            'companyname'   =>[
                'required',
                Rule::unique('providers')->ignore($id),
            ],
            'addline1'      =>'required',
            'addline2'      =>'required',
            'country' => 'required',
        ]);
        //
        $data= $request->input();
        $userClass = new UserControlClass();
        $userClass->editProvider($id, $data);
        return redirect()->route('providers.index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Provider::find($id)->delete();
        return redirect()->route('providers.index');
    }
}
