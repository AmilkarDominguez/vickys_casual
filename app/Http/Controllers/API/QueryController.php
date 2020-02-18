<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\User;
use App\Store;
use App\Subcategory;
use App\Product;
use App\Activity;

class QueryController extends Controller
{

    public function find(Request $request)
    {
        if (Product::where('state', 'ACTIVO')->where('barcode',  $request->barcode)->exists()) {
            $Stores = Store::All()->where('state', 'ACTIVO');
            $str;
            foreach ($Stores as $item) {
            
                if (($item->lat==$request->lat) && ($item->lng==$request->lng)) {

                    $str=$item;

                    $Product = Product::where('state', 'ACTIVO')
                    ->where('barcode', $request->barcode)
                    ->where('store_id', $item->id)
                    ->with('store', 'subcategory')
                    ->first();
    
    
                    //Registro actividad
                    $Activity = Activity::create([
                        'user_id' => $request->user_id,
                        'product_id' => $Product->id,
                    ]);
    
                    return response()->json(['success' => true, 'msg' => 'Registro encontrado', 'obj' => $Product]);

                }
            }
            return response()->json(['success' => true, 'msg' => 'Registro encontrado', 'obj' => $str]);

            foreach ($Stores as $value) {
                // $store_lat = round(floatval($value->lat), 3);
                // $store_lng = round(floatval($value->lng), 3);
                if ($value->id==4) {
                    return response()->json(['success' => true, 'msg' => 'Registro encontrado', 'obj' => $value]);
                    // return response()->json([
                    //     'success' => true, 
                    //     'msg' => 'FUNCIONA!',
                    //     '$request->lat' => $request->lat,
                    //     '$request->lng' => $request->lng,
                    //     '$value->lat' => $value->lat,
                    //     '$value->lng' => $value->lng,
                    // ]);
                }
                if ($store_lat === $lat_ && $store_lng===$lng_) {
                   
                    $Store = $value;    
                }
                else {
                    return response()->json(['success' => false, 'msg' => 'No se encuntrar registros con la ubicaci車n.']);
                }
            }
            if ($Store != null) {
            }else {
                return response()->json(['success' => false, 'msg' => 'No se encuntrar registros con la ubicaci車n.']);
            }

        } else {
            return response()->json(['success' => false, 'msg' => 'El c車digo no esta registrado, intente de nuevo']);
        }


    }
}
                // //======================================================
                // if($value->id==7){
                                    
                //     return response()->json(['success' => true, 'msg' => 'LLEGANDO', 
                //     'value' => $value,
                //     'request_lat' => $request->lat,
                //     'request_lng' => $request->lng,

                //     'lat_' => $lat_,
                //     'lng_' => $lng_,
                //     'store_lat_' => $store_lat,
                //     'store_lng_' => $store_lng,
                //     ]);
                // }
                
                // //=======================================================