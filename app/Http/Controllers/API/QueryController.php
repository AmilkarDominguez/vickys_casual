<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\User;
use App\Store;
use App\Subcategory;
use App\Product;

class QueryController extends Controller
{

    public function find(Request $request)
    {

        if (Product::where('state', 'ACTIVO')->where('barcode',  $request->barcode)->exists()) {


            $Product = Product::where('state', 'ACTIVO')->where('barcode', $request->barcode)->with('store', 'subcategory')->get();

            //$Product = Product::where('barcode', $request->barcode)->get();

            //return $Product;
            return response()->json(['success' => true, 'msg' => 'Registro encontrado', 'obj' => $Product]);
        } else {
            return response()->json(['success' => false, 'msg' => 'El código no esta registrado, intente de nuevo']);
        }


        // return Product::where('estado','ACTIVO')->where('barcode',$request->barcode)->with('store','subcategory')->get();
        return Product::where('state', 'ACTIVO')->get();
    }
    public function list()
    {
        return Product::where('state', 'ACTIVO')->get();
    }
    // public function ejecution_check(Request $request)
    // {
    //     $Ejecution = Ejecution::find($request->id);
    //     $Ejecution->verificado = "REALIZADO";
    //     $Ejecution->update();

    //     $Ejecutions = Ejecution::All()->where('client_id',$Ejecution->client_id)
    //     ->where('plan_id',$Ejecution->plan_id)
    //     ->where('verificado','!=','REALIZADO');

    //     foreach ($Ejecutions as $key => $value) {
    //         if ($value->id<$Ejecution->id) {
    //             $value->verificado = "VENCIDO";
    //             $value->update();
    //         }
    //     }


    //     return response()->json(['success'=>true,'msg'=>'Registro actualizado.']);
    // } 
}
