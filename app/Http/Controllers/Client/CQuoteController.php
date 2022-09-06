<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\CQuote;
use App\Models\CClient;
use App\Models\Project;
use App\Models\QuoteGroup;
use App\Models\QuoteItem;
use App\Models\QuoteService;
use App\Models\QuoteMaterial;
use App\Models\Material;
use App\Models\CMaterial;
use App\Models\CService;
use App\Models\Employee;
use App\Models\QuoteEmployee;
use App\Models\FixedExpense;
use App\Models\QuoteComment;
use App\Models\Client;
use App\Models\PublicQuote;
use App\Shop;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Notifications\Notification;
use URL;
use Lang;
use Session;
use DateTime;
use Twilio\Rest\Client as TwilioClient;

class CQuoteController extends Controller
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

        $filter = $request->input();
        if(!isset($request['fromDate']))
        {
            $filter['fromDate'] = '2020/01/01';
            $filter['toDate'] = date('Y/m/d');
            if(!$request->ajax())
            {
                Session::put('quoteFromDate', '2020/01/01');
                Session::put('quotetoDate', date('Y/m/d'));
            }
        }
        else
        {
            Session::put('quoteFromDate', $filter['fromDate']);
            Session::put('quotetoDate', $filter['toDate']);
        }

        $client_id = 0;
        if(Auth::user()->hasPermissionTo('Employee Administrative') || Auth::user()->hasPermissionTo('Employee Sales'))
            $client_id = Auth::user()->employee->client_id;
        else
            $client_id = Auth::user()->client->id;
        $client = Client::find($client_id);
        
        $total = $cquotes = CQuote::join('projects', 'projects.id', '=', 'cquotes.project_id')
                ->join('cclients', 'cclients.id', '=', 'projects.cclient_id')
                ->select('cquotes.total as total')
                ->where('cclients.client_id', $client_id)
                ->where('cquotes.isQuote', true)
                ->where('cquotes.created_at', '>=', new DateTime($filter['fromDate']))
                ->where('cquotes.created_at', '<', date_add(new DateTime($filter['toDate']), date_interval_create_from_date_string('1 days')))
                ->sum('total');
        
        $cquotes = CQuote::join('projects', 'projects.id', '=', 'cquotes.project_id')
                ->join('cclients', 'cclients.id', '=', 'projects.cclient_id')
                ->select('cclients.name as client', 'projects.name as project', 'cquotes.id as id', 'cclients.addline as addline', 'cquotes.created_at as date', 'cquotes.total as total', 'cquotes.status as status', 'cquotes.quote_number as quote_number')
                ->where('cclients.client_id', $client_id)
                ->where('cquotes.isQuote', true)
                ->where('cquotes.created_at', '>=', new DateTime($filter['fromDate']))
                ->where('cquotes.created_at', '<', date_add(new DateTime($filter['toDate']), date_interval_create_from_date_string('1 days')))
                ->orderby('projects.id', 'DESC')->get();
        if ($request->ajax()) {
            $data = CQuote::join('projects', 'projects.id', '=', 'cquotes.project_id')
                ->join('cclients', 'cclients.id', '=', 'projects.cclient_id')
                ->select('cclients.name as client', 'projects.name as project', 'cquotes.id as id', 'cclients.addline as addline', 'cquotes.created_at as date', 'cquotes.total as total', 'cquotes.status as status', 'cquotes.quote_number as quote_number')
                ->where('cclients.client_id', $client_id)
                ->where('cquotes.isQuote', true)
                ->where('cquotes.created_at', '>=', new DateTime(Session::get('quoteFromDate')))
                ->where('cquotes.created_at', '<', date_add(new DateTime(Session::get('quotetoDate')), date_interval_create_from_date_string('1 days')))
                ->orderby('projects.id', 'DESC')->get();
            return Datatables::of($data)
                    ->editColumn('total', function($row) use($filter){
                        return '$'.number_format($row->total, 2, '.', ',');
                    })
                    ->editColumn('date', function($row){
                        return date('M d,Y', strtotime($row->date));
                    })
                    ->editColumn('addline', function($row){
                        return '<a href="javascript:void(0)" class="addlineMap">'.$row->addline.'</a>';
                    })
                    ->editColumn('quote_number', function($row){
                        $pad = "0000000";
                        $str = $row->quote_number;
                        
                        if(strlen($str) < 7)
                            $str = substr($pad, 0, strlen($pad) - strlen($str)).$str;
                        return $str;
                    })
                    ->addColumn('action', function($row){
                        $btn = '';
                        if(Session::get('isMexican') != 'yes')
                            $btn = $btn.'<a href="/user/generateInvoice/'.$row->id.'" data-id="'.$row->id.'" class="generateInvoice tooltipped data-position="bottom" data-tooltip="'.Lang::get('messages.Generate Invoice').'"><i class="material-icons">assignment</i></a>';
                        $btn = $btn.'<a href="/user/duplicateQuote/'.$row->id.'" data-id="'.$row->id.'" class="duplicateQuote tooltipped data-position="bottom" data-tooltip="'.Lang::get('messages.Duplicate Quote').'"><i class="material-icons">content_copy</i></a>';
                        $btn = $btn.'<a href="/user/clientquotes/'.$row->id.'" class="previewquote tooltipped data-position="bottom" data-tooltip="'.Lang::get('messages.Preview').'"><i class="material-icons">vignette</i></a>';
                        $btn = $btn.'<a href="/user/clientquotes/'.$row->id.'/edit" class="editquote tooltipped data-position="bottom" data-tooltip="'.Lang::get('messages.Edit').'"><i class="material-icons">edit</i></a>';
   
                        if(!Auth::user()->hasPermissionTo('Employee Sales'))
                            $btn = $btn.'<a href="javascript:void(0)" class="remove-quote tooltipped" data-id="'.$row->id.'" data-position="bottom" data-tooltip="'.Lang::get('messages.Delete').'"><i class="material-icons">delete</i></a>';
                        return $btn;
                    })
                    ->editColumn('status', function($row){
                        $comments = QuoteComment::where('cquote_id', $row->id)->where('isQuote', true)->latest()->get();

                        $addCom = '<div style="position:relative;width: 150px;" data-id="'.$row->id.'">';

                        if(count($comments))
                        {
                            $addCom = $addCom . '<div class="add-update-quote"><i class="material-icons" style="font-size:10px;">chat</i></div>';
                        }
                        else
                        {
                            $addCom = $addCom . '<div class="add-update-quote">+</div>';
                        }
                        
                        $addCom = $addCom.'<div class="quote_comment_div" style="display:none;">
                                    <div class="row" style="margin: 0px;">
                                        <div class="col s12" style="padding: 15px;">
                                            <div class="quote-comments">';
                        foreach($comments as $comment)
                        {
                            $addCom = $addCom.'<div class="justify-content-end display-flex">'.date('M d,Y', strtotime($comment->created_at)).'</div>';
                            $addCom = $addCom.'<div style="white-space: initial;word-wrap: break-word;width: 100%;">'.$comment->content.'</div>';
                        }
                        $addCom = $addCom.'</div>
                                            <div class="divider mt-3 mb-3"></div>
                                            <div class="input-field mb-0">
                                                <textarea class="materialize-textarea" style="box-shadow: 0 0px 0 0 #00bcd4;"></textarea>
                                                <label>'.Lang::get('messages.Comment').'</label>
                                            </div>
                                            <div class="display-flex justify-content-end">
                                                <button class="btn indigo btnSaveComment">Add</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>';

                        if(count($comments))
                        {
                            $addCom = $addCom . '<div class="quote_state_'.$row->status.' curl-top-right-comment">'.Lang::get('messages.'.$row->status).'</div>';
                        }
                        else
                        {
                            $addCom = $addCom . '<div class="quote_state_'.$row->status.' curl-top-right">'.Lang::get('messages.'.$row->status).'</div>';
                        }
                                
                        $addCom = $addCom.'<div class="quote-status-div" style="display:none;"><ul class="quote-status-ul">
                                    <li class="quote_state_New" value="New">'.Lang::get('messages.New').'</li>
                                    <li class="quote_state_Working" value="Working">'.Lang::get('messages.Working').'</li>
                                    <li class="quote_state_Rejected" value="Rejected">'.Lang::get('messages.Rejected').'</li>
                                    <li class="quote_state_Done" value="Done">'.Lang::get('messages.Done').'</li>
                                    <li class="quote_state_Sent" value="Sent">'.Lang::get('messages.Sent').'</li>
                                    <li class="quote_state_Invoiced" value="Invoiced">'.Lang::get('messages.Invoiced').'</li>
                                    <li class="quote_state_Paid" value="Paid">'.Lang::get('messages.Paid').'</li>
                                </ul></div></div>';
                        return $addCom;
                    })
                    ->rawColumns(array('status', 'action', 'date', 'total', 'quote_number', 'addline'))
                    ->make(true);
        }
        $type = 'Quote';
        return view('user.client.cquote.index')->with('cquotes', $cquotes)->with('i', $i)->with('type', $type)->with('filter', $filter)->with('total', $total);
    }

    public function show($id)
    {
        $client_id = 0;
        if(Auth::user()->hasPermissionTo('Employee Administrative') || Auth::user()->hasPermissionTo('Employee Sales'))
            $client_id = Auth::user()->employee->client_id;
        else
            $client_id = Auth::user()->client->id;
        $type =  CQuote::join('projects', 'projects.id', '=', 'cquotes.project_id')
            ->join('cclients', 'cclients.id', '=', 'projects.cclient_id')
            ->select('cclients.name as client', 'cquotes.created_at as date', 'cclients.phone as phone', 'cclients.companyname as companyname', 'cclients.email as email', 'projects.name as project', 'cquotes.id as id', 'cclients.addline as addline'
            , 'cquotes.discount as discount', 'cquotes.unprevented as unprevented', 'cquotes.advance as advance', 'cquotes.shopdays as shopdays', 'cquotes.quote_number as quote_number')
            ->where('cclients.client_id', $client_id)
            ->where('cquotes.id', $id)
            ->orderby('projects.id', 'DESC')->first();

        $phoneTmp = $type['phone'];
        $countrycode = Str::substr($phoneTmp, 0, strlen($phoneTmp) - 10);
        $phone = Str::substr($phoneTmp, -10);
        $type['countryCode'] = $countrycode;
        $type['phone'] = '('.Str::substr($phone, 0, 3).') '.Str::substr($phone, 3, 3).'-'.Str::substr($phone, 6);
        $type['date'] = date('M d Y', strtotime($type['date']));

        $client = Client::find($client_id);
        $footerText = $client->companyname.'. '.$client->addline1.'. Tel.:+'.Str::substr(Auth::user()->phone, 0, strlen(Auth::user()->phone) - 10).' ('.Str::substr(Auth::user()->phone, -10, 3).') '.Str::substr(Auth::user()->phone, -7, 3).'-'.Str::substr(Auth::user()->phone, -4);

        $companyLogo = User::select('logoimage')->where('id', $client->user_id)->first();

        $employees = Employee::where('client_id', $client_id)->get();
        $providers = Shop::distinct()->where('name', '!=', null)->where('name', '!=', '')->pluck('name');

        return view('user.client.cquote.edit')->with('quote', $type)->with('employees', $employees)->with('showPreview', "show")->with('date', $type['date'])->with('footerText', $footerText)
            ->with('logoimage', $companyLogo->logoimage)->with('client', $client)->with('type', 'Quote')->with('providers', $providers);
    }
     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $client_id = 0;
        if(Auth::user()->hasPermissionTo('Employee Administrative') || Auth::user()->hasPermissionTo('Employee Sales'))
            $client_id = Auth::user()->employee->client_id;
        else
            $client_id = Auth::user()->client->id;

        $employees = Employee::where('client_id', $client_id)->get();

        $quote_number = 1;
        $cquote_number =  CQuote::join('projects', 'projects.id', '=', 'cquotes.project_id')
                ->join('cclients', 'cclients.id', '=', 'projects.cclient_id')
                ->select('cquotes.quote_number as no')
                ->where('cclients.client_id', $client_id)
                ->orderby('cquotes.quote_number', 'DESC')->first();
        if($cquote_number != null)
            $quote_number = $cquote_number->no + 1;

        $client = Client::find($client_id);
        $footerText = $client->companyname.'. '.$client->addline1.'. Tel.:+'.Str::substr(Auth::user()->phone, 0, strlen(Auth::user()->phone) - 10).' ('.Str::substr(Auth::user()->phone, -10, 3).') '.Str::substr(Auth::user()->phone, -7, 3).'-'.Str::substr(Auth::user()->phone, -4);

        $date = date('M d Y');

        $companyLogo = User::select('logoimage')->where('id', $client->user_id)->first();
        $providers = Shop::distinct()->where('name', '!=', null)->where('name', '!=', '')->pluck('name');

        return view('user.client.cquote.create')->with('employees', $employees)->with('quote_number', $quote_number)->with('date', $date)->with('footerText', $footerText)
                ->with('logoimage', $companyLogo->logoimage)->with('client', $client)->with('type', 'Quote')->with('providers', $providers);
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

        $cclient = CClient::where('name', $request->input('client'))->where('client_id', $client_id)->first();
        $ccid = 0;
        $pid = 0;
        if($cclient != null)
        {
            $ccid = $cclient->id;
            $project1 = Project::where('name', $request->input('project'))->where('cclient_id', $cclient->id)->first();
            
            if($project1 != null)
                $pid = $project1->id;
        }

        if($request->quoteNumber != null && $request->quoteNumber != '')
        {
            if($request->quoteNumber < 1)
                throw ValidationException::withMessages(['quoteNumber' => 'Please input quote number greater than 0']);

            $cquote = CQuote::join('projects', 'projects.id', '=', 'cquotes.project_id')
            ->join('cclients', 'cclients.id', '=', 'projects.cclient_id')
            ->select('cquotes.quote_number as no')
            ->where('isQuote', true)
            ->where('cclients.client_id', $client_id)
            ->orderby('cquotes.quote_number')->first();

            if($cquote != null && $request->quoteNumber < $cquote->no)
                throw ValidationException::withMessages(['quoteNumber' => 'Please input quote number greater than '.$cquote->no]);
            
            $cquote = CQuote::join('projects', 'projects.id', '=', 'cquotes.project_id')
                ->join('cclients', 'cclients.id', '=', 'projects.cclient_id')
                ->select('cquotes.quote_number as no')
                ->where('isQuote', true)
                ->where('cclients.client_id', $client_id)
                ->where('cquotes.quote_number', $request->quoteNumber)
                ->where('cquotes.id', '!=', $request->id)->first();
            if($cquote != null)
                throw ValidationException::withMessages(['quoteNumber' => 'The quote with this quote number exists.']);
        }

        $request->merge(['phonetmp' => $request->input('phone')]);
        $request->merge(['phone' => preg_replace('/[^0-9]/', '', $request->input('phone'))]);
        $phone = $request->input('phone');
        $request->merge(['phone' => '52' . $request->input('phone')]);
        if($request->input('email') == '' || $request->input('email') == null)
            $validator = request()->validate([
                'quoteNumber' => 'required',
                'client' => ['required',
                            'unique:cclients,name,'.$ccid.',id',],
                'phone' => ['required', 'min:11', 'numeric', 'unique:cclients,phone,'.$ccid.',id',
                                function ($attribute, $value, $fail) use ($phone) {
                                    if (strlen($phone) != 10) {
                                        $fail('Incorrect phone number.');
                                    }
                                },
                            ],
                'project' => ['required',
                            'unique:projects,name,'.$pid.',id',],
            ]);
        else
            $validator = request()->validate([
                'quoteNumber' => 'required',
                'client' => ['required',
                            'unique:cclients,name,'.$ccid.',id',],
                'phone' => ['required', 'min:11', 'numeric', 'unique:cclients,phone,'.$ccid.',id',
                                function ($attribute, $value, $fail) use ($phone) {
                                    if (strlen($phone) != 10) {
                                        $fail('Incorrect phone number.');
                                    }
                                },
                            ],
                'project' => ['required',
                            'unique:projects,name,'.$pid.',id',],
                'email' => 'email',
            ]);

        // foreach( $request->groups as $groupR)
        // {
        //     if($groupR['name'] == '' || $groupR['name'] == null)
        //     {
        //         throw ValidationException::withMessages(['field_name' => 'Please input all fields on table.']);
        //     }
        //     if(array_key_exists('items', $groupR))
        //     {
        //         foreach( $groupR['items'] as $itemR)
        //         {
        //             if($itemR['name'] == '' || $itemR['name'] == null ||
        //                 $itemR['quantity'] == '' || $itemR['quantity'] == null || $itemR['quantity'] == 'NaN' ||
        //                 $itemR['cost'] == '' || $itemR['cost'] == null || $itemR['cost'] == 'NaN' ||
        //                 $itemR['utility'] == '' || $itemR['utility'] == null || $itemR['utility'] == 'NaN' ||
        //                 $itemR['total'] == '' || $itemR['total'] == null || $itemR['total'] == 'NaN'){
        //                 throw ValidationException::withMessages(['field_name' => 'Please input all fields on table.']);
        //             }
        //             if(array_key_exists('materials', $itemR))
        //             {
        //                 foreach( $itemR['materials'] as $materialR)                
        //                 {
        //                     if($materialR['description'] == '' || $materialR['description'] == null ||
        //                         $materialR['quantity'] == '' || $materialR['quantity'] == null || $materialR['quantity'] == 'NaN' ||
        //                         $materialR['cost'] == '' || $materialR['cost'] == null || $materialR['cost'] == 'NaN' ||
        //                         $materialR['description'] == '' || $materialR['description'] == null ||
        //                         $materialR['provider'] == '' || $materialR['provider'] == null){
        //                         throw ValidationException::withMessages(['field_name' => 'Please input correct data on group table.']);
        //                     }
        //                 }
        //             }
        //         }
        //     }
        // }
        // if($request->services)
        //     foreach( $request->services as $service)
        //     {
        //         if($service['name'] == '' || $service['name'] == null ||
        //             $service['provider'] == '' || $service['provider'] == null ||
        //             $service['cost'] == '' || $service['cost'] == null || $service['cost'] == 'NaN' ||
        //             $service['utility'] == '' || $service['utility'] == null || $service['utility'] == 'NaN' ||
        //             $service['price'] == '' || $service['price'] == null || $service['price'] == 'NaN')
        //         {
        //             throw ValidationException::withMessages(['field_name' => 'Please input correct data on service table.']);
        //         }
        //     }
            
        // if($request->employees)
        //     foreach( $request->employees as $employee)
        //     {
        //         if($employee['name'] == '' || $employee['name'] == null ||
        //             $employee['cost'] == '' || $employee['cost'] == null || $employee['cost'] == 'NaN' ||
        //             $employee['hours'] == '' || $employee['hours'] == null || $employee['hours'] == 'NaN' ||
        //             $employee['total'] == '' || $employee['total'] == null || $employee['total'] == 'NaN')
        //         {
        //             throw ValidationException::withMessages(['field_name' => 'Please input correct data on employee table.']);
        //         }
        //     }

        if($cclient == null)
        {
            $cclient = CClient::create(
                ['name' => $request->input('client'), 'phone' => $request->input('phone'), 'email' => $request->input('email'), "companyname" => $request->input('companyname'), 'client_id' => $client_id, 'addline' => $request->input('addline')]);
            $project = Project::create([
                'name' => $request->input('project'),
                'client' => $request->input('client'),
                'cclient_id' => $cclient->id,
            ]);
        }
        else
        {
            $project = Project::where('name', $request->input('project'))->where('cclient_id', $cclient->id)->first();

            if($project == null)
            {
                $project = Project::create([
                    'name' => $request->input('project'),
                    'client' => $request->input('client'),
                    'cclient_id' => $cclient->id,
                ]);
            }
        }

        $quote_number = 1;
        if($request->quoteNumber != null && $request->quoteNumber != '')
            $quote_number = $request->quoteNumber;
        else
        {
            $cquote_number =  CQuote::join('projects', 'projects.id', '=', 'cquotes.project_id')
                    ->join('cclients', 'cclients.id', '=', 'projects.cclient_id')
                    ->select('cquotes.quote_number as no')
                    ->where('isQuote', true)
                    ->where('cclients.client_id', $client_id)
                    ->orderby('cquotes.quote_number', 'DESC')->first();
            if($cquote_number != null)
                $quote_number = $cquote_number->no + 1;
        }
        

        if($request->id == null || $request->id == "")
            $quote = CQuote::create(['project_id' => $project->id, 'total' => $request->total, 'advance' => $request->advance, 'discount' => $request->discount
            , 'unprevented' => $request->unprevented, 'shopdays' => $request->shopdays, 'quote_number' => $quote_number, 'status' => 'New',
            'isQuote' => true]);        
        else{
            $quote = CQuote::find($request->id);        
            $quote->project_id = $project->id;
            $quote->quote_number = $quote_number;
            $quote->total = $request->total;
            $quote->discount = $request->discount;
            $quote->advance = $request->advance;
            $quote->unprevented = $request->unprevented;
            $quote->shopdays = $request->shopdays;
            $quote->isQuote = true;
            $quote->update();
            QuoteGroup::where('cquote_id', $quote->id)->delete();
            QuoteService::where('cquote_id', $quote->id)->delete();
            QuoteEmployee::where('cquote_id', $quote->id)->delete();
        }
        $tmp = 0;
        foreach( $request->groups as $groupR)
        {
            $group = QuoteGroup::create([
                'name' => $groupR['name'],
                'cquote_id' => $quote->id,
                'color'=> $groupR['color'],
            ]);

            if(array_key_exists('items', $groupR))
            {
                foreach( $groupR['items'] as $itemR)
                {
                    $item = QuoteItem::create([
                        'name' => $itemR['name'],
                        'quantity' => $itemR['quantity'],
                        'cost' => $itemR['cost'],
                        'utility' => $itemR['utility'],
                        'total' => $itemR['total'],
                        'quote_group_id' => $group['id'],
                    ]);
                    if(array_key_exists('materials', $itemR))
                        foreach( $itemR['materials'] as $materialR)
                        {
                            
                            $mat = Material::join('shops', 'shops.id', '=', 'materials.shop_id')->join('providers', 'providers.id', '=', 'shops.provider_id')
                                    ->select('materials.id as id')
                                    ->where('materials.description', $materialR['description'])->where('materials.price', $materialR['cost'])
                                    ->where('shops.name', $materialR['provider'])->first();

                            if($mat == null)
                            {
                                $mat1 = CMaterial::where('description', $materialR['description'])->where('price', $materialR['cost'])->where('client_id', $client_id)->first();
                                if($mat1 == null)
                                {
                                    $mat2 = CMaterial::create([
                                        "provider" => $materialR['provider'],
                                        "description" => $materialR['description'],
                                        "price" => $materialR['cost'],
                                        "client_id" => $client_id,
                                    ]);
                                    $material = QuoteMaterial::create([
                                        "material_id" => $mat2->id,
                                        "quantity" => $materialR['quantity'],
                                        "description" => $materialR['description'],
                                        "price" => $materialR['cost'],
                                        "provider" => $materialR['provider'],
                                        "isMine" => true,
                                        "quote_item_id" => $item->id,
                                    ]);
                                }
                                else
                                {
                                    $material = QuoteMaterial::create([
                                        "material_id" => $mat1->id,
                                        "quantity" => $materialR['quantity'],
                                        "description" => $materialR['description'],
                                        "price" => $materialR['cost'],
                                        "provider" => $materialR['provider'],
                                        "isMine" => true,
                                        "quote_item_id" => $item->id,
                                    ]);
                                }
                            }
                            else{
                                $tmp ++;
                                $material = QuoteMaterial::create([
                                    "material_id" => $mat->id,
                                    "quantity" => $materialR['quantity'],
                                    "isMine" => false,
                                    "description" => $materialR['description'],
                                    "price" => $materialR['cost'],
                                    "provider" => $materialR['provider'],
                                    "quote_item_id" => $item->id,
                                ]);
                            }
                        }
                }
            }
        }
        if($request->services)
        {
            foreach($request->services as $service)
            {
                $cservice = CService::where('name', $service['name'])->first();
                if($cservice == null)
                {
                    $cservice = CService::create([
                        'name' => $service['name'],
                        'provider' => $service['provider'],
                        'cost' => $service['cost'],
                        'utility' => $service['utility'],
                        'price' => $service['price'],
                        'client_id' => $client_id,
                    ]);
                }
                QuoteService::create([
                    'name' => $service['name'],
                    'provider' => $service['provider'],
                    'cost' => $service['cost'],
                    'utility' => $service['utility'],
                    'price' => $service['price'],
                    'cservice_id' => $cservice->id,
                    'cquote_id' => $quote->id,
                ]);
            }
        }

        if($request->employees)
        {
            foreach($request->employees as $employee)
            {
                $cemployee = Employee::where('name', $employee['name'])->first();
                QuoteEmployee::create([
                    'name' => $employee['name'],
                    'cost' => $employee['cost'],
                    'hours' => $employee['hours'],
                    'total' => $employee['total'],
                    'employee_id' => $cemployee->id,
                    'cquote_id' => $quote->id,
                ]);
            }
        }
            
        return response()->json(['success'=>Lang::get('messages.Saved Successfully'), 'quoteId' => $quote->id]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client_id = 0;
        if(Auth::user()->hasPermissionTo('Employee Administrative') || Auth::user()->hasPermissionTo('Employee Sales'))
            $client_id = Auth::user()->employee->client_id;
        else
            $client_id = Auth::user()->client->id;
        $type =  CQuote::join('projects', 'projects.id', '=', 'cquotes.project_id')
            ->join('cclients', 'cclients.id', '=', 'projects.cclient_id')
            ->select('cclients.name as client', 'cquotes.created_at as date', 'cclients.phone as phone', 'cclients.companyname as companyname', 'cclients.email as email', 'projects.name as project', 'cquotes.id as id', 'cclients.addline as addline'
            , 'cquotes.discount as discount', 'cquotes.unprevented as unprevented', 'cquotes.advance as advance', 'cquotes.shopdays as shopdays', 'cquotes.quote_number as quote_number')
            ->where('cclients.client_id', $client_id)
            ->where('cquotes.id', $id)
            ->orderby('projects.id', 'DESC')->first();

        $phoneTmp = $type['phone'];
        $countrycode = Str::substr($phoneTmp, 0, strlen($phoneTmp) - 10);
        $phone = Str::substr($phoneTmp, -10);
        $type['countryCode'] = $countrycode;
        $type['phone'] = '('.Str::substr($phone, 0, 3).') '.Str::substr($phone, 3, 3).'-'.Str::substr($phone, 6);
        $type['date'] = date('M d Y', strtotime($type['date']));

        $client_id = 0;
        if(Auth::user()->hasPermissionTo('Employee Administrative') || Auth::user()->hasPermissionTo('Employee Sales'))
            $client_id = Auth::user()->employee->client_id;
        else
            $client_id = Auth::user()->client->id;

        $client = Client::find($client_id);
        $footerText = $client->companyname.'. '.$client->addline1.'. Tel.:+'.Str::substr(Auth::user()->phone, 0, strlen(Auth::user()->phone) - 10).' ('.Str::substr(Auth::user()->phone, -10, 3).') '.Str::substr(Auth::user()->phone, -7, 3).'-'.Str::substr(Auth::user()->phone, -4);
        $employees = Employee::where('client_id', $client_id)->get();

        $client_info = Client::find($client_id);
        $companyLogo = User::select('logoimage')->where('id', $client_info->user_id)->first();
        $providers = Shop::distinct()->where('name', '!=', null)->where('name', '!=', '')->pluck('name');

        return view('user.client.cquote.edit')->with('quote', $type)->with('employees', $employees)->with('date', $type['date'])->with('footerText', $footerText)
            ->with('logoimage', $companyLogo->logoimage)->with('client', $client)->with('type', 'Quote')->with('providers', $providers);
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
        $client_id = 0;
        if(Auth::user()->hasPermissionTo('Employee Administrative') || Auth::user()->hasPermissionTo('Employee Sales'))
            $client_id = Auth::user()->employee->client_id;
        else
            $client_id = Auth::user()->client->id;

        $cclient = CClient::where('name', $request->input('client'))->where('client_id', $client_id)->first();
        $ccid = 0;
        $pid = 0;
        if($cclient != null)
        {
            $ccid = $cclient->id;
            $project1 = Project::where('name', $request->input('project'))->where('cclient_id', $cclient->id)->first();
            
            if($project1 != null)
                $pid = $project1->id;
        }

        $request->merge(['phonetmp' => $request->input('phone')]);
        $request->merge(['phone' => preg_replace('/[^0-9]/', '', $request->input('phone'))]);
        $phone = $request->input('phone');
        $request->merge(['phone' => '52' . $request->input('phone')]);
        if($request->input('email') == '' || $request->input('email') == null)
            request()->validate([
                'client' => ['required',
                            'unique:cclients,name,'.$ccid.',id',],
                'phone' => ['required', 'min:11', 'numeric', 'unique:cclients,phone,'.$ccid.',id',
                                function ($attribute, $value, $fail) use ($phone) {
                                    if (strlen($phone) != 10) {
                                        $fail('Incorrect phone number.');
                                    }
                                },
                            ],
                'project' => ['required',
                            'unique:projects,name,'.$pid.',id',],
            ]);
        else
            request()->validate([
                'client' => ['required',
                            'unique:cclients,name,'.$ccid.',id',],
                'phone' => ['required', 'min:11', 'numeric', 'unique:cclients,phone,'.$ccid.',id',
                                function ($attribute, $value, $fail) use ($phone) {
                                    if (strlen($phone) != 10) {
                                        $fail('Incorrect phone number.');
                                    }
                                },
                            ],
                'project' => ['required',
                            'unique:projects,name,'.$pid.',id',],
                'email' => 'email',
            ]);

        

        if($cclient == null)
        {
            $cclient = CClient::create(
                ['name' => $request->input('client'), 'phone' => $request->input('phone'), 'email' => $request->input('email'), "companyname" => $request->input('companyname'), 'client_id' => $client_id,]);
            $project = Project::create([
                'name' => $request->input('project'),
                'client' => $request->input('client'),
                'cclient_id' => $cclient->id,
            ]);
        }
        else
        {
            $project = Project::where('name', $request->input('project'))->where('cclient_id', $cclient->id)->first();

            if($project == null)
            {
                $project = Project::create([
                    'name' => $request->input('project'),
                    'client' => $request->input('client'),
                    'cclient_id' => $cclient->id,
                ]);
            }
        }

        $quote = CQuote::find($id);        
        $quote->project_id = $project->id;
        $quote->update();
  
        return redirect()->route('user.clientquotes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       CQuote::find($id)->delete();
     
       return response()->json(['success'=>Lang::get('messages.Deleted Successfully')]);
    }

    public function getQuoteInfo(Request $request)
    {
        $groups = [];

        $qGroups = QuoteGroup::where('cquote_id', $request->id)->oldest()->get();
        foreach ($qGroups as $qGroup)
        {
            $group = null;
            $group['name'] = $qGroup->name;
            $group['color'] = $qGroup->color;
            $items = [];

            $qItems = QuoteItem::where('quote_group_id', $qGroup->id)->oldest()->get();
            foreach ($qItems as $qItem)
            {
                $item = null;
                $item['name'] = $qItem->name;
                $item['quantity'] = $qItem->quantity;
                $item['cost'] = $qItem->cost;
                $item['utility'] = $qItem->utility;
                $item['total'] = $qItem->total;
                $materials = [];
                $qMaterials = QuoteMaterial::where('quote_item_id', $qItem->id)->oldest()->get();
                foreach($qMaterials as $qMaterial)
                {
                    $material = null;
                    $material['name'] = $qMaterial->description;
                    $material['quantity'] = $qMaterial->quantity;
                    $material['cost'] = $qMaterial->price;
                    $material['provider'] = $qMaterial->provider;
                    $material['total'] = $qMaterial->price * $qMaterial->quantity;
                    array_push($materials, $material);
                }
                $item['materials'] = $materials;
                array_push($items, $item);
            }
            $group['items'] = $items;
            array_push($groups, $group);
        }

        $services = [];
        $qservices = QuoteService::where('cquote_id', $request->id)->oldest()->get();
        foreach($qservices as $service)
        {
            $item = null;
            $item['name'] = $service->name;
            $item['provider'] = $service->provider;
            $item['cost'] = $service->cost;
            $item['utility'] = $service->utility;
            $item['price'] = $service->price;
            array_push($services, $item);
        }

        $employees = [];
        $qemployees = QuoteEmployee::where('cquote_id', $request->id)->oldest()->get();
        foreach($qemployees as $employee)
        {
            $item = null;
            $item['name'] = $employee->name;
            $item['hours'] = $employee->hours;
            $item['cost'] = $employee->cost;
            $item['total'] = $employee->total;
            array_push($employees, $item);
        }

        return response()->json(['data'=>$groups, 'services' => $services, 'employees' => $employees]);
    }

    public function getAllCServices()
    {
        $client_id = 0;
        if(Auth::user()->hasPermissionTo('Employee Administrative') || Auth::user()->hasPermissionTo('Employee Sales'))
            $client_id = Auth::user()->employee->client_id;
        else
            $client_id = Auth::user()->client->id;

        $cservices = CService::where('client_id', $client_id)->get();
        return response()->json($cservices);
    }

    public function getFixedExpenseSum()
    {
        $client_id = 0;
        if(Auth::user()->hasPermissionTo('Employee Administrative') || Auth::user()->hasPermissionTo('Employee Sales'))
            $client_id = Auth::user()->employee->client_id;
        else
            $client_id = Auth::user()->client->id;

        $fixed = FixedExpense::where('client_id', $client_id)->get();

        $total = 0;
        foreach( $fixed as $item)
        {
            if($item->cycle == 'Weekly')
                $total = $total + $item->cost / 7;
            else if($item->cycle == 'Monthly')
                $total = $total + $item->cost / 31.5;
            else if($item->cycle == 'Annual')
                $total = $total + $item->cost / 365;
        }
        return response()->json($total);
    }

    public function updateQuoteStatus(Request $request)
    {
        $cquote = CQuote::find($request->id);
        $cquote->status = $request->status;
        $cquote->update();
        return response()->json(['success'=>'success']);
    }

    public function saveQuoteComment(Request $request)
    {
        $names = explode(' ', Auth::user()->name);
        $content = $names[0].' wrote: '.$request->content;
        $isQuote = true;
        if($request->type == 'Invoice')
            $isQuote = false;
        $comment = QuoteComment::create([
            'content' => $content,
            'isQuote' => $isQuote,
            'cquote_id' => $request->quoteId,
        ]);
        return response()->json(['date'=> date('M d,Y', strtotime($comment->created_at)), 'text' => $content]);   
    }

    public function sendByMail(Request $request)
    {
        request()->validate([
            'from'  => 'required',
            'to' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ]);

        $name = md5($request->quoteId . time());
        PublicQuote::create([
            'name' => $name,
            'quote_id' => $request->quoteId,
            'showMaterial' => $request->showMaterial,
            'showEmployee' => $request->showEmployee,
            'showService' => $request->showService,
            'showOnlyTotal' => $request->showOnlyTotal,
            'content' => $request->messageContent,
        ]);
        $cquote = CQuote::find($request->quoteId);
        $project = Project::find($cquote->project_id);
        $names = explode(' ', $project->client);
        try{
            User::sendQuoteByEmail($request, $names[0], '/public_quote/'.$name);
        }catch(\Throwable $th)
        {
            return response()->json(['success' =>  'Failed.']);
        }

        $quote = CQuote::find($request->quoteId);
        if($request->type == 'Quote')
            $quote->status = 'Sent';
        else
            $quote->invoice_status = 'Sent';

        $quote->update();

        return response()->json(['success' => 'Sent Successfully.']);
    }

    public function sendByWhatsapp(Request $request)
    {
        PublicQuote::create([
            'name' => $request->urlName,
            'quote_id' => $request->quoteId,
            'showMaterial' => $request->showMaterial,
            'showEmployee' => $request->showEmployee,
            'showService' => $request->showService,
            'showOnlyTotal' => $request->showOnlyTotal,
            'content' => $request->messageContent,
        ]);

        // $twilio = new TwilioClient(config('services.twilio.sid'), config('services.twilio.token'));

        // try {
        //     $twilio->messages->create('whatsapp:' . '+52'.$request->whatsappnumber, [
        //         "from" => 'whatsapp:' . '+'.Auth::user()->phone,
        //         "body" => 'To see the quote, visit here:'.URL::to('/public_quote/'.$name),
        //     ]);
        // }catch(\Throwable $th)
        // {
        //     return response()->json(['success' =>  'Failed.']);
        // }

        if($request->isSend == 1)
        {
            $quote = CQuote::find($request->quoteId);
            if($request->type == 'Quote')
                $quote->status = 'Sent';
            else
                $quote->invoice_status = 'Sent';
            $quote->update();
        }
        return response()->json(['success' => 'Sent Successfully.']);
    }

    public function generateInvoice($id)
    {
        $quote = CQuote::find($id);
        $quote->isInvoice = true;
        $invoice_number = 1;
        $client_id = 0;
        if(Auth::user()->hasPermissionTo('Employee Administrative') || Auth::user()->hasPermissionTo('Employee Sales'))
            $client_id = Auth::user()->employee->client_id;
        else
            $client_id = Auth::user()->client->id;
        $cinvoice_number =  CQuote::join('projects', 'projects.id', '=', 'cquotes.project_id')
                ->join('cclients', 'cclients.id', '=', 'projects.cclient_id')
                ->select('cquotes.invoice_number as no')
                ->where('cclients.client_id', $client_id)
                ->orderby('cquotes.invoice_number', 'DESC')->first();
        if($cinvoice_number != null)
            $invoice_number = $cinvoice_number->no + 1;
        $quote->invoice_number = $invoice_number;
        $quote->status = 'Invoiced';
        $quote->update();

        return response()->json(['url' => 'clientinvoices/' . $id . '/edit']);
    }

    public function duplicateQuote(Request $request)
    {
        $client_id = 0;
        if(Auth::user()->hasPermissionTo('Employee Administrative') || Auth::user()->hasPermissionTo('Employee Sales'))
            $client_id = Auth::user()->employee->client_id;
        else
            $client_id = Auth::user()->client->id;

        $quote_number = 1;
        $quote = CQuote::find($request->id);
        $new_quote = $quote->replicate();
        if($request->type =="Quote")
        {
            $cquote_number =  CQuote::join('projects', 'projects.id', '=', 'cquotes.project_id')
                ->join('cclients', 'cclients.id', '=', 'projects.cclient_id')
                ->select('cquotes.quote_number as no')
                ->where('cclients.client_id', $client_id)
                ->orderby('cquotes.quote_number', 'DESC')->first();
            if($cquote_number != null)
                $quote_number = $cquote_number->no + 1;
            $new_quote->isInvoice = 0;
            $new_quote->isQuote = 1;    
        }
        else
        {
            $cinvoice_number =  CQuote::join('projects', 'projects.id', '=', 'cquotes.project_id')
                ->join('cclients', 'cclients.id', '=', 'projects.cclient_id')
                ->select('cquotes.invoice_number as no')
                ->where('cclients.client_id', $client_id)
                ->orderby('cquotes.invoice_number', 'DESC')->first();
            if($cinvoice_number != null)
                $quote_number = $cinvoice_number->no + 1;
                
            $new_quote->isInvoice = 1;
            $new_quote->isQuote = 0;
        }
        
        $new_quote->status = 'New';
        $new_quote->invoice_status = 'New';
        $new_quote->quote_number = $quote_number;
        $new_quote->save();
        

        $quotegroups = QuoteGroup::where('cquote_id', $request->id)->get();
        $quotecomments = QuoteComment::where('cquote_id', $request->id)->get();
        $quoteservices = QuoteService::where('cquote_id', $request->id)->get();
        $quoteemployees = QuoteEmployee::where('cquote_id', $request->id)->get();
        foreach($quotegroups as $quotegroup)
        {
            $new_quotegroup = $quotegroup->replicate();
            $new_quotegroup->cquote_id = $new_quote->id;
            $new_quotegroup->save();

            $quoteitems = QuoteItem::where('quote_group_id', $quotegroup->id)->get();

            foreach($quoteitems as $quoteitem)
            {
                $new_quoteitem = $quoteitem->replicate();
                $new_quoteitem->quote_group_id = $new_quotegroup->id;
                $new_quoteitem->save();

                $quotematerials = QuoteMaterial::where('quote_item_id', $quoteitem->id)->get();
                foreach($quotematerials as $quotematerial)
                {
                    $new_quotematerial = $quotematerial->replicate();
                    $new_quotematerial->quote_item_id = $new_quoteitem->id;
                    $new_quotematerial->save();
                }
            }
        }
        foreach($quotecomments as $quotecomment)
        {
            $new_quotecomment = $quotecomment->replicate();
            $new_quotecomment->cquote_id = $new_quote->id;
            $new_quotecomment->save();
        }
        foreach($quoteservices as $quoteservice)
        {
            $new_quoteservice = $quoteservice->replicate();
            $new_quoteservice->cquote_id = $new_quote->id;
            $new_quoteservice->save();
        }
        foreach($quoteemployees as $quoteemployee)
        {
            $new_quoteemployee = $quoteemployee->replicate();
            $new_quoteemployee->cquote_id = $new_quote->id;
            $new_quoteemployee->save();
        }
        return response()->json(['text' => 'success']);
    }

    public function getDuplicateId(Request $request)
    {
        $client_id = 0;
        if(Auth::user()->hasPermissionTo('Employee Administrative') || Auth::user()->hasPermissionTo('Employee Sales'))
            $client_id = Auth::user()->employee->client_id;
        else
            $client_id = Auth::user()->client->id;

        $quote_number = 1;
        if($request->type =="Quote")
        {
            $cquote_number =  CQuote::join('projects', 'projects.id', '=', 'cquotes.project_id')
                ->join('cclients', 'cclients.id', '=', 'projects.cclient_id')
                ->select('cquotes.quote_number as no')
                ->where('cclients.client_id', $client_id)
                ->orderby('cquotes.quote_number', 'DESC')->first();
            if($cquote_number != null)
                $quote_number = $cquote_number->no + 1;
        }
        else
        {
            $cinvoice_number =  CQuote::join('projects', 'projects.id', '=', 'cquotes.project_id')
                ->join('cclients', 'cclients.id', '=', 'projects.cclient_id')
                ->select('cquotes.invoice_number as no')
                ->where('cclients.client_id', $client_id)
                ->orderby('cquotes.invoice_number', 'DESC')->first();
            if($cinvoice_number != null)
                $quote_number = $cinvoice_number->no + 1;
        }

        return response()->json(['number' => $quote_number]);
    }
}



