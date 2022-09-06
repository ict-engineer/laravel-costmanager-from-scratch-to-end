<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service;
use Jenssegers\Agent\Agent;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    //Check if user has list permission
    public function __construct()
    {
        $this->middleware(['permission:List Services']);
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
        
        $services = Service::orderby('id')->get();
        if($agent->isMobile())
            $i = -1;
        else
            $i = (request()->input('page', 1) - 1) * 10;
        return view('admin.service.index',compact('services'))
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
        return view('admin.service.create');
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
                Rule::unique('services'),
            ],
            'spanish'    => 'required',
            'french'    => 'required',
            'italian'    => 'required',
            'russian'    => 'required',
            'german'    => 'required',
        ]);
        //
        $data = $request->input();
        $newservice = Service::create([
            'name' => $data['name'],
            'spanish' => $data['spanish'],
            'french' => $data['french'],
            'italian' => $data['italian'],
            'russian' => $data['russian'],
            'german' => $data['german'],
        ]);
        return redirect()->route('services.index');
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
        $service = Service::findOrFail($id);
        return view('admin.service.show')->with('service',$service);
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
        $service = Service::findOrFail($id);
        return view('admin.service.edit')->with('service',$service);
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
                Rule::unique('services')->ignore($id),
            ],
            'spanish'    => 'required',
            'french'    => 'required',
            'italian'    => 'required',
            'russian'    => 'required',
            'german'    => 'required',
        ]);
        //
        $services = service::find($id);
        $services->name = $request->input('name');
        $services->spanish = $request->input('spanish');
        $services->french = $request->input('french');
        $services->italian = $request->input('italian');
        $services->russian = $request->input('russian');
        $services->german = $request->input('german');
        $services->update();
        return redirect()->route('services.index');
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
        $service = Service::find($id);
        $service->delete();
        return redirect()->route('services.index');
    }
}
