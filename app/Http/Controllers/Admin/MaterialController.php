<?php

namespace App\Http\Controllers\Admin;

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
use Lang;

class MaterialController extends Controller
{

    //Check if user has list permission
    public function __construct()
    {
        $this->middleware(['permission:List Materials']);
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
        set_time_limit(30000000);
        if ($uploadedFile = $request->file('file')) {
            //store file into document folder
            $file = $request->file->storeAs('public/files', $data['shop_id']);
            $cnt = 0;      
            $rowcount = count(file($uploadedFile)) - 1;
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
                        "text" => "You are uploading ".$rowcount." records to the list"
                    ]);    
                else
                    return Response()->json([
                        "success" => true,
                        "text" => "You are uploading ".$rowcount." records to the list: ".$cnt." records have the same SKU and will be replace with the new ones"
                    ]);    
            }
            //store your file into database
            //$document = new Document();
            //$document->title = $file;
            //$document->save();
                
            return Response()->json([
                "success" => true,
                "text" => "You are uploading ".$rowcount." records to the list. Old records will be deleted"
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
        
        $shop_id = $request->shop_id;
        $isadd = $request->add;
        $path = storage_path()."/app/public/files/".$shop_id;
        if (!File::exists($path)) {
            return Response()->json([
                "success" => false,
                "text" => "Can not read upload file."
            ]);   
        }
    
        $cntRead = 0;
        $cntUnread = 0;
        $header = null;
        if($isadd == 0)
            Material::where('shop_id', $shop_id)->delete();
        set_time_limit(30000000);
        if (($handle = fopen($path, 'r')) !== false)
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
                        $cntUnread ++;
                        continue;
                    }
                    $texts = array_combine($header, $row);
                    if($texts['description'] == "" || $texts['sku'] == "" || $texts['price'] == "")
                    {
                        $cntUnread ++;
                        continue;
                    }
                    Material::where([['sku', $texts['sku']],['shop_id', $shop_id]])->delete();
                    Material::create ([
                        'description' => $texts['description'],
                        'brand' => $texts['brand'],
                        'sku' => $texts['sku'],
                        'partno' => $texts['partno'],
                        'price' => $texts['price'],
                        'image' => trim($texts['image']),
                        'shop_id' => $shop_id,
                    ]);
                    $cntRead ++;
                }
                        
            }
            fclose($handle);
        }
        Storage::delete('/public/files/'.$shop_id);
        if($cntRead)
        {
            if($cntUnread)
            {
                return Response()->json([
                    "success" => true,
                    "text" => "Load ".$cntRead." materials successfully.<br/>".$cntUnread." materials information is wrong."
                ]);   
            }
            else
            {
                return Response()->json([
                    "success" => true,
                    "text" => "Load ".$cntRead." materials successfully."
                ]);   
            }
        }
        return Response()->json([
            "success" => false,
            "text" => "All material information of file is wrong."
        ]);   
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getShopList(Request $request)
    {
        if($request->email == "All")
        {
            $shops = Shop::pluck('name');    
        }
        else{
            $provider = Provider::where('companyname', $request->email)->first();
            $shops = Shop::where('provider_id', $provider->id)->pluck('name');
        }
        return  response()->json($shops);
    }
    public function index(Request $request)
    {
        //
        $filter = $request->input();
            
        $agent = new Agent();
        
        //$materials =  DB::select( DB::raw("select materials.id as id, materials.description as description, materials.brand as brand, materials.sku as sku, materials.price as price, materials.partno as partno, materials.image as image, materials.shop_id as shop_id, shops.name as shoplist, providers.companyname as providerlist, shops.currency as currency from materials, shops, providers where materials.shop_id = shops.id and shops.provider_id = providers.id order by shops.provider_id, materials.shop_id, materials.id"));
        if(!($request->has('providerlist') && $request->has('shoplist')) || ($filter['providerlist'] == "All" && $filter['shoplist'] == "All"))
            $materials = DB::table('materials')
                        ->join('shops', 'materials.shop_id', '=', 'shops.id')
                        ->join('providers', 'shops.provider_id', '=', 'providers.id')
                        ->select('materials.id as id', 'materials.description as description', 'materials.brand as brand', 'materials.sku as sku', 'materials.price as price', 'materials.partno as partno', 'materials.image as image', 'materials.shop_id as shop_id', 'shops.name as shoplist', 'providers.companyname as providerlist', 'shops.currency as currency')
                        ->orderby('shops.provider_id')
                        ->orderby('materials.shop_id')
                        ->orderby('materials.id')
                        ->paginate(10);
        else
        {
            if($filter['providerlist'] == "All")
                $materials = DB::table('materials')
                            ->join('shops', 'materials.shop_id', '=', 'shops.id')
                            ->join('providers', 'shops.provider_id', '=', 'providers.id')
                            ->where('shops.name', $filter['shoplist'])
                            ->select('materials.id as id', 'materials.description as description', 'materials.brand as brand', 'materials.sku as sku', 'materials.price as price', 'materials.partno as partno', 'materials.image as image', 'materials.shop_id as shop_id', 'shops.name as shoplist', 'providers.companyname as providerlist', 'shops.currency as currency')
                            ->orderby('shops.provider_id')
                            ->orderby('materials.shop_id')
                            ->orderby('materials.id')
                            ->paginate(10);
            else if($filter['shoplist'] == "All")
                $materials = DB::table('materials')
                            ->join('shops', 'materials.shop_id', '=', 'shops.id')
                            ->join('providers', 'shops.provider_id', '=', 'providers.id')
                            ->where('providers.companyname', $filter['providerlist'])
                            ->select('materials.id as id', 'materials.description as description', 'materials.brand as brand', 'materials.sku as sku', 'materials.price as price', 'materials.partno as partno', 'materials.image as image', 'materials.shop_id as shop_id', 'shops.name as shoplist', 'providers.companyname as providerlist', 'shops.currency as currency')
                            ->orderby('shops.provider_id')
                            ->orderby('materials.shop_id')
                            ->orderby('materials.id')
                            ->paginate(10);
            else
                $materials = DB::table('materials')
                            ->join('shops', 'materials.shop_id', '=', 'shops.id')
                            ->join('providers', 'shops.provider_id', '=', 'providers.id')
                            ->where('providers.companyname', $filter['providerlist'])
                            ->where('shops.name', $filter['shoplist'])
                            ->select('materials.id as id', 'materials.description as description', 'materials.brand as brand', 'materials.sku as sku', 'materials.price as price', 'materials.partno as partno', 'materials.image as image', 'materials.shop_id as shop_id', 'shops.name as shoplist', 'providers.companyname as providerlist', 'shops.currency as currency')
                            ->orderby('shops.provider_id')
                            ->orderby('materials.shop_id')
                            ->orderby('materials.id')
                            ->paginate(10);
        }
        $providers = Provider::orderby('id')->pluck('companyname');
        if($agent->isMobile())
            $i = -1;
        else
            $i = (request()->input('page', 1) - 1) * 10;
        return view('admin.material.index')->with('materials', $materials)->with('filter', $filter)
            ->with('i', $i)->with('providers', $providers);
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
        $shopname = $data['shoplist'];
        $providerEmail = $data['providerlist'];
        $provider = Provider::where('companyname', $providerEmail)->first();
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
        return redirect()->route('materials.index', [$materials->shop_id]);
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
        $providers = Provider::pluck('companyname');
        $material = DB::select( DB::raw("select materials.id as id, materials.description as description, materials.brand as brand, materials.sku as sku, materials.price as price, materials.partno as partno, materials.image as image, materials.shop_id as shop_id, shops.name as shoplist, providers.companyname as providerlist, shops.currency as currency from materials, shops, providers where materials.id = " . $id . " and materials.shop_id = shops.id and shops.provider_id = providers.id limit 1") );
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

        $materials = Material::find($id);
        $data = $request->input();
        
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
         $shopname = $data['shoplist'];
         $providerEmail = $data['providerlist'];
         $provider = Provider::where('companyname', $providerEmail)->first();
         $shop = Shop::where([
             ['provider_id', '=', $provider->id],
             ['name', '=', $shopname],
             ])->first();

             
        $data = $request->input();
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
        return redirect()->route('materials.index', [$materials->shop_id]);
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
        return redirect()->route('materials.index');
    }
}
