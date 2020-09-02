<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session, file;

//Model
use App\Model\MetaMaster;
use App\Model\MetaSlave;
use App\Model\Shop;
use App\Model\Diamond;
use App\Model\DiamondMedia;
use App\Model\DiamondParameter;

class MetaDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $metalists=MetaMaster::get();
        // return $metalists;
        return view('MetaData.list_meta',compact('metalists'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       if($request->file('icon')){
               $image = $request->file('icon');
               $imageName = time().'.'.$image->getClientOriginalExtension();
               $destinationPath = public_path('/images');
               $image->move($destinationPath, $imageName);
            //    echo $imageName;
        }else{
               $imageName=null;
        }

        if($request->metadataId){
            $metamaster     =MetaMaster::find($request->metadataId);
            \Storage::delete(public_path("images/').$metamaster->icon'"));

            if($imageName == null){
                $imageName=$metamaster->icon;
            }

            $message        ="Data updated successfully";
        }else{
            $metamaster     =new MetaMaster;
            $message        ="Data created successfully";
        }

        $metamaster->name                 =$request->get('name');
        $metamaster->is_searchable        =$request->get('is_searchable');
        $metamaster->has_defined_value    =$request->get('has_defined_value');
		$metamaster->created_dt           =date('Y-m-d H:i:s');
        $metamaster->input_type           =$request->get('input_type');
        $metamaster->tooltip              =$request->get('tooltip');
        $metamaster->icon                 =$imageName;

        $metamaster->save();

        return redirect('view_meta_data')->with('success',$message );
    }

    //For Show Add or edit Page
    public function show($id=null)
    {
        if($id != null){
            $metadata=MetaMaster::where('id',$id)->first();
            // return $metadata;
        }else{
            $metadata=null;
        }
        return view('MetaData.post_meta',compact('metadata'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MetaData  $metaData
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $MetaMaster = MetaMaster::find($id);
        $MetaMaster->delete();
        return back()->with('success','Data deleted successfully!');
    }

    //For List page of add value page
    public function viewValues(Request $request, $Id)
    {
        $metaslaves=MetaSlave::where('master_id',$Id)->get();
        // if(!$metaslaves){
        //     $metaslaves=null;

        // }
        // return $metaslaves;
        $masterId=$Id;
        return view('DataValue.list_value',compact('metaslaves','masterId'));
    }



    //For Show Add or edit page of Value
    public function addMetaValueShow($mid)
    {
        // if($id != null){
        //     $metaslave=MetaSlave::where('id',$id)->first();
        //     // return $metadata;
        // }else{
            $metaslave=null;
        // }
        $masterId=$mid;
        return view('DataValue.post_value',compact('metaslave','masterId'));
    }


    //For Add or Edit Post Data
    public function postValueSave(Request $request)
    {
        if($request->metaSlaveId){
            $metaslave      =MetaSlave::find($request->metaSlaveId);


            $master_Id=$metaslave->master_id;
            $message        ="Data updated successfully";
        }else{
            $metaslave      =new MetaSlave;
            $message        ="Data created successfully";
            $master_Id=$request->get('masterId');
        }

        $metaslave->value                =$request->get('value');
        $metaslave->is_active            =$request->get('is_active');
        $metaslave->master_id            =$master_Id;
        $metaslave->save();

        // $message        ="Data created successfully";
        return redirect()->route('view_values',$master_Id)->with('message', $message);
    }


    public function editMetaValue(Request $request, $Id)
    {
        $metaslave=MetaSlave::find($Id);
    //    return $metaslave;
        $masterId=1;
        return view('DataValue.post_value',compact('metaslave','masterId'));
    }


    //Value Delete
    public function destroyValue($id)
    {
        $MetaMaster = MetaSlave::find($id);
        $MetaMaster->delete();
        return back()->with('success','Data deleted successfully!');
    }


     public function listShop(Request $request)
     {
        $shops=Shop::get();
        // return $shops;
        return view('shop.list_shop',compact('shops'));
     }


     public function addShop($id=null)
     {

         if($id != null){
             $shop=Shop::find($id);
            //  return $shop;
         }else{
            $shop=null;
         }

         return view('shop.post_shop',compact('shop'));
     }

     //For Add or Edit Shop information
     public function postShop(Request $request)
     {
        if($request->file('shop_image')){
            $image = $request->file('shop_image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $imageName);
         //    echo $imageName;
        }else{

            $imageName=null;
        }

        if($request->shopId){
            $shop           =Shop::find($request->shopId);
            $shop->lastupdate_dt     =date('Y-m-d H:i:s');
            if($imageName == null){
                $imageName=$shop->shop_image;
            }

            $message="Data update Successfully";
        }else{
            $shop =new Shop();
            $shop->created_dt     =date('Y-m-d H:i:s');
            $message="Data Save Successfully";
        }

        $searchVal = array("http://", "https://");
        $newurl=str_replace($searchVal,"",$request->get('shop_url'));

        $shop->shop_name      =$request->get('shop_name');
        $shop->shop_url       =$newurl;
        $shop->shop_url_type  =$request->get('shop_url_type');
        $shop->is_active      =$request->get('is_active');
        $shop->shop_image     =$imageName;
        $shop->save();

        return redirect('list_shop')->with('success',$message );
     }


     public function deleteshop($Id)
     {
        $shop = Shop::find($Id);
        $shop->delete();
        return back()->with('success','Data deleted successfully!');
     }


     public function listDiamond()
     {
        $diamonds=Diamond::with('shopDetails')->get();
        // return $diamonds;
        return view('Diamond.list_diamond',compact('diamonds'));
     }


     public function addDiamond(Request $request,$Id=null)
     {
        if($Id != null){
            $diamond            =Diamond::find($Id);
            $dparameters        =DiamondParameter::where('diamond_id',$Id)->with('typeDetails')->get();
        //    return $dparameters;
            // return $diamond_details;
        }else{
            $diamond            =null;
            $dparameters   =null;
        }
         $shops=Shop::select('id','shop_name')->where('is_active',1)->get();
         $metalists=MetaMaster::select('id','name','input_type')->get();
        //  return $metalists;
        return view('Diamond.post_diamond',compact('diamond','shops','metalists','dparameters'));
     }


     public function postDiamond(Request $request)
     {
        if($request->diamondId){
            $diamond   =    Diamond::find($request->diamondId);
            $DiamondParameter=DiamondParameter::where('diamond_id',$request->diamondId)->get();
            if($DiamondParameter){
                $DiamondParameter=DiamondParameter::where('diamond_id',$request->diamondId)->delete();
            }

            $message="Data update Successfully";
        }else{
            $diamond =new Diamond();
            $diamond->created_dt     =date('Y-m-d H:i:s');
            $message="Data Save Successfully";
        }

        $diamond->shop_id                   =$request->get('shop_id');
        $diamond->diamond_retail_price	    =$request->get('diamond_retail_price');
        $diamond->diamond_sale_price        =$request->get('diamond_sale_price');
        $diamond->diamond_title             =$request->get('diamond_title');
        $diamond->diamond_description	    =$request->get('diamond_description');
        $diamond->stock_value               =$request->get('stock_value');
        $diamond->diamond_sku               =$request->get('diamond_sku');
        $diamond->shape                     =$request->get('shape');
        $diamond->last_updated_dt           =date('Y-m-d H:i:s');
        $diamond->created_ip                = \Request::ip();
        $diamond->save();

        // $diamond->id;
        //For Save DiamondMedia information
        if($request->file('d_image')){
            $image = $request->file('d_image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $imageName);
        }else{
            $imageName=null;
        }

        if($request->file('d_video')){
            $video = $request->file('d_video');
            $videoName = time().'.'.$video->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $video->move($destinationPath, $videoName);
        }else{
            $videoName=null;
        }


        if($imageName !=null && $videoName !=null){
            $totalMedia=1;
        }else{
             $totalMedia=0;
        }

        for($i=0;$i<$totalMedia;$i++)
        {
           if($imageName != null){
            $diamondmedia = new DiamondMedia();
            $diamondmedia->media_type   ='photo';
            $diamondmedia->media_path   =$imageName;
            $diamondmedia->diamond_id   =$diamond->id;
            $diamondmedia->save();

            }if($videoName != null){
            $diamondmedia = new DiamondMedia();
            $diamondmedia->media_type   ='video';
            $diamondmedia->media_path   =$videoName;
            $diamondmedia->diamond_id   =$diamond->id;
            $diamondmedia->save();
          }
        }

        //For DiamondParameter save information
        foreach($request->dima as $key=> $single_dima){
            $DiamondParameter                    =new DiamondParameter();
            $DiamondParameter->parameter_name    =strstr($key,"_", true);
            $DiamondParameter->parameter_value   =$single_dima;
            $DiamondParameter->diamond_id        =$diamond->id;
            $DiamondParameter->master_id         =substr($key, strpos($key, "_") + 1);
            $DiamondParameter->save();
         }

        return redirect('list_diamond')->with('success',$message );
     }


     public function deleteDiamond($Id)
     {
        $Diamond = Diamond::find($Id);
        $Diamond->delete();
        return back()->with('success','Data deleted successfully!');
     }



}
