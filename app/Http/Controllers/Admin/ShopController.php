<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Provider;
use App\Shop;
use Jenssegers\Agent\Agent;

class ShopController extends Controller
{
    //Check if user has list permission
    public function __construct()
    {
        $this->middleware(['permission:List Shops']);
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
        
        $shops = Shop::with('provider')->orderby('provider_id')->get();
        
        if($agent->isMobile())
            $i = -1;
        else
            $i = (request()->input('page', 1) - 1) * 10;
        return view('admin.shop.index',compact('shops'))
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
        $providers = Provider::pluck('companyname');
        return view('admin.shop.create')->with('providers', $providers);
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
        $data = $request->input();
        $provider = Provider::where('companyname', $data['providerlist'])->first();
        Shop::create([
            'name' => $data['name'],
            'addline1' => $data['addline1'],
            'country' => $data['country'],
            'cp' => $data['cp'],
            'provider_id' => $provider->id,
            'currency' => $data['currency'],
            'lat' => $data['lat'],
            'lng' => $data['lng'],
        ]);
        return redirect()->route('shops.index');
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
        $shop = Shop::with('provider')->find($id);
        $providers = Provider::pluck('companyname');
        return view('admin.shop.edit')->with('shop', $shop)->with('providers', $providers);
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
        $provider = Provider::where('companyname', $request->input('providerlist'))->first();
        $shops = Shop::find($id);
        $shops->addline1 = $request->input('addline1');
        $shops->name = $request->input('name');
        $shops->country = $request->input('country');
        $shops->cp = $request->input('cp');
        $shops->lat = $request->input('lat');
        $shops->lng = $request->input('lng');
        $shops->currency = $request->input('currency');
        $shops->provider_id =$provider->id;
        $shops->update();
        return redirect()->route('shops.index');
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
        Shop::find($id)->delete();
        return redirect()->route('shops.index');
    }
}
