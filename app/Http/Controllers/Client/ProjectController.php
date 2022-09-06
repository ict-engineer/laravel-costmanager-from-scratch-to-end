<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Project;
use App\Models\CClient;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Lang;

class ProjectController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!(Auth::user()->hasRole('Client')))
            return redirect()->route('user.profile');

        $agent = new Agent();  
        if($agent->isMobile())
            $i = -1;
        else
            $i = 1;
            
        $projects = Project::join('cclients', 'projects.cclient_id', '=', 'cclients.id')
            ->join('clients', 'clients.id', '=', 'cclients.client_id')
            ->select('projects.id as id', 'projects.name as name', 'projects.client as client')
            ->orderby('projects.cclient_id')
            ->get();

        if ($request->ajax()) {
            $data = Project::join('cclients', 'projects.cclient_id', '=', 'cclients.id')
                        ->join('clients', 'clients.id', '=', 'cclients.client_id')
                        ->select('projects.id as id', 'projects.name as name', 'projects.client as client')
                        ->orderby('projects.cclient_id')
                        ->get();

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a href="javascript:void(0)" class="editproject tooltipped" data-id="'.$row->id.'" data-position="bottom" data-tooltip="'.Lang::get('messages.Edit').'"><i class="material-icons">edit</i></a>';
   
                        if(!Auth::user()->hasPermissionTo('Employee Sales'))
                            $btn = $btn.'<a href="javascript:void(0)" class="remove-project tooltipped" data-id="'.$row->id.'" data-position="bottom" data-tooltip="'.Lang::get('messages.Delete').'"><i class="material-icons">delete</i></a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('user.client.project.index',compact('projects'), compact('i'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'name'  => ['required',
                        Rule::unique('projects')->ignore($request->typeid),],
            'client' => 'required',
        ]);

        $client_id = 0;
        if(Auth::user()->hasPermissionTo('Employee Administrative') || Auth::user()->hasPermissionTo('Employee Sales'))
            $client_id = Auth::user()->employee->client_id;
        else
            $client_id = Auth::user()->client->id;

        $cclient = CClient::where('name', $request->client)->where('client_id', $client_id)->first();
        Project::updateOrCreate(['id' => $request->typeid],
                ['name' => $request->name, 'client' => $request->client, 'cclient_id' => $cclient->id]);        
   
        return response()->json(['success'=>Lang::get('messages.Saved Successfully')]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $type = Project::find($id);
        return response()->json($type);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       Project::find($id)->delete();
     
       return response()->json(['success'=>Lang::get('messages.Deleted Successfully')]);
    }

    public function getProjectInfo(Request $request)
    {
        $client_id = 0;
        if(Auth::user()->hasPermissionTo('Employee Administrative') || Auth::user()->hasPermissionTo('Employee Sales'))
            $client_id = Auth::user()->employee->client_id;
        else
            $client_id = Auth::user()->client->id;

        
        $cclient = CClient::where('name', $request->name)->where('client_id', $client_id)->first();
        $projects = Project::where('cclient_id', $cclient->id)->pluck('name');

        return response()->json($projects);
    }
}
