<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Jenssegers\Agent\Agent;
use App\Models\Material;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Shop;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ConsultMaterialController extends Controller
{
    //
    public function index(Request $request)
    {
        //
        if(!(Auth::user()->hasRole('Client')))
            return redirect()->route('user.profile');

        $client_id = 0;
        if(Auth::user()->hasPermissionTo('Employee Administrative') || Auth::user()->hasPermissionTo('Employee Sales'))
            $client_id = Auth::user()->employee->client_id;
        else
            $client_id = Auth::user()->client->id;

        $client = Client::find($client_id);

        $filter = $request->input();
        
        $agent = new Agent();
        
        $shops = Shop::get();

        $dists = [];
        $lat1 = $client->lat;
        $lon1 = $client->lng;
        //get Distance
        foreach($shops as $shop)
        {
            $lat2 = $shop->lat;
            $lon2 = $shop->lng;
            $R = 6371; // metres
            $a1 = $lat1 * pi()/180; // φ, λ in radians
            $a2 = $lat2 * pi()/180;
            $b1 = ($lat2-$lat1) * pi()/180;
            $b2 = ($lon2-$lon1) * pi()/180;

            $a = sin($b1/2) * sin($b1/2) +
                    cos($a1) * cos($a2) *
                    sin($b2/2) * sin($b2/2);
            
            $c = 2 * atan2(sqrt($a), sqrt(1-$a));
            
            $dist = $R * $c; // in metres
            $dist = number_format($dist, 3, '.', "");
            $dists[$shop->id] = $dist;
        }

        $perpage = request('perpage', 10);

        //$materials =  DB::select( DB::raw("select materials.id as id, materials.description as description, materials.brand as brand, materials.sku as sku, materials.price as price, materials.partno as partno, materials.image as image, materials.shop_id as shop_id, shops.name as shoplist, providers.companyname as providerlist, shops.currency as currency from materials, shops, providers where materials.shop_id = shops.id and shops.provider_id = providers.id order by shops.provider_id, materials.shop_id, materials.id"));
        $materials = Material::join('shops', 'materials.shop_id', '=', 'shops.id')
        ->select('materials.id as id', 'materials.description as description', 'materials.shop_id as shop_id', 'materials.brand as brand', 'materials.sku as sku', 'materials.price as price', 'materials.partno as partno', 'materials.image as image', 'shops.name as shopName', 'shops.currency as currency')
        ->where(function($query) use ($request)
        {
            if($request->keywordfilters != '' && $request->keywordfilters != null)
            {
                $keywords = explode('|', $request->keywordfilters);
                for($i=0;$i<count($keywords);$i++){
                    $words = explode(' ', $keywords[$i]);
                    $query->orWhere(function($query1) use ($words)
                    {
                        foreach( $words as $word) {
                            $query1->where('materials.description', 'like', '%'.$word.'%');
                        }
                    });
                }
            }
        })
        ->where(function($query) use ($request)
        {
            if($request->providerfilters != '' && $request->providerfilters != null)
            {
                $providers = explode('|', $request->providerfilters);
                for($i=0;$i<count($providers);$i++){
                    $query->orWhere('shops.name', $providers[$i]);
                }
            }
        })
        ->where(function($query) use ($request)
        {
            if($request->brandfilters != '' && $request->brandfilters != null)
            {
                $brands = explode('|', $request->brandfilters);
                for($i=0;$i<count($brands);$i++){
                    $query->orWhere('materials.brand', $brands[$i]);
                }
            }
        })
        ->where(function($query) use ($request)
        {
            if($request->skufilters != '' && $request->skufilters != null)
            {
                $skus = explode('|', $request->skufilters);
                for($i=0;$i<count($skus);$i++){
                    $query->orWhere('materials.sku', $skus[$i]);
                }
            }
        })
        ->where(function($query) use ($request)
        {
            if($request->partnofilters != '' && $request->partnofilters != null)
            {
                $partnos = explode('|', $request->partnofilters);
                for($i=0;$i<count($partnos);$i++){
                    $query->orWhere('materials.partno', $partnos[$i]);
                }
            }
        })
        ->where(function($query) use ($request, $shops, $dists)
        {
            if($request->radiusfilters != '' && $request->radiusfilters != null)
            {
                $query->orWhere('materials.shop_id', 0);
                $radiuss = explode('|', $request->radiusfilters);
                for($i=0;$i<count($radiuss);$i++){
                    foreach($shops as $shop)
                    {
                        if($radiuss[$i] == '1km or Less' || $radiuss[$i] == '1km o Menos')
                        {
                            if(floatval($dists[$shop->id]) <= 1)
                                $query->orWhere('materials.shop_id', $shop->id);
                        }
                        elseif($radiuss[$i] == '1~5km')
                        {
                            if(floatval($dists[$shop->id]) > 1 && floatval($dists[$shop->id]) < 5)
                                $query->orWhere('materials.shop_id', $shop->id);
                        }
                        elseif($radiuss[$i] == '5~10km')
                        {
                            if(floatval($dists[$shop->id]) > 5 && floatval($dists[$shop->id]) < 10)
                                $query->orWhere('materials.shop_id', $shop->id);
                        }
                        elseif($radiuss[$i] == '10~20km')
                        {
                            if(floatval($dists[$shop->id]) > 10 && floatval($dists[$shop->id]) < 20)
                                $query->orWhere('materials.shop_id', $shop->id);
                        }
                        elseif($radiuss[$i] == '20km or More' || $radiuss[$i] == '20km o Más')
                        {
                            if(floatval($dists[$shop->id]) >= 20)
                                $query->orWhere('materials.shop_id', $shop->id);
                        }
                    }
                }
            }
        })
        ->orderby('materials.shop_id')
        ->orderby('materials.id')
        ->paginate($perpage);

        $providers = Shop::distinct()->where('name', '!=', null)->where('name', '!=', '')->pluck('name');
        $brands = Material::distinct()->where('brand', '!=', null)->where('brand', '!=', '')->pluck('brand');
        $skus = Material::distinct()->where('sku', '!=', null)->where('sku', '!=', '')->pluck('sku');
        $partnos = Material::distinct()->where('partno', '!=', null)->where('partno', '!=', '')->pluck('partno');

        return view('user.client.consult_material.index')->with('materials', $materials)->with('filter', $filter)->with('dists', $dists)
            ->with('providers', $providers)->with('brands', $brands)->with('skus', $skus)->with('partnos', $partnos);
    }

    public function getConsultMaterials(Request $request)
    {
        $client_id = 0;
        if(Auth::user()->hasPermissionTo('Employee Administrative') || Auth::user()->hasPermissionTo('Employee Sales'))
            $client_id = Auth::user()->employee->client_id;
        else
            $client_id = Auth::user()->client->id;

        $client = Client::find($client_id);
        $agent = new Agent();
        
        $shops = Shop::get();

        $dists = [];
        $lat1 = $client->lat;
        $lon1 = $client->lng;
        //get Distance
        foreach($shops as $shop)
        {
            $lat2 = $shop->lat;
            $lon2 = $shop->lng;
            $R = 6371; // metres
            $a1 = $lat1 * pi()/180; // φ, λ in radians
            $a2 = $lat2 * pi()/180;
            $b1 = ($lat2-$lat1) * pi()/180;
            $b2 = ($lon2-$lon1) * pi()/180;

            $a = sin($b1/2) * sin($b1/2) +
                    cos($a1) * cos($a2) *
                    sin($b2/2) * sin($b2/2);
            
            $c = 2 * atan2(sqrt($a), sqrt(1-$a));
            
            $dist = $R * $c; // in metres
            $dist = number_format($dist, 3, '.', "");
            $dists[$shop->id] = $dist;
        }

        $filename = "download.csv";
        $handle = fopen($filename, 'w');

        // Add CSV headers
        fputcsv($handle, [
            'description',
            'shopName', 
            'brand',
            'sku',
            'partno',
            'price',
            'image',
            'distance',
        ]);

        //$materials =  DB::select( DB::raw("select materials.id as id, materials.description as description, materials.brand as brand, materials.sku as sku, materials.price as price, materials.partno as partno, materials.image as image, materials.shop_id as shop_id, shops.name as shoplist, providers.companyname as providerlist, shops.currency as currency from materials, shops, providers where materials.shop_id = shops.id and shops.provider_id = providers.id order by shops.provider_id, materials.shop_id, materials.id"));
        $materials = Material::join('shops', 'materials.shop_id', '=', 'shops.id')
        ->select('materials.description as description', 'materials.shop_id as shop_id', 'materials.brand as brand', 'materials.sku as sku', 'materials.price as price', 'materials.partno as partno', 'materials.image as image', 'shops.name as shopName', 'shops.currency as currency')
        ->where(function($query) use ($request)
        {
            if($request->keywordfilters != '' && $request->keywordfilters != null)
            {
                $keywords = explode('|', $request->keywordfilters);
                for($i=0;$i<count($keywords);$i++){
                    $words = explode(' ', $keywords[$i]);
                    $query->orWhere(function($query1) use ($words)
                    {
                        foreach( $words as $word) {
                            $query1->where('materials.description', 'like', '%'.$word.'%');
                        }
                    });
                }
            }
        })
        ->where(function($query) use ($request)
        {
            if($request->providerfilters != '' && $request->providerfilters != null)
            {
                $providers = explode('|', $request->providerfilters);
                for($i=0;$i<count($providers);$i++){
                    $query->orWhere('shops.name', $providers[$i]);
                }
            }
        })
        ->where(function($query) use ($request)
        {
            if($request->brandfilters != '' && $request->brandfilters != null)
            {
                $brands = explode('|', $request->brandfilters);
                for($i=0;$i<count($brands);$i++){
                    $query->orWhere('materials.brand', $brands[$i]);
                }
            }
        })
        ->where(function($query) use ($request)
        {
            if($request->skufilters != '' && $request->skufilters != null)
            {
                $skus = explode('|', $request->skufilters);
                for($i=0;$i<count($skus);$i++){
                    $query->orWhere('materials.sku', $skus[$i]);
                }
            }
        })
        ->where(function($query) use ($request)
        {
            if($request->partnofilters != '' && $request->partnofilters != null)
            {
                $partnos = explode('|', $request->partnofilters);
                for($i=0;$i<count($partnos);$i++){
                    $query->orWhere('materials.partno', $partnos[$i]);
                }
            }
        })
        ->where(function($query) use ($request, $shops, $dists)
        {
            if($request->radiusfilters != '' && $request->radiusfilters != null)
            {
                $query->orWhere('materials.shop_id', 0);
                $radiuss = explode('|', $request->radiusfilters);
                for($i=0;$i<count($radiuss);$i++){
                    foreach($shops as $shop)
                    {
                        if($radiuss[$i] == '1km or Less' || $radiuss[$i] == '1km o Menos')
                        {
                            if(floatval($dists[$shop->id]) <= 1)
                                $query->orWhere('materials.shop_id', $shop->id);
                        }
                        elseif($radiuss[$i] == '1~5km')
                        {
                            if(floatval($dists[$shop->id]) > 1 && floatval($dists[$shop->id]) < 5)
                                $query->orWhere('materials.shop_id', $shop->id);
                        }
                        elseif($radiuss[$i] == '5~10km')
                        {
                            if(floatval($dists[$shop->id]) > 5 && floatval($dists[$shop->id]) < 10)
                                $query->orWhere('materials.shop_id', $shop->id);
                        }
                        elseif($radiuss[$i] == '10~20km')
                        {
                            if(floatval($dists[$shop->id]) > 10 && floatval($dists[$shop->id]) < 20)
                                $query->orWhere('materials.shop_id', $shop->id);
                        }
                        elseif($radiuss[$i] == '20km or More' || $radiuss[$i] == '20km o Más')
                        {
                            if(floatval($dists[$shop->id]) >= 20)
                                $query->orWhere('materials.shop_id', $shop->id);
                        }
                    }
                }
            }
        })
        ->orderby('materials.shop_id')
        ->orderby('materials.id')->chunk(30000, function($materials) use($handle, $dists) {
                foreach ($materials as $material) {
                    // Add a new row with data
                    fputcsv($handle, [
                        $material->description,
                        $material->shopName,
                        $material->brand,
                        $material->sku,
                        $material->partno,
                        $material->price,
                        $material->image,
                        $dists[$material->shop_id]
                    ]);
                }
        });

        // Close the output stream
        fclose($handle);
        $headers = array(
            'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-Disposition' => 'attachment; filename=consult_materials.csv',
            'Expires' => '0',
            'Pragma' => 'public',
        );

        return Response::download($filename, "consult_materials.csv", $headers)->deleteFileAfterSend(true);;
    }
}
