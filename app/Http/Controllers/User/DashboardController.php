<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Material;
use App\Models\Client;
use App\Models\CClient;
use App\Models\CQuote;
use Session;

class DashboardController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    //index

    public function index(Request $request)
    {
        if(Session::get('type') != 'Provider' && Session::get('type') != 'Client')
            return redirect()->route('user.selectType');
            
        if(Session::get('type') == 'Provider')
        {
            $shops = Auth::user()->provider->shops;
            $shopCount = count($shops);
            $materialCount = Material::join('shops', 'materials.shop_id', '=', 'shops.id')
                        ->where('shops.provider_id', '=', Auth::user()->provider->id)
                        ->count();
            return view('user.dashboard')->with('shopCount', $shopCount)->with('materialCount', $materialCount)->with('shops', $shops);
        }

        
        $isFirst = 'no';
        if(Session::get('isFirst') == 'yes')
        {
            $isFirst = 'yes';
            Session::put('isFirst', 'no');
        }
        
        $client_id = 0;
        if(Auth::user()->hasPermissionTo('Employee Administrative') || Auth::user()->hasPermissionTo('Employee Sales'))
            $client_id = Auth::user()->employee->client_id;
        else
            $client_id = Auth::user()->client->id;
        
        $client = Client::find($client_id);

        return view('user.client.dashboard')->with('isFirst', $isFirst)->with('userName', Auth::user()->name)
                    ->with('client', $client)
                    ->with('date', date('M d,Y', strtotime("+1 months", strtotime(date('Y-M-d')))));
    }

    public function getClientDashboardInfo(Request $request)
    {
        $client_id = 0;
        if(Auth::user()->hasPermissionTo('Employee Administrative') || Auth::user()->hasPermissionTo('Employee Sales'))
            $client_id = Auth::user()->employee->client_id;
        else
            $client_id = Auth::user()->client->id;
        
        $client = Client::find($client_id);

        $fromDate = $request->fromDate;
        $toDate = $request->toDate;
        
        $data['clients'] = number_format(CClient::where('client_id', $client_id)->whereDate('created_at', '>=',  date('Y-m-d h:m:s',strtotime($fromDate)))->whereDate('created_at', '<=',  date('Y-m-d h:m:s',strtotime($toDate)))->count(), 0, '', ',');
        $data['quotes'] = number_format(CQuote::join('projects', 'projects.id', '=', 'project_id')
                            ->join('cclients', 'cclients.id', '=', 'projects.cclient_id')
                            ->where('cclients.client_id', $client_id)->where('isQuote', 1)->whereDate('cquotes.created_at', '>=',  date('Y-m-d h:m:s',strtotime($fromDate)))->whereDate('cquotes.created_at', '<=',  date('Y-m-d h:m:s',strtotime($toDate)))->get()->sum('total'), 2, '.', ',');
        $data['invoices'] = number_format(CQuote::join('projects', 'projects.id', '=', 'project_id')
                                ->join('cclients', 'cclients.id', '=', 'projects.cclient_id')
                                ->where('cclients.client_id', $client_id)->where('isInvoice', 1)->whereDate('cquotes.created_at', '>=',  date('Y-m-d h:m:s',strtotime($fromDate)))->whereDate('cquotes.created_at', '<=',  date('Y-m-d h:m:s',strtotime($toDate)))->get()->sum('total'), 2, '.', ',');
        $data['paidInvoices'] = number_format(CQuote::join('projects', 'projects.id', '=', 'project_id')
                                ->join('cclients', 'cclients.id', '=', 'projects.cclient_id')
                                ->where('cclients.client_id', $client_id)->where('isInvoice', 1)->whereDate('cquotes.created_at', '>=',  date('Y-m-d h:m:s',strtotime($fromDate)))->whereDate('cquotes.created_at', '<=',  date('Y-m-d h:m:s',strtotime($toDate)))->where('invoice_status', 'Paid')->get()->sum('total'), 2, '.', ',');

        return response()->json(['data' => $data]);
    }

    public function setLatLng(Request $request)
    {
        $client_id = 0;
        if(Auth::user()->hasPermissionTo('Employee Administrative') || Auth::user()->hasPermissionTo('Employee Sales'))
            $client_id = Auth::user()->employee->client_id;
        else
            $client_id = Auth::user()->client->id;

        $client = Client::find($client_id);
        $client->lat = $request->lat;
        $client->lng = $request->lng;
        $client->update();
        
        return response()->json(['text', 'success']);
    }

    public function getGraphInfo(Request $request)
    {
        $fromDate = $request->fromDate;
        $toDate = $request->toDate;
        $labels = [];
        $quotes = [];
        $invoices = [];

        $client_id = 0;
        if(Auth::user()->hasPermissionTo('Employee Administrative') || Auth::user()->hasPermissionTo('Employee Sales'))
            $client_id = Auth::user()->employee->client_id;
        else
            $client_id = Auth::user()->client->id;

        if($request->isMonth)
        {
            for(;strtotime($fromDate) < strtotime($toDate); $fromDate = date('Y/m/d', strtotime("+1 Month", strtotime($fromDate))))
            {
                array_push($labels, $fromDate);
                array_push($quotes, CQuote::join('projects', 'projects.id', '=', 'cquotes.project_id')
                            ->join('cclients', 'cclients.id', '=', 'projects.cclient_id')
                            ->where('cclients.client_id', $client_id)->where('cquotes.isQuote', 1)->whereDate('cquotes.created_at', '<=',  date('Y-m-d h:m:s',strtotime($fromDate)))->get()->sum('total'));
                array_push($invoices, CQuote::join('projects', 'projects.id', '=', 'cquotes.project_id')
                            ->join('cclients', 'cclients.id', '=', 'projects.cclient_id')
                            ->where('cclients.client_id', $client_id)->where('cquotes.isInvoice', 1)->whereDate('cquotes.created_at', '<=',  date('Y-m-d h:m:s',strtotime($fromDate)))->get()->sum('total'));
            }
        }
        else
        {
            for(;strtotime($fromDate) < strtotime($toDate); $fromDate = date('Y/m/d', strtotime("+7 Day", strtotime($fromDate))))
            {
                array_push($labels, $fromDate);
                array_push($quotes, CQuote::join('projects', 'projects.id', '=', 'cquotes.project_id')
                            ->join('cclients', 'cclients.id', '=', 'projects.cclient_id')
                            ->where('cclients.client_id', $client_id)->where('cquotes.isQuote', 1)->whereDate('cquotes.created_at', '<=',  date('Y-m-d h:m:s',strtotime($fromDate)))->get()->sum('total'));
                array_push($invoices, CQuote::join('projects', 'projects.id', '=', 'cquotes.project_id')
                            ->join('cclients', 'cclients.id', '=', 'projects.cclient_id')
                            ->where('cclients.client_id', $client_id)->where('cquotes.isInvoice', 1)->whereDate('cquotes.created_at', '<=',  date('Y-m-d h:m:s',strtotime($fromDate)))->get()->sum('total'));
            }
        }
        
        array_push($labels, $toDate);
        array_push($quotes, CQuote::join('projects', 'projects.id', '=', 'cquotes.project_id')
                                ->join('cclients', 'cclients.id', '=', 'projects.cclient_id')
                                ->where('cclients.client_id', $client_id)->where('cquotes.isQuote', 1)->whereDate('cquotes.created_at', '<=',  date('Y-m-d h:m:s',strtotime($toDate)))->get()->sum('total'));
        array_push($invoices, CQuote::join('projects', 'projects.id', '=', 'cquotes.project_id')
                                ->join('cclients', 'cclients.id', '=', 'projects.cclient_id')
                                ->where('cclients.client_id', $client_id)->where('cquotes.isInvoice', 1)->whereDate('cquotes.created_at', '<=',  date('Y-m-d h:m:s',strtotime($toDate)))->get()->sum('total'));
        $data['labels'] = $labels;
        $data['quotes'] = $quotes;
        $data['invoices'] = $invoices;

        return response()->json(['data' => $data]);
    }

    public function setSessionValue(Request $request)
    {
        Session::put($request->key, $request->value);
        return response()->json(['success' => 'success']);
    }
}
