<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Jenssegers\Agent\Agent;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    //Check if user has list permission
    public function __construct()
    {
        $this->middleware(['permission:List Roles']);
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
        if($agent->isMobile())
            $i = -1;
        else
            $i = (request()->input('page', 1) - 1) * 10;
        $roles = Role::where('name', '<>', 'Super-Admin')->where('name', '<>', 'Provider')->where('name', '<>', 'Client')->where('name', '<>', 'Test')->get();
        return view('admin.roles.index')->with('roles', $roles)->with('i', $i);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.roles.create');
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
            'name'                 => [
                'required',
                Rule::unique('roles')
            ],
        ]);
        $data = $request->input();
        $rolename = $data["name"];
        $role = Role::create(['name' => $rolename]);
        foreach($data as $key=>$value)
        {
            if($value == "on")
            {
                $tmp = str_replace('_', ' ', $key);
                $role->givePermissionTo($tmp);
            }
        }
        if(count($role->getAllPermissions()))
            $role->givePermissionTo("Access Admin");
        return redirect()->route('roles.index');
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
        $role = Role::find($id);
        $permissions = $role->getAllPermissions()->pluck('name');
        return view('admin.roles.show')->with('role', $role->name)->with('permissions', $permissions)->with('i', 1);
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
        $role = Role::find($id);
        return view('admin.roles.edit')->with('role', $role);
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
        $this->validate($request, [
            'name'                 => [
                'required',
                Rule::unique('roles')->ignore($id),
            ],
        ]);
        $data = $request->input();
        $rolename = $data["name"];
        $role = Role::where(['name' => $rolename])->first();
        $role->revokePermissionTo($role->getAllPermissions());
        foreach($data as $key=>$value)
        {
            if($value == "on")
            {
                $tmp = str_replace('_', ' ', $key);
                $role->givePermissionTo($tmp);
            }
        }
        if(count($role->getAllPermissions()))
            $role->givePermissionTo("Access Admin");
        $role->update();
        return redirect()->route('roles.index');
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
        $role = Role::find($id);
        $role->delete();
        return redirect()->route('roles.index');
    }
}
