<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\CService;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Lang;

class CServiceController extends Controller
{
    //
    public function index(Request $request)
    {
        if(!(Auth::user()->hasRole('Client')))
            return redirect()->route('user.profile');
        
        $client_id = 0;
        if(Auth::user()->hasPermissionTo('Employee Administrative') || Auth::user()->hasPermissionTo('Employee Sales'))
            $client_id = Auth::user()->employee->client_id;
        else
            $client_id = Auth::user()->client->id;

        $agent = new Agent();  
        if($agent->isMobile())
            $i = -1;
        else
            $i = 1;

        $services = CService::where('client_id', $client_id)->latest()->get();

        if ($request->ajax()) {
            $data = CService::where('client_id', $client_id)->latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('cost', function($row){
                        return '$'.number_format($row->cost, 2, '.', ',');
                    })
                    ->editColumn('price', function($row){
                        return '$'.number_format($row->price, 2, '.', ',');
                    })
                    ->editColumn('utility', function($row){
                        return $row->utility.'%';
                    })
                    ->addColumn('action', function($row){
                        $btn = '<a href="javascript:void(0)" class="editservices tooltipped" data-id="'.$row->id.'" data-position="bottom" data-tooltip="'.Lang::get('messages.Edit').'"><i class="material-icons">edit</i></a>';
   
                        if(!Auth::user()->hasPermissionTo('Employee Sales'))
                            $btn = $btn.'<a href="javascript:void(0)" class="remove-services tooltipped" data-id="'.$row->id.'" data-position="bottom" data-tooltip="'.Lang::get('messages.Delete').'"><i class="material-icons">delete</i></a>';
                        return $btn;
                    })
                    ->rawColumns(array('action', 'cost'))
                    ->make(true);
        }
      
        return view('user.client.cservice.index',compact('services'), compact('i'));
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
                        Rule::unique('services')->ignore($request->typeid),],
            'cost'  =>  'required',
            'provider'  =>  'required',
            'utility'  =>  'required|numeric|max:99.99999999999999999',
            // 'expensetype' =>    'required',
        ]);

        $client_id = 0;
        if(Auth::user()->hasPermissionTo('Employee Administrative') || Auth::user()->hasPermissionTo('Employee Sales'))
            $client_id = Auth::user()->employee->client_id;
        else
            $client_id = Auth::user()->client->id;
        $price = $request->cost / (100 - $request->utility) * 100;
        CService::updateOrCreate(['id' => $request->typeid],
                ['name' => $request->name, 'cost' => $request->cost, 'utility' => $request->utility, 'provider' => $request->provider, 'price' => $price, 'client_id' => $client_id]);        
   
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
        
        $type = CService::find($id);
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
       CService::find($id)->delete();
     
       return response()->json(['success'=>Lang::get('messages.Deleted Successfully')]);
    }
}
