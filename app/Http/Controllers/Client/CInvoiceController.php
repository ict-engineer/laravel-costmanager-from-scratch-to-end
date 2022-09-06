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
use App\Shop;
use App\Models\PublicQuote;
use App\User;
use Session;
use DateTime;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Notifications\Notification;
use URL;
use Twilio\Rest\Client as TwilioClient;
use Lang;

class CInvoiceController extends Controller
{
    //
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
        
        $client_id = 0;
        if(Auth::user()->hasPermissionTo('Employee Administrative') || Auth::user()->hasPermissionTo('Employee Sales'))
            $client_id = Auth::user()->employee->client_id;
        else
            $client_id = Auth::user()->client->id;
        
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

        $total = $cquotes = CQuote::join('projects', 'projects.id', '=', 'cquotes.project_id')
                ->join('cclients', 'cclients.id', '=', 'projects.cclient_id')
                ->select('cquotes.total as total')
                ->where('cclients.client_id', $client_id)
                ->where('cquotes.isInvoice', true)
                ->where('cquotes.created_at', '>=', new DateTime($filter['fromDate']))
                ->where('cquotes.created_at', '<', date_add(new DateTime($filter['toDate']), date_interval_create_from_date_string('1 days')))
                ->sum('total');

        $cquotes = CQuote::join('projects', 'projects.id', '=', 'cquotes.project_id')
                ->join('cclients', 'cclients.id', '=', 'projects.cclient_id')
                ->select('cclients.name as client', 'projects.name as project', 'cquotes.id as id', 'cclients.addline as addline', 'cquotes.created_at as date', 'cquotes.total as total', 'cquotes.invoice_status as status', 'cquotes.invoice_number as quote_number')
                ->where('cclients.client_id', $client_id)
                ->where('cquotes.isInvoice', true)
                ->where('cquotes.created_at', '>=', new DateTime($filter['fromDate']))
                ->where('cquotes.created_at', '<', date_add(new DateTime($filter['toDate']), date_interval_create_from_date_string('1 days')))
                ->orderby('projects.id', 'DESC')->get();
        if ($request->ajax()) {
            $data = CQuote::join('projects', 'projects.id', '=', 'cquotes.project_id')
                ->join('cclients', 'cclients.id', '=', 'projects.cclient_id')
                ->select('cclients.name as client', 'projects.name as project', 'cquotes.id as id', 'cclients.addline as addline', 'cquotes.created_at as date', 'cquotes.total as total', 'cquotes.invoice_status as status', 'cquotes.invoice_number as quote_number')
                ->where('cclients.client_id', $client_id)
                ->where('cquotes.isInvoice', true)
                ->where('cquotes.created_at', '>=', new DateTime(Session::get('quoteFromDate')))
                ->where('cquotes.created_at', '<', date_add(new DateTime(Session::get('quotetoDate')), date_interval_create_from_date_string('1 days')))
                ->orderby('projects.id', 'DESC')->get();
            return Datatables::of($data)
                    ->editColumn('total', function($row){

                        return '$'.number_format($row->total, 2, '.', ',');
                    })
                    ->editColumn('date', function($row){
                        return date('M d,Y', strtotime($row->date));
                    })
                    ->editColumn('addline', function($row){
                        return '<a href="javascript:void(0)" class="addlineMap">'.$row->addline.'</a>';
                    })
                    ->addColumn('action', function($row){
                        $btn = '<a href="/user/duplicateQuote/'.$row->id.'" data-id="'.$row->id.'" class="duplicateQuote tooltipped data-position="bottom" data-tooltip="'.Lang::get('messages.Duplicate Invoice').'"><i class="material-icons">content_copy</i></a>';
                        $btn = $btn.'<a href="/user/clientinvoices/'.$row->id.'" class="previewquote tooltipped data-position="bottom" data-tooltip="'.Lang::get('messages.Preview').'"><i class="material-icons">vignette</i></a>';
                        $btn = $btn.'<a href="/user/clientinvoices/'.$row->id.'/edit" class="editquote tooltipped data-position="bottom" data-tooltip="'.Lang::get('messages.Edit').'"><i class="material-icons">edit</i></a>';
   
                        if(!Auth::user()->hasPermissionTo('Employee Sales'))
                            $btn = $btn.'<a href="javascript:void(0)" class="remove-quote tooltipped" data-id="'.$row->id.'" data-position="bottom" data-tooltip="'.Lang::get('messages.Delete').'"><i class="material-icons">delete</i></a>';
                        return $btn;
                    })
                    ->editColumn('quote_number', function($row){
                        $pad = "0000000";
                        $str = $row->quote_number;
                        
                        if(strlen($str) < 7)
                            $str = substr($pad, 0, strlen($pad) - strlen($str)).$str;
                        return $str;
                    })
                    ->editColumn('status', function($row){
                        $comments = QuoteComment::where('cquote_id', $row->id)->where('isQuote', false)->latest()->get();

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
                                    <li class="quote_state_Sent" value="Sent">'.Lang::get('messages.Sent').'</li>
                                    <li class="quote_state_Paid" value="Paid">'.Lang::get('messages.Paid').'</li>
                                    <li class="quote_state_Canceled" value="Canceled">'.Lang::get('messages.Canceled').'</li>
                                </ul></div></div>';
                        return $addCom;
                    })
                    ->rawColumns(array('status', 'action', 'date', 'total', 'quote_number', 'addline'))
                    ->make(true);
        }
        return view('user.client.cquote.index')->with('cquotes', $cquotes)->with('i', $i)->with('type', 'Invoice')->with('filter', $filter)->with('total', $total);
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
            , 'cquotes.discount as discount', 'cquotes.unprevented as unprevented', 'cquotes.advance as advance', 'cquotes.shopdays as shopdays', 'cquotes.invoice_number as quote_number')
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
            ->with('logoimage', $companyLogo->logoimage)->with('client', $client)->with('type', 'Invoice')->with('providers', $providers);
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

        $invoice_number = 1;
        $cinvoice_number =  CQuote::join('projects', 'projects.id', '=', 'cquotes.project_id')
                ->join('cclients', 'cclients.id', '=', 'projects.cclient_id')
                ->select('cquotes.invoice_number as no')
                ->where('cclients.client_id', $client_id)
                ->orderby('cquotes.invoice_number', 'DESC')->first();
        if($cinvoice_number != null)
            $invoice_number = $cinvoice_number->no + 1;

        $client = Client::find($client_id);
        $footerText = $client->companyname.'. '.$client->addline1.'. Tel.:+'.Str::substr(Auth::user()->phone, 0, strlen(Auth::user()->phone) - 10).' ('.Str::substr(Auth::user()->phone, -10, 3).') '.Str::substr(Auth::user()->phone, -7, 3).'-'.Str::substr(Auth::user()->phone, -4);

        $date = date('M d Y');

        $companyLogo = User::select('logoimage')->where('id', $client->user_id)->first();
        $providers = Shop::distinct()->where('name', '!=', null)->where('name', '!=', '')->pluck('name');

        return view('user.client.cquote.create')->with('employees', $employees)->with('quote_number', $invoice_number)->with('date', $date)->with('footerText', $footerText)
                ->with('logoimage', $companyLogo->logoimage)->with('client', $client)->with('type', 'Invoice')->with('providers', $providers);
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
            ->select('cquotes.invoice_number as no')
            ->where('isInvoice', true)
            ->where('cclients.client_id', $client_id)
            ->orderby('cquotes.invoice_number')->first();

            if($cquote != null && $request->quoteNumber < $cquote->no)
                throw ValidationException::withMessages(['quoteNumber' => 'Please input quote number greater than '.$cquote->no]);
            
            $cquote = CQuote::join('projects', 'projects.id', '=', 'cquotes.project_id')
                ->join('cclients', 'cclients.id', '=', 'projects.cclient_id')
                ->select('cquotes.invoice_number as no')
                ->where('isInvoice', true)
                ->where('cclients.client_id', $client_id)
                ->where('cquotes.invoice_number', $request->quoteNumber)
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

        $invoice_number = 1;
        if($request->quoteNumber != null && $request->quoteNumber != '')
            $invoice_number = $request->quoteNumber;
        else
        {
            $cinvoice_number =  CQuote::join('projects', 'projects.id', '=', 'cquotes.project_id')
                    ->join('cclients', 'cclients.id', '=', 'projects.cclient_id')
                    ->select('cquotes.invoice_number as no')
                    ->where('isInvoice', true)
                    ->where('cclients.client_id', $client_id)
                    ->orderby('cquotes.invoice_number', 'DESC')->first();
            if($cinvoice_number != null)
                $invoice_number = $cinvoice_number->no + 1;
        }
        

        if($request->id == null || $request->id == "")
            $quote = CQuote::create(['project_id' => $project->id, 'total' => $request->total, 'advance' => $request->advance, 'discount' => $request->discount
            , 'unprevented' => $request->unprevented, 'shopdays' => $request->shopdays, 'invoice_number' => $invoice_number, 'invoice_status' => 'New',
            'isInvoice' => true]);        
        else{
            $quote = CQuote::find($request->id);        
            $quote->project_id = $project->id;
            $quote->invoice_number = $invoice_number;
            $quote->total = $request->total;
            $quote->discount = $request->discount;
            $quote->advance = $request->advance;
            $quote->unprevented = $request->unprevented;
            $quote->shopdays = $request->shopdays;
            $quote->isInvoice = true;
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
            , 'cquotes.discount as discount', 'cquotes.unprevented as unprevented', 'cquotes.advance as advance', 'cquotes.shopdays as shopdays', 'cquotes.invoice_number as quote_number')
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
            ->with('logoimage', $companyLogo->logoimage)->with('client', $client)->with('type', 'Invoice')->with('providers', $providers);
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
  
        return redirect()->route('user.clientinvoices.index');
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

    public function updateInvoiceStatus(Request $request)
    {
        $cquote = CQuote::find($request->id);
        $cquote->invoice_status = $request->status;
        $cquote->update();
        return response()->json(['success'=>'success']);
    }
}
