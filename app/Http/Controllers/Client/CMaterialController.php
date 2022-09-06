<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\CMaterial;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Response;
use File;
use Lang;


class CMaterialController extends Controller
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

        $client_id = 0;
        if(Auth::user()->hasPermissionTo('Employee Administrative') || Auth::user()->hasPermissionTo('Employee Sales'))
            $client_id = Auth::user()->employee->client_id;
        else
            $client_id = Auth::user()->client->id;
            
        $agent = new Agent();  
        if($agent->isMobile())
            $i = -1;
        else
            $i = 1;

        $cmaterials = CMaterial::where('client_id', $client_id)->latest()->get();

        if ($request->ajax()) {
            $data = CMaterial::where('client_id', $client_id)->latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('image', function($row){
                        if($row->image == null && $row->image == '')
                            return 'Image not available';
                        
                        return '<span><img src="'.$row->image.'"  alt="Image not available" width="150" height="150"></span>';
                    })
                    ->editColumn('price', function($row){
                        return '$'.number_format($row->price, 2, '.', ',');
                    })
                    ->addColumn('action', function($row){
                        $btn = '<a href="javascript:void(0)" class="editcmaterials tooltipped" data-id="'.$row->id.'" data-position="bottom" data-tooltip="'.Lang::get('messages.Edit').'"><i class="material-icons">edit</i></a>';
   
                        if(!Auth::user()->hasPermissionTo('Employee Sales'))
                            $btn = $btn.'<a href="javascript:void(0)" class="remove-cmaterials tooltipped" data-id="'.$row->id.'" data-position="bottom" data-tooltip="'.Lang::get('messages.Delete').'"><i class="material-icons">delete</i></a>';
                        return $btn;
                    })
                    ->rawColumns(array('image', 'action'))
                    ->make(true);
        }
      
        return view('user.client.cmaterial.index',compact('cmaterials'), compact('i'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'description'  => 'required',
            'price' => 'numeric',
        ]);

        $client_id = 0;
        if(Auth::user()->hasPermissionTo('Employee Administrative') || Auth::user()->hasPermissionTo('Employee Sales'))
            $client_id = Auth::user()->employee->client_id;
        else
            $client_id = Auth::user()->client->id;

        if($request->typeid == 0)
        {
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
                    $request->image->storeAs('/public/cmaterials', $name);
                    $url = asset("storage/cmaterials/" . $name);
                }
            }
        }
        else
        {
            $cmaterial = CMaterial::find($request->typeid);
            $url = $cmaterial->image;
            if ($request->hasFile('image')) {
                //  Let's do everything here
                if ($request->file('image')->isValid()) {
                    //
                    $validated = $request->validate([
                        'image' => 'mimes:jpeg,png|max:1014',
                    ]);
                    $tmps = explode('/', $cmaterial->image);
                    $image_path = '/cmaterials/' . $tmps[count($tmps) - 1];  // Value is not URL but directory file path
                    Storage::delete('/public' . $image_path);
                    $file = request()->file('image');
                    $name = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                    $request->image->storeAs('/public/cmaterials', $name);
                    $url = asset("storage/cmaterials/" . $name);
                }
            }
        }
        CMaterial::updateOrCreate(['id' => $request->typeid],
                ['provider'=> $request->provider,'description' => $request->description, 'brand' => $request->brand, 'sku' => $request->sku, 'partno' => $request->partno, 'price' => $request->price, 'image' => $url, 'client_id' => $client_id]);        
   
        return response()->json(['success'=>Lang::get('messages.Saved Successfully')]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $type = CMaterial::find($id);
        return response()->json($type);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cmaterial = CMaterial::find($id);
        $tmps = explode('/', $cmaterial->image);
        $image_path = '/cmaterials/' . $tmps[count($tmps) - 1];  // Value is not URL but directory file path
        
        Storage::delete('/public' . $image_path);
        CMaterial::find($id)->delete();
     
       return response()->json(['success'=>Lang::get('messages.Deleted Successfully')]);
    }

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

        $client_id = 0;
        if(Auth::user()->hasPermissionTo('Employee Administrative') || Auth::user()->hasPermissionTo('Employee Sales'))
            $client_id = Auth::user()->employee->client_id;
        else
            $client_id = Auth::user()->client->id;

        request()->validate([
            'file'  => 'required|mimes:xls,xlsx,csv,txt|max:2048000',
        ]);
        $data = $request->input();
        set_time_limit(30000000);
        if ($uploadedFile = $request->file('file')) {
            //store file into document folder
            $file = $request->file->storeAs('public/files', 'myMaterials');
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
                            $header[0] = "provider";
                        }
                        else {
                            if(count($row) != 7)
                            {
                                continue;
                            }
                            $texts = array_combine($header, $row);
                            $material = CMaterial::where('sku', $texts['sku'])->where('client_id', $client_id)->count();
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
        $client_id = 0;
        if(Auth::user()->hasPermissionTo('Employee Administrative') || Auth::user()->hasPermissionTo('Employee Sales'))
            $client_id = Auth::user()->employee->client_id;
        else
            $client_id = Auth::user()->client->id;
        
        $isadd = $request->add;
        // $path = storage_path()."/app/public/files/myMaterials";
        // if (!File::exists($path)) {
        //     return Response()->json([
        //         "success" => false,
        //         "text" => "Can not read upload file."
        //     ]);   
        // }
    
        // $cntRead = 0;
        // $cntUnread = 0;
        // $header = null;
        if($isadd == 0)
            CMaterial::where('client_id', $client_id)->delete();
        // set_time_limit(30000000);
        // if (($handle = fopen($path, 'r')) !== false)
        // {
        //     while (($row = fgetcsv($handle, 10000, ',')) !== false)
        //     {
        //         if (!$header)
        //         {
        //             $header = $row;
        //             $header[0] = "provider";
        //         }
        //         else {
        //             if(count($row) != 7)
        //             {
        //                 $cntUnread ++;
        //                 continue;
        //             }
        //             $texts = array_combine($header, $row);
        //             if($texts['description'] == "" || $texts['provider'] == "" || $texts['price'] == "")
        //             {
        //                 $cntUnread ++;
        //                 continue;
        //             }
        //             if($texts['sku'] != '')
        //                 CMaterial::where([['sku', $texts['sku']],['client_id', $client_id]])->delete();
        //             CMaterial::create ([
        //                 'provider' => (string)$texts['provider'],
        //                 'description' => $texts['description'],
        //                 'brand' => $texts['brand'],
        //                 'sku' => $texts['sku'],
        //                 'partno' => $texts['partno'],
        //                 'price' => $texts['price'],
        //                 'image' => trim($texts['image']),
        //                 'client_id' => $client_id,
        //             ]);
        //             $cntRead ++;
        //         }
                        
        //     }
        //     fclose($handle);
        // }
        // Storage::delete('/public/files/myMaterials');
        // if($cntRead)
        // {
        //     if($cntUnread)
        //     {
        //         return Response()->json([
        //             "success" => true,
        //             "text" => Lang::get('messages.Load ').$cntRead.Lang::get('messages. materials successfully.')."<br/>".$cntUnread.Lang::get("messages. materials information is wrong.")
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

    public function getCMaterials()
    {
        $client_id = 0;
        if(Auth::user()->hasPermissionTo('Employee Administrative') || Auth::user()->hasPermissionTo('Employee Sales'))
            $client_id = Auth::user()->employee->client_id;
        else
            $client_id = Auth::user()->client->id;

        // Open output stream
        $filename = "download.csv";
        $handle = fopen($filename, 'w');

        // Add CSV headers
        fputcsv($handle, [
            'provider', 
            'description',
            'brand',
            'sku',
            'partno',
            'price',
            'image',
        ]);

        // Get all users
        CMaterial::where('client_id', $client_id)->latest()
        ->chunk(30000, function($materials) use($handle) {
            foreach ($materials as $material) {
                // Add a new row with data
                fputcsv($handle, [
                    $material->provider,
                    $material->description,
                    $material->brand,
                    $material->sku,
                    $material->partno,
                    $material->price,
                    $material->image,
                ]);
            }
        });
        // Close the output stream
        fclose($handle);
        $headers = array(
            'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-Disposition' => 'attachment; filename=my_materials.csv',
            'Expires' => '0',
            'Pragma' => 'public',
        );

        return Response::download($filename, "my_materials.csv", $headers)->deleteFileAfterSend(true);;
    }

    function addCMaterial(Request $request)
    {
      $client_id = 0;
      if(Auth::user()->hasPermissionTo('Employee Administrative') || Auth::user()->hasPermissionTo('Employee Sales'))
          $client_id = Auth::user()->employee->client_id;
      else
          $client_id = Auth::user()->client->id;

      $data = $request->input();
      if($data['row']['description'] == '' || $data['row']['description'] == null
        || $data['row']['provider'] == '' || $data['row']['provider'] == null
        || $data['row']['price'] == '' || $data['row']['price'] == null
      ){
        return Response()->json([
          "message" => 'failed',
        ]);
      }

      if($data['row']['sku'] != '' || $data['row']['sku'] != null)
        CMaterial::where([['sku', $data['row']['sku']],['client_id', $client_id]])->delete();
        
      $material = CMaterial::create([
        'provider' => $data['row']['provider'],
        'description' => $data['row']['description'],
        'brand' => $data['row']['brand'],
        'sku' => $data['row']['sku'],
        'partno' => $data['row']['partno'],
        'price' => $data['row']['price'],
        'client_id' => $client_id,
        'image' => $data['row']['image'],
      ]);
      return Response()->json([
        "message" => 'success',
      ]);
    }
}
