<?php

namespace App\Http\Controllers\Admin;

use App\Models\Smtp;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class SmtpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $agent = new Agent();
        
        $smtps = Smtp::orderby('id')->get();
        if($agent->isMobile())
            $i = -1;
        else
            $i = (request()->input('page', 1) - 1) * 10;
        return view('admin.smtp.index',compact('smtps'))
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
        return view('admin.smtp.create');
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
            'server'                 => 'required',
            'new_password'         => 'required',
            'confirm_password' => 'required|same:new_password',
            'email' => 'required',
            'port' => 'required',
        ]);
        //
        $data = $request->input();
        $newsmtp = Smtp::create([
            'name' => $data['name'],
            'server' => $data['server'],
            'port' => $data['port'],
            'email' => $data['email'],
            'password' => $data['new_password'],
            'security' => $data['security'],
        ]);
        return redirect()->route('smtp.index');
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
        $smtp = Smtp::findOrFail($id);
        return view('admin.smtp.show')->with('smtp',$smtp);
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
        $smtp = Smtp::findOrFail($id);
        return view('admin.smtp.edit')->with('smtp',$smtp);
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
            'name'                 => 'required',
            'server'                 => 'required',
            'confirm_password' => 'same:new_password',
            'email' => 'required',
            'port' => 'required',
        ]);
        //
        $smtps = Smtp::find($id);
        $smtps->name = $request->input('name');
        $smtps->server = $request->input('server');
        $smtps->email = $request->input('email');
        $smtps->port = $request->input('port');
        $smtps->security = $request->input('security');
        if($request->input('new_password') != "")
            $smtps->password = $request->input('new_password');
        $smtps->update();
        return redirect()->route('smtp.index');
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
        $smtp = Smtp::find($id);
        $smtp->delete();
        return redirect()->route('smtp.index');
    }
}
