<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Jenssegers\Agent\Agent;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    //Check if user has list permission
    public function __construct()
    {
        $this->middleware(['permission:List Users']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $agent = new Agent();
        
        $allusers = User::where('isdelete', false)->with('roles')->get();
        $users = $allusers->reject(function ($user, $key) {
            return !($user->hasPermissionTo('Access Admin'));
        });
        if($agent->isMobile())
            $i = -1;
        else
            $i = (request()->input('page', 1) - 1) * 10;
        return view('admin.user.index',compact('users'))
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
        $roles = Role::where('name', '<>', 'Super-Admin')->pluck('name');
        return view('admin.user.create')->with('roles', $roles);
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
        $this->validate($request, [
            'name'                 => 'required',
            'phone'                 => [
                'required',
                Rule::unique('users')->ignore(true, 'isdelete'),
            ],
            'new_password'         => 'required',
            'confirm_password' => 'required|same:new_password',
            'email' => [
                'required',
                Rule::unique('users')->ignore(true, 'isdelete'),
            ],
            'usertype' => 'required',
        ]);
        //
        $data = $request->input();
        $data['isdelete'] = false;
        $newUser = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'isdelete' => $data['isdelete'],
            'password' => Hash::make($data['new_password']),
        ]);
        $newUser->syncRoles($data['usertype']);
        return redirect()->route('usersetup.index');
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
        $user = User::findOrFail($id);
        return view('admin.user.show')->with('user',$user);
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
        $user = User::findOrFail($id);
        $roles = Role::where('name', '<>', 'Super-Admin')->pluck('name');
        return view('admin.user.edit')->with('user',$user)->with('roles', $roles);
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
        $this->validate($request, [
            'email' => 'required|unique:users,email,'.$id.',id,isdelete,0',
            'name'                 => 'required',
            'phone'                 => 'required|unique:users,phone,'.$id.',id,isdelete,0',
            'confirm_password' => 'same:new_password',
            'usertype' => 'required',
        ]);
        //
        $users = User::find($id);
        $users->email = $request->input('email');
        $users->name = $request->input('name');
        $users->phone = $request->input('phone');
        if($request->input('new_password') != "")
            $users->password = Hash::make($request->input('new_password'));
        $users->update();
        $users->syncRoles($request->input('usertype'));
        return redirect()->route('usersetup.index');
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
        User::where('id', '=', $id)->update(['isdelete'=> true]);
  
        return redirect()->route('usersetup.index');
    }
}
