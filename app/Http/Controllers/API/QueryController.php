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
            return response()->json(['success' => false, 'msg' => 'No se encuntrar registros con la ubicación.']);
            
    }
}
