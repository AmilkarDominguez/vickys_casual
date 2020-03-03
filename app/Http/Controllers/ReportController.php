<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Store;
use App\Activity;
use App\Product;
use DB;

class ReportController extends Controller
{
    // 1.- sacara por rango de fecha y sucursal la cantidad de usuario que se registran a la aplicacion
    public function client_store()
    {
        return view('reports.client_store');
    }
    public function clientstore(Request $request)
    {
        $Store = Store::find($request->store_id);
        return datatables()->of(User::where('store', $Store->name)->whereBetween('created_at', [$request->minimum_date, $request->maximum_date])->get())
            ->toJson();
    }
    // 2.- Sacar por rango de fecha y sucursal  cuantas veces usa un cliente
    public function count_client_store()
    {
        return view('reports.count_client_store');
    }
    public function countclientstore(Request $request)
    {
        $Store = Store::find($request->store_id);
        // return datatables()->of(Activity::where('store', $Store->name)->whereBetween('created_at', [$request->minimum_date, $request->maximum_date])->orderBy('user_id')->with('user')->get())
        // return datatables()->of(DB::table('activities')->groupBy('user_id')->pluck('user_id')->toArray())
        return datatables()->of(Activity::where('store', $Store->name)->whereBetween('created_at', [$request->minimum_date, $request->maximum_date])->groupBy('user_id')->pluck('user_id')->toArray())
            ->addColumn('nro_activities', function ($item) use ($Store, $request) {
                $count = Activity::where('store', $Store->name)->where('user_id', $item)->whereBetween('created_at', [$request->minimum_date, $request->maximum_date])->count();
                return  $count;
            })
            ->addColumn('user_name', function ($item) {
                $user = User::find($item);
                return  $user->name;
            })
            ->addColumn('user_telephone', function ($item) {
                $user = User::find($item);
                return  $user->telephone;
            })
            ->addColumn('user_email', function ($item) {
                $user = User::find($item);
                return  $user->email;
            })
            ->toJson();
    }
    // 3.- sacar por rango de fecha y sucursal cantidad de lecturas de un item
    public function count_activity_item()
    {
        return view('reports.count_activity_item');
    }
    public function countactivityitem(Request $request)
    {
        $Store = Store::find($request->store_id);
        return datatables()->of(Activity::where('store', $Store->name)->whereBetween('created_at', [$request->minimum_date, $request->maximum_date])->groupBy('barcode')->pluck('barcode')->toArray())
            ->addColumn('nro_activities', function ($item) use ($Store, $request) {
                $count = Activity::where('store', $Store->name)->where('barcode', $item)->whereBetween('created_at', [$request->minimum_date, $request->maximum_date])->count();
                return  $count;
            })
            ->addColumn('barcode', function ($item) {
                return  $item;
            })
            ->addColumn('product', function ($item) use ($Store, $request) {
                $activity = Activity::where('store', $Store->name)->where('barcode', $item)->whereBetween('created_at', [$request->minimum_date, $request->maximum_date])->first();
                return  $activity->product;
            })
            ->toJson();
    }
    // 4.- Sacar por rango de fecha y sucursal cantidad de lecturado por sub-grupo
    public function activity_subgroup()
    {
        return view('reports.activity_subgroup');
    }
    public function activitysubgroup(Request $request)
    {
        $Store = Store::find($request->store_id);
        return datatables()->of(Activity::where('store', $Store->name)->whereBetween('created_at', [$request->minimum_date, $request->maximum_date])->groupBy('subcategory')->pluck('subcategory')->toArray())
            ->addColumn('nro_activities', function ($item) use ($Store, $request) {
                $count = Activity::where('store', $Store->name)->where('subcategory', $item)->whereBetween('created_at', [$request->minimum_date, $request->maximum_date])->count();
                return  $count;
            })
            ->addColumn('subgroup', function ($item) {
                return  $item;
            })
            ->toJson();
    }
}
