<?php

namespace App\Http\Controllers\Admin;

use App\Models\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Classes\UserControlClass;
use App\User;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:List Clients']);
    }
    
    public function index(Request $request)
    {
        //
        $agent = new Agent();
        
        $clients = Client::join('users', 'users.id', '=', 'user_id')
                        ->select('users.email as email', 'users.name as name', 'users.phone as phone', 'users.password as password', 'clients.id', 'companyname', 'addline1', 'country', 'cp', 'user_id', 'numberofemployees', 'service', 'payment')
                        ->orderby('clients.id')->get();
        
        if($agent->isMobile())
            $i = -1;
        else
            $i = (request()->input('page', 1) - 1) * 10;
        return view('admin.client.index',compact('clients'))
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
        return view('admin.client.create');
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
            'email' => ['required',
                        function ($attribute, $value, $fail){
                            $allusers = User::where('isdelete', false)->where('email', $value)->with('roles')->get();
                            $users = $allusers->reject(function ($user, $key) {
                                return !($user->hasRole('Client'));
                            });
                            if (count($users)) {
                                $fail('This email is already exist.');
                            }
                        },
                    ],
            'companyname'   =>[
                'required',
                Rule::unique('clients'),
            ],
            'addline1'      =>'required',
            'country' => 'required',
            'numberofemployees' => 'required',
            'service' => 'required',
            'payment' => 'required',
        ]);
        //
        
        $data = $request->input();
        
        $userClass = new UserControlClass();
        $userClass->saveClient($data);
        return redirect()->route('clients.index');
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
        $clients = Client::join('users', 'users.id', '=', 'user_id')
                        ->select('users.email as email', 'users.name as name', 'users.phone as phone', 'users.password as password', 'clients.id', 'companyname', 'addline1', 'country', 'cp', 'user_id', 'numberofemployees', 'service', 'payment')
                        ->where('clients.id', $id)
                        ->orderby('clients.id')->get();
        $client = $clients[0];
        return view('admin.client.show')->with('client',$client);
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
        $clients = Client::join('users', 'users.id', '=', 'user_id')
                    ->select('users.email as email', 'users.name as name', 'users.phone as phone', 'users.password as password', 'clients.id', 'companyname', 'addline1', 'country', 'cp', 'user_id', 'numberofemployees', 'service', 'payment')
                    ->where('clients.id', $id)
                    ->orderby('clients.id')->get();
        $client = $clients[0];
        $phoneTmp = $client['phone'];
        $countrycode = Str::substr($phoneTmp, 0, strlen($phoneTmp) - 10);
        $phone = Str::substr($phoneTmp, -10);
        $client['countryCode'] = $countrycode;
        $client['phone'] = '('.Str::substr($phone, 0, 3).') '.Str::substr($phone, 3, 3).'-'.Str::substr($phone, 6);
        return view('admin.client.edit')->with('client',$client);
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
        $client = Client::find($id);
        $request->merge(['phonetmp' => $request->input('phone')]);
        $request->merge(['phone' => preg_replace('/[^0-9]/', '', $request->input('phone'))]);
        $request->merge(['phone' => $request->input('countryCode') . $request->input('phone')]);
        $this->validate($request, [
            'name'                 => [
                'required',
            ],
            'phone'                 => 'required|numeric|unique:users,phone,'.$request->input('email').',email,isdelete,0',
            'confirm_password' => 'same:new_password',
            'email' =>['required',
                        function ($attribute, $value, $fail) use ($client) {
                            $allusers = User::where('isdelete', false)->where('email', $value)->where('id', '!=', $client->user_id)->with('roles')->get();
                            $users = $allusers->reject(function ($user, $key) {
                                return !($user->hasRole('Client'));
                            });
                            if (count($users)) {
                                $fail('This email is already exist.');
                            }
                        },
                    ],
            'companyname'   =>[
                'required',
                Rule::unique('clients')->ignore($id),
            ],
            'addline1'      =>'required',
            'country' => 'required',
            'numberofemployees' => 'required',
            'service' => 'required',
            'payment' => 'required',
        ]);
        //
        $data=$request->input();
        $userClass = new UserControlClass();
        $userClass->editClient($id, $data);
        return redirect()->route('clients.index');
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
        Client::find($id)->delete();
        return redirect()->route('clients.index');
    }
    
    
}
