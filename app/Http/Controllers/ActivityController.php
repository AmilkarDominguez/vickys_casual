<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Activity;
use App\Http\Requests\ActivityRequest;
use Validator;
use Auth;
use App\User;
use App\Store;


class ActivityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function consulta()
    {
        return view('Consulta');
    }

    public function index()
    {
        if (Auth::user()->rol == 'ADMIN') {
            return view('admin.Activity');
        } else {
            return view('Consulta');
        }
    }

    public function store(Request $request)
    {
        $rule = new ActivityRequest();
        $validator = Validator::make($request->all(), $rule->rules());
        if ($validator->fails()) {
            return response()->json(['success' => false, 'msg' => $validator->errors()->all()]);
        } else {
            Activity::create($request->all());
            return response()->json(['success' => true, 'msg' => 'Registro existoso.']);
        }
    }
    public function edit(Request $request)
    {
        $Activity = Activity::find($request->id);
        return $Activity->toJson();
    }

    public function update(Request $request)
    {
        $rule = new ActivityRequest();
        $validator = Validator::make($request->all(), $rule->rules());
        if ($validator->fails()) {
            return response()->json(['success' => false, 'msg' => $validator->errors()->all()]);
        } else {
            $Activity = Activity::find($request->id);
            $Activity->update($request->all());
            return response()->json(['success' => true, 'msg' => 'Se actualizo existosamente.']);
        }
    }

    public function destroy(Request $request)
    {
        $Activity = Activity::find($request->id);
        $Activity->state = "ELIMINADO";
        $Activity->update();
        return response()->json(['success' => true, 'msg' => 'Registro borrado.']);
    }
    //FUNCTIONS
    public function datatable()
    {
        return datatables()->of(Activity::where('state', '!=', 'ELIMINADO')->with('user')->get())
            ->addColumn('Editar', function ($item) {
                return '<a class="btn btn-xs btn-primary text-white" onclick="Edit(' . $item->id . ')" ><i class="icon-pencil"></i></a>';
            })
            ->addColumn('Eliminar', function ($item) {
                return '<a class="btn btn-xs btn-danger text-white" onclick="Delete(\'' . $item->id . '\')"><i class="icon-trash"></i></a>';
            })
            ->rawColumns(['Editar', 'Eliminar'])
            ->toJson();
    }
    public function list()
    {
        return Activity::where('state', 'ACTIVO')->get();
    }
}
