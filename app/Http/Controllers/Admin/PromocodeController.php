<?php

namespace App\Http\Controllers\Admin;

use App\Models\Promocode;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Illuminate\Validation\Rule;

class PromocodeController extends Controller
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
        
        $promocodes = Promocode::orderby('id')->get();
        if($agent->isMobile())
            $i = -1;
        else
            $i = (request()->input('page', 1) - 1) * 10;
        return view('admin.promocode.index',compact('promocodes'))
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
        return view('admin.promocode.create');
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
            'code'                 => 'required',
            'discount'         => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'duration' => 'required',
            'active' => 'required',
        ]);
        //
        $data = $request->input();
        $newpromocode = Promocode::create([
            'name' => $data['name'],
            'code' => $data['code'],
            'discount' => $data['discount'],
            'duration' => $data['duration'],
            'active' => $data['active'],
        ]);
        return redirect()->route('promocode.index');
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
        $promocode = Promocode::findOrFail($id);
        return view('admin.promocode.show')->with('promocode',$promocode);
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
        $promocode = Promocode::findOrFail($id);
        return view('admin.promocode.edit')->with('promocode',$promocode);
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
            'code'                 => 'required',
            'discount'         => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'duration' => 'required',
            'active' => 'required',
        ]);
        //
        $promocodes = Promocode::find($id);
        $promocodes->name = $request->input('name');
        $promocodes->code = $request->input('code');
        $promocodes->discount = $request->input('discount');
        $promocodes->duration = $request->input('duration');
        $promocodes->active = $request->input('active');
        $promocodes->update();
        return redirect()->route('promocode.index');
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
        $promocode = Promocode::find($id);
        $promocode->delete();
        return redirect()->route('promocode.index');
    }
}
