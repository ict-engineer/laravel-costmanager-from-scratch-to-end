<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Shop;
use App\Provider;
use App\Models\Material;

class ApiMaterialController extends Controller
{
    //
    public function addMaterial(Request $request)
    {
        $provider = Provider::where('api_token', $request->token)->first();
        if($provider == null)
            return response()->json(['error' => 'Invalid Token.'], 404);

        try {
            $shop = Shop::find($request->shop_id);
            if($shop == null)
                return response()->json(['error' => 'Invalid shop id.'], 404);

            if($provider->id != $shop->provider_id)
                return response()->json(['error' => 'Can not add material to others shop.'], 404);

            $material = Material::create([
                'description' => $request->description,
                'brand' => $request->brand,
                'sku' => $request->sku,
                'partno' => $request->part_no,
                'price' => $request->price,
                'shop_id' => $request->shop_id,
                'image' => $request->image,
            ]);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Invalid Data.'], 404);
        }

        return response()->json(['material_id' => $material->id, 'description' => $material->description, 'brand' => $material->brand,
                                    'sku' => $material->sku, 'part_no' => $material->partno, 'price' => $material->price, 'image' => $material->image,
                                    'shop' => ['shop_id' => $shop->id, 'shop_name' => $shop->name, 'address_line' => $shop->addline1,
                                    'country' => $shop->country, 'postal_code' => $shop->cp, 'currency' => $shop->currency]], 200);
    }
    public function getMaterialInfo(Request $request)
    {
        $provider = Provider::where('api_token', $request->token)->first();
        if($provider == null)
            return response()->json(['error' => 'Invalid Token.'], 404);

        try {
            $shop = Shop::find($request->shop_id);
            if($shop == null)
                return response()->json(['error' => 'Invalid shop id.'], 404);

            if($provider->id != $shop->provider_id)
                return response()->json(['error' => 'Shop is not yours with this shop id.'], 404);

            $material = Material::where('shop_id', $shop->id)->where('sku', $request->sku)->first();

            if($material == null)
                return response()->json(['error' => 'No existing material with this shop id and sku.'], 404);

        } catch (QueryException $e) {
            return response()->json(['error' => 'Invalid Data.'], 404);
        }

        return response()->json(['material_id' => $material->id, 'description' => $material->description, 'brand' => $material->brand,
                                    'sku' => $material->sku, 'part_no' => $material->partno, 'price' => $material->price, 'image' => $material->image,
                                    'shop' => ['shop_id' => $shop->id, 'shop_name' => $shop->name, 'address_line' => $shop->addline1,
                                    'country' => $shop->country, 'postal_code' => $shop->cp, 'currency' => $shop->currency]], 200);
    }
    public function deleteMaterial(Request $request)
    {
        $provider = Provider::where('api_token', $request->token)->first();

        if($provider == null)
            return response()->json(['error' => 'Invalid Token.'], 404);

        try {
            $material = Material::find($request->material_id);
            if($material == null)
                return response()->json(['error' => 'Invalid material id.'], 404);

            $shop = Shop::find($material->shop_id);

            if($provider->id != $shop->provider_id)
                return response()->json(['error' => 'Can not delete material on others shop.'], 404);

            Material::find($request->material_id)->delete();
        } catch (QueryException $e) {
            return response()->json(['error' => 'Invalid Data.'], 404);
        }

        return response()->json(['success' => 'Deleted Successfully'], 200);
    }
    public function editMaterial(Request $request)
    {
        $provider = Provider::where('api_token', $request->token)->first();
        if($provider == null)
            return response()->json(['error' => 'Invalid Token.'], 404);

        try {
            $material = Material::find($request->material_id);
            
            if($material == null)
                return response()->json(['error' => 'Invalid materail id.'], 404);
            
            $shop = Shop::find($material->shop_id);
            
            if($provider->id != $shop->provider_id)
                return response()->json(['error' => 'Can not edit material on others shop.'], 404);

            $material->description = $request->description;
            $material->brand = $request->brand;
            $material->sku = $request->sku;
            $material->partno = $request->part_no;
            $material->price = $request->price;
            $material->image = $request->image;
            $material->update();
        } catch (QueryException $e) {
            return response()->json(['error' => 'Invalid Data.'], 404);
        }

        return response()->json(['material_id' => $material->id, 'description' => $material->description, 'brand' => $material->brand,
                                    'sku' => $material->sku, 'part_no' => $material->partno, 'price' => $material->price, 'image' => $material->image,
                                    'shop' => ['shop_id' => $shop->id, 'shop_name' => $shop->name, 'address_line' => $shop->addline1,
                                    'country' => $shop->country, 'postal_code' => $shop->cp, 'currency' => $shop->currency]], 200);
    }
}
