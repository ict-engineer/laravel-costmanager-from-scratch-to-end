<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\CClient;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Models\Project;
use Lang;

class CClientController extends Controller
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

        $cclients = CClient::where('client_id', $client_id)->latest()->get();

        if ($request->ajax()) {
            $data = CClient::where('client_id', $client_id)->latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('phone', function($row){
                        return '+'.Str::substr($row->phone, 0, strlen($row->phone) - 10).' ('.Str::substr($row->phone, strlen($row->phone) - 10, 3).') '.Str::substr($row->phone, strlen($row->phone) - 7, 3).'-'.Str::substr($row->phone, strlen($row->phone) - 4);
                    })
                    ->editColumn('addline', function($row){
                        return '<a href="javascript:void(0)" class="addlineMap">'.$row->addline.'</a>';
                    })
                    ->addColumn('action', function($row){
                        $btn = '<a href="javascript:void(0)" class="editcclients tooltipped" data-id="'.$row->id.'" data-position="bottom" data-tooltip="'.Lang::get('messages.Edit').'"><i class="material-icons">edit</i></a>';
                        
                        if(!Auth::user()->hasPermissionTo('Employee Sales'))
                            $btn = $btn.'<a href="javascript:void(0)" class="remove-cclients tooltipped" data-id="'.$row->id.'" data-position="bottom" data-tooltip="'.Lang::get('messages.Delete').'"><i class="material-icons">delete</i></a>';
                        return $btn;
                    })
                    ->rawColumns(array('phone', 'action', 'addline'))
                    ->make(true);
        }
      
        return view('user.client.cclient.index',compact('cclients'), compact('i'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $client_id = 0;
        if(Auth::user()->hasPermissionTo('Employee Administrative') || Auth::user()->hasPermissionTo('Employee Sales'))
            $client_id = Auth::user()->employee->client_id;
        else
            $client_id = Auth::user()->client->id;

        $request->merge(['phone' => preg_replace('/[^0-9]/', '', $request->input('phone'))]);
        $phone = $request->phone;
        $request->merge(['phone' => $request->input('countryCode') . $request->input('phone')]);
        request()->validate([
            'phone'  => ['required', 'min:11', 'numeric', 'unique:cclients,phone,'.$request->typeid.',id,client_id,'.$client_id,
                            function ($attribute, $value, $fail) use ($phone) {
                                if (strlen($phone) != 10) {
                                    $fail('Incorrect phone number.');
                                }
                            },
                        ],
            'name' => ['required',
                        'unique:cclients,name,'.$request->typeid.',id,client_id,'.$client_id],
        ]);
        
        CClient::updateOrCreate(['id' => $request->typeid],
                ['name' => $request->name, 'phone' => $request->phone, 'email' => $request->email, "companyname" => $request->companyname, 'client_id' => $client_id, 'addline' => $request->addline]);        
        
        if($request->typeid)
        {
            Project::where('cclient_id', $request->typeid)->update(['client' => $request->name]);
        }
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
        $type = CClient::find($id);
        $phoneTmp = $type['phone'];
        $countrycode = Str::substr($phoneTmp, 0, strlen($phoneTmp) - 10);
        $phone = Str::substr($phoneTmp, -10);
        $type['countryCode'] = $countrycode;
        $type['phone'] = '('.Str::substr($phone, 0, 3).') '.Str::substr($phone, 3, 3).'-'.Str::substr($phone, 6);
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
       CClient::find($id)->delete();
     
       return response()->json(['success'=>Lang::get('messages.Deleted Successfully')]);
    }

    public function getAll()
    {
        $client_id = 0;
        if(Auth::user()->hasPermissionTo('Employee Administrative') || Auth::user()->hasPermissionTo('Employee Sales'))
            $client_id = Auth::user()->employee->client_id;
        else
            $client_id = Auth::user()->client->id;
            
        $types = CClient::where('client_id', $client_id)->pluck('name');
        return  response()->json($types);
    }

    public function getClientInfobyName(Request $request)
    {
        $client_id = 0;
        if(Auth::user()->hasPermissionTo('Employee Administrative') || Auth::user()->hasPermissionTo('Employee Sales'))
            $client_id = Auth::user()->employee->client_id;
        else
            $client_id = Auth::user()->client->id;

        $cclient = CClient::where('name', $request->name)->where('client_id', $client_id)->first();
        if($cclient != null)
        {
            $phoneTmp = $cclient['phone'];
            $countrycode = Str::substr($phoneTmp, 0, strlen($phoneTmp) - 10);
            $phone = Str::substr($phoneTmp, -10);
            $cclient['countryCode'] = $countrycode;
            $cclient['phone'] = '('.Str::substr($phone, 0, 3).') '.Str::substr($phone, 3, 3).'-'.Str::substr($phone, 6);
        }

        return response()->json($cclient);
    }
}
