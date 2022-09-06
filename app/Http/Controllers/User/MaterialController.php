<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Jenssegers\Agent\Agent;
use App\Models\Material;
use Illuminate\Support\Facades\Storage;
use App\Shop;
use App\Provider;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use File;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use Lang;
use Session;

class MaterialController extends Controller
{
    //Check if user has list permission
    public function __construct()
    {
        
    }
    /**
     * Receive Upload file and responds file info
     * 
     */

    public function uploadDataFile(Request $request)
    {
        // foreach(file($uploadedFile->getRealPath()) as $line)
        // {
        //     $texts = explode(' ', $line);
        //     $upload = new Upload;

        //     $upload->name = $texts[0];
        //     $upload->description = $texts[1];
        //     $upload->price = $texts[2];

        //     $upload->save();
        // }
        
        // Storage::disk('local')->putFileAs(
        //   'uploads/'.$filename,
        //   $uploadedFile,
        //   $filename
        // );
        
        // dd($request->file);
        request()->validate([
            'file'  => 'required|mimes:xls,xlsx,csv,txt|max:2048000',
        ]);

        $data = $request->input();
        
        if ($uploadedFile = $request->file('file')) {
            //store file into document folder
            // $file = $request->file->storeAs('public/files', $data['shop_id']);
            $cnt = 0;      
            $rowcount = count(file($uploadedFile)) - 1;
            set_time_limit(30000000);
            if($data['customRadio'] == "addM")
            {
                $header = null;
                if (($handle = fopen($uploadedFile->getRealPath(), 'r')) !== false)
                {
                    while (($row = fgetcsv($handle, 10000, ',')) !== false)
                    {
                        if (!$header)
                        {
                            $header = $row;
                            $header[0] = "description";
                        }
                        else {
                            if(count($row) < 6)
                            {
                                continue;
                            }
                            $texts = array_combine($header, $row);
                            $material = Material::where([['sku', $texts['sku']], ['shop_id', $request->input('shop_id')]])->count();
                            if($material != 0)
                                $cnt ++;
                        }
                                
                    }
                    fclose($handle);
                }
                
                if($cnt == 0)
                    return Response()->json([
                        "success" => true,
                        "text" => Lang::get('messages.You are uploading ').$rowcount.Lang::get('messages. records to the list')
                    ]);    
                else
                    return Response()->json([
                        "success" => true,
                        "text" => Lang::get('messages.You are uploading ').$rowcount.Lang::get('messages. records to the list').": ".$cnt.Lang::get('messages. records have the same SKU and will be replace with the new ones')
                    ]);    
            }
            //store your file into database
            //$document = new Document();
            //$document->title = $file;
            //$document->save();
                
            return Response()->json([
                "success" => true,
                "text" => Lang::get('messages.You are uploading ').$rowcount.Lang::get('messages. records to the list. Old records will be deleted')
            ]);
        }
    
        return Response()->json([
                "success" => false,
                "file" => ''
            ]);   
    }
    /**
     * Store Upload file data on database
     * 
     */
    public function storeDataFile(Request $request)
    {
        if($request->add == 0)
            Material::where('shop_id', $request->shop_id)->delete();
        // $shop_id = $request->shop_id;
        // $isadd = $request->add;
        // $path = storage_path()."/app/public/files/".$shop_id;
        // if (!File::exists($path)) {
        //     return Response()->json([
        //         "success" => false,
        //         "text" => "Can not read upload file."
        //     ]);   
        // }
    
        // $cntRead = 0;
        // $cntUnread = 0;
        // $header = null;
        // if($isadd == 0)
        //     Material::where('shop_id', $shop_id)->delete();
        // if (($handle = fopen($path, 'r')) !== false)
        // {
        //     set_time_limit(30000000);
        //     while (($row = fgetcsv($handle, 10000, ',')) !== false)
        //     {
        //         if (!$header)
        //         {
        //             $header = $row;
        //             $header[0] = "description";
        //         }
        //         else {
        //             if(count($row) < 6)
        //             {
        //                 $cntUnread ++;
        //                 continue;
        //             }
        //             $texts = array_combine($header, $row);
        //             if($texts['description'] == "" || $texts['sku'] == "" || $texts['price'] == "")
        //             {
        //                 $cntUnread ++;
        //                 continue;
        //             }
        //             Material::where([['sku', $texts['sku']],['shop_id', $shop_id]])->delete();
        //             Material::create ([
        //                 'description' => $texts['description'],
        //                 'brand' => $texts['brand'],
        //                 'sku' => $texts['sku'],
        //                 'partno' => $texts['partno'],
        //                 'price' => $texts['price'],
        //                 'image' => trim($texts['image']),
        //                 'shop_id' => $shop_id,
        //             ]);
        //             $cntRead ++;
        //         }
                        
        //     }
        //     fclose($handle);
        // }
        // Storage::delete('/public/files/'.$shop_id);
        // if($cntRead)
        // {
        //     if($cntUnread)
        //     {
        //         return Response()->json([
        //             "success" => true,
        //             "text" => Lang::get('messages.Load ').$cntRead.Lang::get('messages. materials successfully.')."<br/>".$cntUnread.Lang::get('messages. materials information is wrong.')
        //         ]);   
        //     }
        //     else
        //     {
        //         return Response()->json([
        //             "success" => true,
        //             "text" => Lang::get('messages.Load ').$cntRead.Lang::get('messages. materials successfully.')
        //         ]);   
        //     }
        // }
        return Response()->json([
            "success" => true,
            // "text" => Lang::get('messages.All material information of file is wrong.')
        ]);   
    }
    
    public function index(Request $request)
    {
        //
        if(!(Auth::user()->hasRole('Provider')))
            return redirect()->route('user.profile');
        
        $filter = $request->input();
        
        $agent = new Agent();
        
        //$materials =  DB::select( DB::raw("select materials.id as id, materials.description as description, materials.brand as brand, materials.sku as sku, materials.price as price, materials.partno as partno, materials.image as image, materials.shop_id as shop_id, shops.name as shoplist, providers.companyname as providerlist, shops.currency as currency from materials, shops, providers where materials.shop_id = shops.id and shops.provider_id = providers.id order by shops.provider_id, materials.shop_id, materials.id"));
        if(!($request->has('shoplist')) || $filter['shoplist'] == "All")
            $materials = Material::join('shops', 'materials.shop_id', '=', 'shops.id')
                        ->where('shops.provider_id', Auth::user()->provider->id)
                        ->select('materials.id as id', 'materials.description as description', 'materials.brand as brand', 'materials.sku as sku', 'materials.price as price', 'materials.partno as partno', 'materials.image as image', 'materials.shop_id as shop_id', 'shops.name as shoplist', 'shops.currency as currency')
                        ->orderby('materials.shop_id')
                        ->orderby('materials.id')
                        ->paginate(10);
        else
        {
            $materials = Material::join('shops', 'materials.shop_id', '=', 'shops.id')
            ->where('shops.provider_id', Auth::user()->provider->id)
            ->where('shops.name', $filter['shoplist'])
            ->select('materials.id as id', 'materials.description as description', 'materials.brand as brand', 'materials.sku as sku', 'materials.price as price', 'materials.partno as partno', 'materials.image as image', 'materials.shop_id as shop_id', 'shops.name as shoplist', 'shops.currency as currency')
            ->orderby('materials.shop_id')
            ->orderby('materials.id')
            ->paginate(10);
        }
        $shops = Auth::user()->provider->shops()->pluck('name');

        if($agent->isMobile())
            $i = -1;
        else
            $i = (request()->input('page', 1) - 1) * 10;
        return view('user.provider.material.index')->with('materials', $materials)->with('filter', $filter)
            ->with('i', $i)->with('shops', $shops);
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
        return view('admin.material.create')->with('providers', $providers);
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
        $url = "";
        if ($request->hasFile('image')) {
            //  Let's do everything here
            if ($request->file('image')->isValid()) {
                //
                $validated = $request->validate([
                    'image' => 'mimes:jpeg,png|max:1014',
                ]);
                $file = request()->file('image');
                $name = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $request->image->storeAs('/public/images', $name);
                $url = asset("storage/images/" . $name);
            }
        }
        $data = $request->input();
        
        //get shop id
        $provider = Auth::user()->provider;
        $shopname = $data['shoplist'];
        $shop = Shop::where([
            ['provider_id', '=', $provider->id],
            ['name', '=', $shopname],
            ])->first();
        if (!$request->has("imageurl"))
            $data['image'] = $url;
        else
            $data['image'] = $data['imageurl'];
        $materials = Material::create([
            'description' => $data['description'],
            'brand' => $data['brand'],
            'sku' => $data['sku'],
            'partno' => $data['partno'],
            'price' => $data['price'],
            'image' => $data['image'],
            'shop_id' => $shop->id,
        ]);
        return redirect()->route('user.providermaterials.index');
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
        $material = DB::select( DB::raw("select materials.id as id, materials.description as description, materials.brand as brand, materials.sku as sku, materials.price as price, materials.partno as partno, materials.image as image, materials.shop_id as shop_id, shops.name as shoplist, shops.currency as currency from materials, shops, providers where materials.id = " . $id . " and materials.shop_id = shops.id and shops.provider_id = providers.id limit 1") );
        $material[0]->imageurl = "";
        if(!Str::contains($material[0]->image, 'storage/images'))
        {
            $material[0]->imageurl = $material[0]->image;
            $material[0]->image = "";
        }
        return response()->json($material[0]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $material = DB::select( DB::raw("select materials.id as id, materials.description as description, materials.brand as brand, materials.sku as sku, materials.price as price, materials.partno as partno, materials.image as image, materials.shop_id as shop_id, shops.name as shoplist, shops.currency as currency from materials, shops, providers where materials.id = " . $id . " and materials.shop_id = shops.id and shops.provider_id = providers.id limit 1") );
        $material[0]->imageurl = "";
        if(!Str::contains($material[0]->image, 'storage/images'))
        {
            $material[0]->imageurl = $material[0]->image;
            $material[0]->image = "";
        }

        return view('admin.material.edit')->with('material', $material[0])->with('providers', $providers);
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
        $data = $request->input();
        $materials = Material::find($data['editmaterialId']);
        
        $url = $materials->image;
        if ($request->hasFile('image')) {
            //  Let's do everything here
            if ($request->file('image')->isValid()) {
                //
                $validated = $request->validate([
                    'image' => 'mimes:jpeg,png|max:1014',
                ]);
                $tmps = explode('/', $materials->image);
                $image_path = '/images/' . $tmps[count($tmps) - 1];  // Value is not URL but directory file path
                Storage::delete('/public' . $image_path);
                $file = request()->file('image');
                $name = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $request->image->storeAs('/public/images', $name);
                $url = asset("storage/images/" . $name);
            }
        }

         //get shop id
         $provider = Auth::user()->provider;
         $shopname = $data['shoplist'];
         $shop = Shop::where([
             ['provider_id', '=', $provider->id],
             ['name', '=', $shopname],
             ])->first();

             
        if (!$request->has("imageurl"))
            $data['image'] = $url;
        else
        {
            $data['image'] = $data['imageurl'];
        }
        $materials->description = $request->input('description');
        $materials->brand = $request->input('brand');
        $materials->sku = $request->input('sku');
        $materials->price = $request->input('price');
        $materials->image = $data['image'];
        $materials->partno =$request->input('partno');
        $materials->shop_id =$shop->id;
        $materials->update();
        return redirect()->route('user.providermaterials.index');
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
        $materials = Material::find($id);
        $tmps = explode('/', $materials->image);
        $image_path = '/images/' . $tmps[count($tmps) - 1];  // Value is not URL but directory file path
        
        Storage::delete('/public' . $image_path);
        Material::find($id)->delete();

        return redirect()->route('user.providermaterials.index');
    }

    public function getMaterialbyName(Request $request)
    {
        $client_id = 0;
        if(Auth::user()->hasPermissionTo('Employee Administrative') || Auth::user()->hasPermissionTo('Employee Sales'))
            $client_id = Auth::user()->employee->client_id;
        else
            $client_id = Auth::user()->client->id;
        $client = Client::find($client_id);

        //get distance
        $shops = Shop::get();

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
        $dists[0] = 0;

        $query_str = "select materials.image as image, materials.id as id, materials.description as description, materials.price as price, materials.brand as brand, materials.shop_id as shop_id, shops.name as shopname, shops.currency as currency from materials, shops, providers where materials.shop_id = shops.id and shops.provider_id = providers.id and ";

        $whereClause = '';
        $whereClause1 = '';
        if($request->provider != null)
        {
            $whereClause .= '(';
            foreach($request->provider as $filterProvider)
            {
                $whereClause .= ' shops.name = "'.$filterProvider.'" OR';
            }
            $whereClause = substr($whereClause, 0, -2);
            $whereClause .= ') AND';
        }

        $words = explode(' ', $request->value);
        foreach( $words as $word) {
            $whereClause .= ' materials.description LIKE "%' . $word . '%" AND';
        }
        // Remove last 'AND'
        $whereClause = substr($whereClause, 0, -3);

        if($request->sort == 'No Sort')
            $query_str = $query_str . $whereClause . ' order by materials.id limit 30';
        else
            $query_str = $query_str . $whereClause . ' order by materials.id';

        $query_str1 = "select cmaterials.image as image, 0 as shop_id, 'USD' as currency,'". $client->companyname ."' as shopname, cmaterials.id as id, cmaterials.description as description, cmaterials.price as price, cmaterials.brand as brand from cmaterials where cmaterials.client_id=".$client_id." and ";
        
        $cmaterials = [];
        if($request->provider != null)
        {
            foreach($request->provider as $filterProvider)
            {
                if($filterProvider == $client->companyname)
                {
                    foreach( $words as $word) {
                        $whereClause1 .= ' cmaterials.description LIKE "%' . $word . '%" AND';
                    }
                    $whereClause1 = substr($whereClause1, 0, -3);
            
                    if($request->sort == 'No Sort')
                        $query_str1 = $query_str1 . $whereClause1 . ' order by cmaterials.id limit 30';
                    else
                        $query_str1 = $query_str1 . $whereClause1 . ' order by cmaterials.id';    
                    $cmaterials = DB::select(DB::raw($query_str1));
                    break;
                }
            }
        }
        else
        {
            foreach( $words as $word) {
                $whereClause1 .= ' cmaterials.description LIKE "%' . $word . '%" AND';
            }
            $whereClause1 = substr($whereClause1, 0, -3);
    
            if($request->sort == 'No Sort')
                $query_str1 = $query_str1 . $whereClause1 . ' order by cmaterials.id limit 30';
            else
                $query_str1 = $query_str1 . $whereClause1 . ' order by cmaterials.id';    
            $cmaterials = DB::select(DB::raw($query_str1));
        }

        $materials = DB::select( DB::raw($query_str));

        $result = array_merge($materials, $cmaterials);
        
        $arr = [];

        for($i = 0; $i < count($result); $i ++)
        {
            $result[$i]->distance = $dists[$result[$i]->shop_id];
            $arr[] = (array) $result[$i];
        }

        if($request->sort == 'Cheapest and Closest')
        {
            usort($arr, function ($a, $b): int {
                if ($a['price'] == $b['price'])
                {
                  // price is the same, sort by endgame
                  if ($a['distance'] == $b['distance']) return 0;
                  return $a['distance'] == 'y' ? -1 : 1;
                }
              
                // sort the higher price first:
                return $a['price'] > $b['price'] ? 1 : -1;
            });
            $arr = array_slice($arr, 0, 30);
        }
        elseif ($request->sort == 'Cheapest')
        {
            usort($arr, function ($a, $b): int {
                return $a['price'] > $b['price'] ? 1 : -1;
            });
            $arr = array_slice($arr, 0, 30);
        }
        elseif ($request->sort == 'Closest')
        {
            usort($arr, function ($a, $b): int {
                return $a['distance'] > $b['distance'] ? 1 : -1;
            });
            $arr = array_slice($arr, 0, 30);
        }
        
        return Response()->json([
            "success" => true,
            "data" => $arr,
        ]);   
    }

    public function getAllShops()
    {
        if(Auth::user()->hasPermissionTo('Employee Administrative') || Auth::user()->hasPermissionTo('Employee Sales'))
        {
            $client_id = Auth::user()->employee->client_id;
            $client = Client::find($client_id);
            $countryTmp = explode('(', $client->country);
            $address = $client->addline1.' '.$countryTmp[0];
        }
        else
        {
            $countryTmp = explode('(', Auth::user()->client->country);
            $address = Auth::user()->client->addline1.' '.$countryTmp[0];
        }

        $shops = Shop::select('id','lat', 'lng')->get();
        return Response()->json([
            "shops" => $shops,
            "address" => $address,
        ]);   
    }

    public function addMaterial(Request $request)
    {
      $data = $request->input();
      if($data['row']['description'] == '' || $data['row']['description'] == null
        || $data['row']['sku'] == '' || $data['row']['sku'] == null
        || $data['row']['price'] == '' || $data['row']['price'] == null
        || $data['shop_id'] == '' || $data['shop_id'] == null
      ){
        return Response()->json([
          "message" => 'failed',
        ]);
      }
      Material::where([['sku', $data['row']['sku']],['shop_id', $data['shop_id']]])->delete();
      $material = Material::create([
        'description' => $data['row']['description'],
        'brand' => $data['row']['brand'],
        'sku' => $data['row']['sku'],
        'partno' => $data['row']['partno'],
        'price' => $data['row']['price'],
        'shop_id' => $data['shop_id'],
        'image' => $data['row']['image'],
      ]);
      return Response()->json([
        "message" => 'success',
      ]);
    }

}
