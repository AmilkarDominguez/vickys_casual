<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Store;
use App\Activity;

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
        return datatables()->of(Activity::where('store', $Store->name)->whereBetween('created_at', [$request->minimum_date, $request->maximum_date])->orderBy('user_id')->with('user')->get())

            ->addColumn('nro_activities', function ($item) use ($Store, $request) {
                $count = Activity::where('store', $Store->name)->where('user_id', $item->user_id)->whereBetween('created_at', [$request->minimum_date, $request->maximum_date])->count();
                return  $count;
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
        return datatables()->of(Activity::all()->where('payment_status_id', 5)->where('seller_id', $request->seller_id)->whereBetween('date', [$request->minimum_date, $request->maximum_date]))
            ->toJson();
    }
    // 4.- Sacar por rango de fecha y sucursal cantidad de lecturado por sub-grupo
    public function activity_subgroup()
    {
        return view('reports.activity_subgroup');
    }
    public function activitysubgroup(Request $request)
    {
        return datatables()->of(Activity::all()->where('payment_status_id', 5)->where('seller_id', $request->seller_id)->whereBetween('date', [$request->minimum_date, $request->maximum_date]))
            ->toJson();
    }
}
