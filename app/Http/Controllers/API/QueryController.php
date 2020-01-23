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
            $Product = Product::where('state', 'ACTIVO')->where('barcode', $request->barcode)->with('store', 'subcategory')->first();
            //Redonde de ubicación
            $Product->store->lat = round($Product->store->lat, 3);
            $Product->store->lng = round($Product->store->lng, 3);

            // if (true) {
            if ($Product->store->lat == $request->lat && $Product->store->lng == $request->lng) {


                $Activity = Activity::create([
                    'user_id' => $request->user_id,
                    'product_id' => $Product->id,
                ]);

                return response()->json(['success' => true, 'msg' => 'Registro encontrado', 'obj' => $Product]);
            } else {
                return response()->json(['success' => false, 'msg' => 'No se encuntrar registros con la ubicación.']);
            }
        } else {
            return response()->json(['success' => false, 'msg' => 'El código no esta registrado, intente de nuevo']);
        }
    }
}
