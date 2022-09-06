<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Provider;
use App\Shop;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    //Check if user has list permission
    public function __construct()
    {
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(!Auth::user()->hasRole('Provider'))
            return redirect()->route('user.profile');
        $agent = new Agent();
        $shops = Shop::where('provider_id', Auth::user()->provider->id)->get();
        
        if($agent->isMobile())
            $i = -1;
        else
            $i = (request()->input('page', 1) - 1) * 10;
        return view('user.provider.shop.index',compact('shops'))
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
        return view('user.provider.shop.create');
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
        $provider = Auth::user()->provider;
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
        return redirect()->route('user.providershops.index');
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
        $shop = Shop::find($id);
        return view('user.provider.shop.edit')->with('shop', $shop);
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
        $provider = Auth::user()->provider;
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
        return redirect()->route('user.providershops.index');
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
        return redirect()->route('user.providershops.index');
    }
}
