<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use File;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Models\Employee;
use App\Models\Payment;
use App\User;
use Illuminate\Support\Facades\Hash;
use Yajra\Datatables\Datatables;
use Lang;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index(Request $request)
    {
        //
        if(!(Auth::user()->hasRole('Client')))
            return redirect()->route('user.profile');
            
        if(Auth::user()->hasPermissionTo('Employee Sales'))
            return redirect()->route('user.profile');

        $agent = new Agent();  
        if($agent->isMobile())
            $i = -1;
        else
            $i = 1;

        $client_id = 0;
        if(Auth::user()->hasPermissionTo('Employee Administrative') || Auth::user()->hasPermissionTo('Employee Sales'))
            $client_id = Auth::user()->employee->client_id;
        else
            $client_id = Auth::user()->client->id;

        $client = Client::find($client_id);
        $numberofUsers = Payment::find($client->payment)->first();

        $employees = Employee::where('client_id', $client_id)->latest()->get();

        if ($request->ajax()) {
            $data = Employee::where('client_id', $client_id)->latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('image', function($row){
                        return '<span><img src="'.$row->image.'"  style="width: 38px;height:38px;border-radius: 50%;background-color: #f5f5f5;box-shadow: 0 2px 2px 0 rgba(0, 0, 0, .12);" alt="avatar"></span>';
                    })
                    ->editColumn('phone', function($row){
                        return '+'.Str::substr($row->phone, 0, strlen($row->phone) - 10).' ('.Str::substr($row->phone, strlen($row->phone) - 10, 3).') '.Str::substr($row->phone, strlen($row->phone) - 7, 3).'-'.Str::substr($row->phone, strlen($row->phone) - 4);
                    })
                    ->editColumn('salary', function($row){
                        return '$'.number_format($row->salary, 2, '.', ',');
                    })
                    ->editColumn('role', function($row){
                        if($row->role == '' || $row->role == null)
                            return '';
                        return Lang::get('messages.'.$row->role);
                    })
                    ->editColumn('cycle', function($row){
                        return Lang::get('messages.'.$row->cycle);
                    })
                    ->addColumn('email', function($row){
                        $user = User::find($row->user_id);
                        if($user == null)
                            return '';
                        return $user->email;
                    })
                    ->addColumn('action', function($row){
                        $btn = '<a href="javascript:void(0)" class="editEmployee tooltipped" data-id="'.$row->id.'" data-position="bottom" data-tooltip="'.Lang::get('messages.Edit').'"><i class="material-icons">edit</i></a>';
   
                        $btn = $btn.'<a href="javascript:void(0)" class="remove-employee tooltipped" data-id="'.$row->id.'" data-position="bottom" data-tooltip="'.Lang::get('messages.Delete').'"><i class="material-icons">delete</i></a>';
                        if($row->user_id != 0)
                            $btn = $btn.'<a href="javascript:void(0)" class="invitebtn tooltipped" data-id="'.$row->id.'" data-name="'.$row->name.'" data-position="bottom" data-tooltip="Invite"><i class="material-icons">insert_invitation</i></a>';
                        return $btn;
                    })

                    ->rawColumns(array('phone', 'salary', 'image', 'email', 'action', 'role', 'cycle'))
                    ->make(true);
        }
      
        return view('user.client.employee.index')->with('employees', $employees)->with('i', $i)->with('numberofUsers', $numberofUsers->numberofusers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        //
        $request->merge(['phone' => preg_replace('/[^0-9]/', '', $request->input('phone'))]);
        $phone = $request->input('phone');
        $request->merge(['phone' => $request->input('countryCode') . $request->input('phone')]);
        $data = $request->input();
        $id = $request->typeid;
        $isAdmin = array_key_exists('systemuser', $data);
        $employee = Employee::find($id);
        $user_id = 0;
        if($id != 0)
            $user_id = $employee->user_id;

        $client_id = 0;
        if(Auth::user()->hasPermissionTo('Employee Administrative') || Auth::user()->hasPermissionTo('Employee Sales'))
            $client_id = Auth::user()->employee->client_id;
        else
            $client_id = Auth::user()->client->id;
            
        if($isAdmin == true)
            request()->validate([
                'phone'  => ['required', 'min:11', 'numeric', 'unique:employees,phone,'.$id.',id',
                                function ($attribute, $value, $fail) use ($phone) {
                                    if (strlen($phone) != 10) {
                                        $fail('Incorrect phone number.');
                                    }
                                },
                            ],
                'name' => 'required',
                'salary' => 'required|numeric',
                'email'  => ['email', 'required', 'unique:users,email,'.$user_id.',id',
                            ],
            ]);
        else
            request()->validate([
                'phone'  => ['required', 'min:11', 'numeric', 'unique:employees,phone,'.$id.',id',
                                function ($attribute, $value, $fail) use ($phone) {
                                    if (strlen($phone) != 10) {
                                        $fail('Incorrect phone number.');
                                    }
                                },
                            ],
                'name' => 'required',
                'salary' => 'required|numeric',
            ]);
        
        $roleTmp = $data['role'];
        if(!array_key_exists('systemuser', $data))
        {
            $roleTmp = '';
        }
        if($id == 0)
        {
            $url = "";
            
            $user_id = 0;
            if(array_key_exists('systemuser', $data))
            {
                $user = User::create([
                    "name" => $data['name'],
                    "phone" => $data['phone'],
                    "email" => $data['email'],
                    "password" => Hash::make('123213213'),
                    "image" => $data['image'],
                    "isdelete" => 0,
                ]);
                $user->givePermissionTo('Employee '.$data['role']);
                $user->assignRole('Client');
                $user_id = $user->id;
                $user->sendEmailVerificationNotification();
            }

            $employee = Employee::create([
                'name' => $data['name'],
                'phone' => $data['phone'],
                'salary' => $data['salary'],
                'cycle' => $data['cycle'],
                'role' => $roleTmp,
                'user_id' => $user_id,
                'client_id' => $client_id,
                'image' => $data['image'],
            ]);
            return response()->json(['success'=>'Created successfully.', 'id'=>$employee->id]);
        }
       
        if($data['image'] != $employee->image)
        {
            $tmps = explode('/', $employee->image);
            $image_path = '/employees/' . $tmps[count($tmps) - 1];  // Value is not URL but directory file path
            Storage::delete('/public' . $image_path);
        }

        $user_id = 0;
        
        if(array_key_exists('systemuser', $data))
        {
            if($employee->user_id != 0)
            {
                $user = User::find($employee->user_id);
                $user->name = $data['name'];
                $user->phone = $data['phone'];
                $user->email = $data['email'];
                $user->image = $data['image'];
                $user->syncPermissions('Employee '.$data['role']);
                $user->assignRole('Client');
                $user->update();
                $user_id = $user->id;
            }
            else{
                $user = User::create([
                    "name" => $data['name'],
                    "phone" => $data['phone'],
                    "email" => $data['email'],
                    'image' => $data['image'],
                    "password" => Hash::make('123213213'),
                    "isdelete" => 0,
                ]);
                $user->givePermissionTo('Employee '.$data['role']);
                $user->assignRole('Client');
                $user_id = $user->id;
                $user->sendEmailVerificationNotification();
            }
        }

        $employee->name = $data['name'];
        $employee->phone = $data['phone'];
        $employee->salary = $data['salary'];
        $employee->cycle = $data['cycle'];
        $employee->role = $roleTmp;
        $employee->user_id = $user_id;
        $employee->client_id = $client_id;
        $employee->image = $data['image'];
        $employee->update();

        return response()->json(['success'=>Lang::get('messages.Saved Successfully'), 'id'=>$id]);
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
        $employee = Employee::find($id);
        $phoneTmp = $employee['phone'];
        $countrycode = Str::substr($phoneTmp, 0, strlen($phoneTmp) - 10);
        $phone = Str::substr($phoneTmp, -10);
        $employee['countryCode'] = $countrycode;
        $employee['phone'] = '('.Str::substr($phone, 0, 3).') '.Str::substr($phone, 3, 3).'-'.Str::substr($phone, 6);

        if($employee->user_id != 0)
        {
            $user = User::find($employee->user_id);
            $employee['email'] = $user->email;
            $permissions = $user->getAllPermissions();
            $employee['role'] = str_replace('Employee ', '', $permissions[0]->name);
        }
        return response()->json($employee);
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
        //
        $request->merge(['phone' => preg_replace('/[^0-9]/', '', $request->input('phone'))]);
        $request->merge(['phone' => $request->input('countryCode') . $request->input('phone')]);
        $data = $request->input();
        $employee = Employee::find($data['editemployeeId']);
        
        
        $url = $employee->image;
        if ($request->hasFile('image')) {
            //  Let's do everything here
            if ($request->file('image')->isValid()) {
                //
                $validated = $request->validate([
                    'image' => 'mimes:jpeg,png|max:1014',
                ]);
                $tmps = explode('/', $employee->image);
                $image_path = '/employees/' . $tmps[count($tmps) - 1];  // Value is not URL but directory file path
                Storage::delete('/public' . $image_path);
                $file = request()->file('image');
                $name = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $request->image->storeAs('/public/employees', $name);
                $url = asset("storage/employees/" . $name);
            }
        }
        $user_id = 0;
        
        if(array_key_exists('systemuser', $data))
        {
            if($employee->user_id != 0)
            {
                $user = User::find($employee->user_id);
                $user->name = $data['name'];
                $user->phone = $data['phone'];
                $user->email = $data['email'];

                $user->syncPermissions('Employee '.$data['role']);
                $user->assignRole('Client');
                $user->update();
                $user_id = $user->id;
            }
            else{
                $user = User::create([
                    "name" => $data['name'],
                    "phone" => $data['phone'],
                    "email" => $data['email'],
                    "password" => Hash::make('123213213'),
                    "isdelete" => 0,
                ]);
                $user->givePermissionTo('Employee '.$data['role']);
                $user->assignRole('Client');
                $user_id = $user->id;
            }
        }
        $client = Auth::user()->client;

        $employee->name = $data['name'];
        $employee->phone = $data['phone'];
        $employee->salary = $data['salary'];
        $employee->cycle = $data['cycle'];
        $employee->user_id = $user_id;
        $employee->client_id = $client->id;
        $employee->image = $url;
        $employee->update();

        return redirect()->route('user.clientemployees.index');
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
         //
         $employee = Employee::find($id);
         $tmps = explode('/', $employee->image);
         $image_path = '/employees/' . $tmps[count($tmps) - 1];  // Value is not URL but directory file path
         
         Storage::delete('/public' . $image_path);
         Employee::find($id)->delete();
 
         return response()->json(['success'=>Lang::get('messages.Deleted Successfully')]);
    }

    public function sendInvite(Request $request)
    {
        $employee = Employee::find($request->id);
        $user = User::find($employee->user_id);
        User::sendWelcomeEmail($user);
        return response()->json(['success'=>'Send successfuly.']);
    }

    public function uploadImage(Request $request)
    {
        $folderPath = storage_path('/app/public/employees/');

        if(!File::isDirectory($folderPath))
            File::makeDirectory($folderPath, $mode = 0777, true, true);
 
        $image_parts = explode(";base64,", $request->image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
 
        $imageName = md5(time()) . '.png';
 
        $imageFullPath = $folderPath.$imageName;

        file_put_contents($imageFullPath, $image_base64);

        if($request->oldimage != null)
        {
            $tmps = explode('/', $request->oldimage);
            $image_path = '/employees/' . $tmps[count($tmps) - 1];  // Value is not URL but directory file path
            Storage::delete('/public' . $image_path);
        }

        return response()->json(['img' => asset('/storage/employees/'.$imageName), 'imgurl' => '/storage/employees/'.$imageName]);
    }
}
