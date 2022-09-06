<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\CQuote;
use App\Models\Project;
use App\Models\CClient;
use App\Models\Client;
use App\Models\QuoteGroup;
use App\Models\QuoteItem;
use App\Models\QuoteMaterial;
use App\Models\QuoteService;
use App\Models\QuoteEmployee;
use App\Models\FixedExpense;
use App\Models\PublicQuote;
use App\User;

class PublicQuoteController extends Controller
{
    //
    public function index($name)
    {
        $public_quote = PublicQuote::where('name', $name)->first();

        if($public_quote == null)
            return abort(404);

        // $quote_id = $public_quote->quote_id;
        // $showMaterial = $public_quote->showMaterial;
        // $showService = $public_quote->showService;
        // $showEmployee = $public_quote->showEmployee;
        // $showOnlyTotal = $public_quote->showOnlyTotal;

        // $cquote = CQuote::find($quote_id);
        // $project = Project::find($cquote->project_id);
        // $cclient = CClient::find($project->cclient_id);
        // $client = Client::find($cclient->client_id);
        // $user = User::find($client->user_id);
        // $data['footerText'] = $client->companyname.'. '.$client->addline1.'. Tel.:+'.Str::substr($user->phone, 0, strlen($user->phone) - 10).' ('.Str::substr($user->phone, -10, 3).') '.Str::substr($user->phone, -7, 3).'-'.Str::substr($user->phone, -4);
        // $data['companyLogo'] = $user->logoimage;
        // $data['date'] = date('M d Y', strtotime($cquote['created_at']));
        // $data['client'] = 'Att: '.$cclient->name;
        // $phoneTmp = $cclient['phone'];
        // $countrycode = Str::substr($phoneTmp, 0, strlen($phoneTmp) - 10);
        // $phone = Str::substr($phoneTmp, -10);
        // $data['phone'] = 'Phone: +'.$countrycode.' '.'('.Str::substr($phone, 0, 3).') '.Str::substr($phone, 3, 3).'-'.Str::substr($phone, 6);
        // $data['email'] = 'Mail: '.$cclient->email;
        // $data['project'] = $project->name;
        // $data['quoteId'] = 'Quote No. '.$cquote->quote_number;
        // $data['companyname'] = $cclient->companyname;
        // $data['shopdays'] = $cquote->shopdays;
        // $data['discount'] = $cquote->discount;
        // $data['unprevented'] = $cquote->unprevented;
        // $data['advance'] = $cquote->advance;

        // $groups = [];

        // $qGroups = QuoteGroup::where('cquote_id', $quote_id)->oldest()->get();
        // foreach ($qGroups as $qGroup)
        // {
        //     $group = null;
        //     $group['name'] = $qGroup->name;
        //     $group['color'] = $qGroup->color;
        //     $items = [];

        //     $qItems = QuoteItem::where('quote_group_id', $qGroup->id)->oldest()->get();
        //     foreach ($qItems as $qItem)
        //     {
        //         $item = null;
        //         $item['name'] = $qItem->name;
        //         $item['quantity'] = $qItem->quantity;
        //         $item['cost'] = $qItem->cost;
        //         $item['utility'] = $qItem->utility;
        //         $item['total'] = $qItem->total;
        //         $materials = [];
        //         $qMaterials = QuoteMaterial::where('quote_item_id', $qItem->id)->oldest()->get();
        //         foreach($qMaterials as $qMaterial)
        //         {
        //             $material = null;
        //             $material['description'] = $qMaterial->description;
        //             $material['quantity'] = $qMaterial->quantity;
        //             $material['cost'] = $qMaterial->price;
        //             $material['provider'] = $qMaterial->provider;
        //             $material['total'] = $qMaterial->price * $qMaterial->quantity;
        //             array_push($materials, $material);
        //         }
        //         $item['materials'] = $materials;
        //         array_push($items, $item);
        //     }
        //     $group['items'] = $items;
        //     array_push($groups, $group);
        // }

        // $services = [];
        // $qservices = QuoteService::where('cquote_id', $quote_id)->oldest()->get();
        // foreach($qservices as $service)
        // {
        //     $item = null;
        //     $item['name'] = $service->name;
        //     $item['provider'] = $service->provider;
        //     $item['cost'] = $service->cost;
        //     $item['utility'] = $service->utility;
        //     $item['price'] = $service->price;
        //     array_push($services, $item);
        // }

        // $employees = [];
        // $qemployees = QuoteEmployee::where('cquote_id', $quote_id)->oldest()->get();
        // foreach($qemployees as $employee)
        // {
        //     $item = null;
        //     $item['name'] = $employee->name;
        //     $item['hours'] = $employee->hours;
        //     $item['cost'] = $employee->cost;
        //     $item['total'] = $employee->total;
        //     array_push($employees, $item);
        // }

        // $fixed = FixedExpense::where('client_id', $cclient->client_id)->get();

        // $fixedTotal = 0;
        // foreach( $fixed as $item)
        // {
        //     if($item->cycle == 'Weekly')
        //         $fixedTotal = $fixedTotal + $item->cost / 7;
        //     else if($item->cycle == 'Monthly')
        //         $fixedTotal = $fixedTotal + $item->cost / 31.5;
        //     else if($item->cycle == 'Annual')
        //         $fixedTotal = $fixedTotal + $item->cost / 365;
        // }

        // $itemTotal = 0;
        // foreach($groups as $group){
        //     if(array_key_exists('items', $group))
        //     {
        //         foreach($group['items'] as $item)
        //         {
        //             $itemTotal = $itemTotal + $item['total'];
        //         }
        //     }
        // }

        // //shopDays  
        // $shopdaysTotal = $cquote->shopdays * $fixedTotal;
        
        // $servicesTotal = 0;
        // //services
        // foreach($services as $service)
        // {
        //     $servicesTotal = $servicesTotal + $service['price'];
        // }

        // //employees
        // $employeesTotal = 0;
        // foreach($employees as $employee)
        // {
        //     $employeesTotal = $employeesTotal + $employee['total'];
        // }

        // //subTotal
        // $subTotal = $itemTotal + $shopdaysTotal + $servicesTotal + $employeesTotal;

        // //unprevented
        // $unpreventedTotal = 0;
        // if($cquote->unprevented)
        // {
        //     $unpreventedTotal = $subTotal * $cquote->unprevented / 100;
        // }

        // //discount
        // $discountTotal = 0;
        // if($cquote->discount)
        // {
        //     $discountTotal = $subTotal * $cquote->discount / 100;
        // }

        // //total
        // $Total = $subTotal + $unpreventedTotal - $discountTotal;

        // $data['itemTotal'] = $itemTotal;
        // $data['shopdaysTotal'] = $shopdaysTotal;
        // $data['servicesTotal'] = $servicesTotal;
        // $data['employeesTotal'] = $employeesTotal;
        // $data['discountTotal'] = $discountTotal;
        // $data['unpreventedTotal'] = $unpreventedTotal;
        // $data['subTotal'] = $subTotal;
        // $data['Total'] = $Total;


        // return view('user.client.public_quote.index')->with('data', $data)->with('groups', $groups)
        //     ->with('services', $services)->with('employees', $employees)
        //     ->with('showMaterial', $showMaterial)->with('showService', $showService)
        //     ->with('showEmployee', $showEmployee)->with('showOnlyTotal', $showOnlyTotal);
        return view('user.client.public_quote.index')->with('content', $public_quote->content);
    }
}
