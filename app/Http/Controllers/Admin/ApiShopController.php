<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Shop;
use App\Provider;

class ApiShopController extends Controller
{
    //
    public function addShop(Request $request)
    {
        $provider = Provider::where('api_token', $request->token)->first();
        if($provider == null)
            return response()->json(['error' => 'Invalid Token.'], 404);

        try {
            $shop = Shop::create([
                'name' => $request->shop_name,
                'addline1' => $request->address_line,
                'country' => $request->country,
                'cp' => $request->postal_code,
                'provider_id' => $provider->id,
                'currency' => $request->currency,
                'lat' => 0,
                'lng' => 0,
            ]);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Invalid Data.'], 404);
        }

        return response()->json(['shop_id' => $shop->id, 'shop_name' => $shop->name, 'address_line' => $shop->addline1,
                                    'country' => $shop->country, 'postal_code' => $shop->cp, 'currency' => $shop->currency], 200);
    }

    public function getShopInfo(Request $request)
    {
        $provider = Provider::where('api_token', $request->token)->first();
        if($provider == null)
            return response()->json(['error' => 'Invalid Token.'], 404);

        try {
            $shop = Shop::where('provider->id', $provider->id)->where('name', $request->shop_name)->first();

            if($shop == null)
                return response()->json(['error' => 'No existing shop with this shop name.'], 404);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Invalid Data.'], 404);
        }

        return response()->json(['shop_id' => $shop->id, 'shop_name' => $shop->name, 'address_line' => $shop->addline1,
                                    'country' => $shop->country, 'postal_code' => $shop->cp, 'currency' => $shop->currency], 200);
    }

    public function deleteShop(Request $request)
    {
        $provider = Provider::where('api_token', $request->token)->first();

        if($provider == null)
            return response()->json(['error' => 'Invalid Token.'], 404);

        try {
            $shop = Shop::find($request->shop_id);
            if($shop == null)
                return response()->json(['error' => 'Invalid shop id.'], 404);

            if($provider->id != $shop->provider_id)
                return response()->json(['error' => 'Can not delete others shop.'], 404);

            Shop::find($request->shop_id)->delete();
        } catch (QueryException $e) {
            return response()->json(['error' => 'Invalid Data.'], 404);
        }

        return response()->json(['success' => 'Deleted Successfully'], 200);
    }
    public function editShop(Request $request)
    {
        $provider = Provider::where('api_token', $request->token)->first();

        if($provider == null)
            return response()->json(['error' => 'Invalid Token.'], 404);

        try {
            $shop = Shop::find($request->shop_id);

            if($shop == null)
                return response()->json(['error' => 'Invalid shop id.'], 404);

            if($provider->id != $shop->provider_id)
                return response()->json(['error' => 'Can not edit others shop.'], 404);

            $shop->name = $request->shop_name;
            $shop->addline1 = $request->address_line;
            $shop->country = $request->country;
            $shop->cp = $request->postal_code;
            $shop->currency = $request->currency;
            $shop->lat = 0;
            $shop->lng = 0;
            $shop->update();
        } catch (QueryException $e) {
            return response()->json(['error' => 'Invalid Data.'], 404);
        }

        return response()->json(['shop_id' => $shop->id, 'shop_name' => $shop->name, 'address_line' => $shop->addline1,
                                    'country' => $shop->country, 'postal_code' => $shop->cp, 'currency' => $shop->currency], 200);
    }
}
