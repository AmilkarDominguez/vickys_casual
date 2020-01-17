<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Store;
use App\Http\Requests\StoreRequest;
use Validator;

class StoreController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.Store');
    }

    public function store(Request $request)
    {
        $rule = new StoreRequest();
        $validator = Validator::make($request->all(), $rule->rules());
        if ($validator->fails()) {
            return response()->json(['success' => false, 'msg' => $validator->errors()->all()]);
        } else {
            Store::create($request->all());
            return response()->json(['success' => true, 'msg' => 'Registro existoso.']);
        }
    }
    public function edit(Request $request)
    {
        $Store = Store::find($request->id);
        return $Store->toJson();
    }

    public function update(Request $request)
    {
        $rule = new StoreRequest();
        $validator = Validator::make($request->all(), $rule->rules());
        if ($validator->fails()) {
            return response()->json(['success' => false, 'msg' => $validator->errors()->all()]);
        } else {
            $Store = Store::find($request->id);
            $Store->update($request->all());
            return response()->json(['success' => true, 'msg' => 'Se actualizo existosamente.']);
        }
    }

    public function destroy(Request $request)
    {
        $Store = Store::find($request->id);
        $Store->state = "ELIMINADO";
        $Store->update();
        return response()->json(['success' => true, 'msg' => 'Registro borrado.']);
    }
    //FUNCTIONS
    public function datatable()
    {
        return datatables()->of(Store::where('state', '!=', 'ELIMINADO')->get())
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
        return Store::where('state', 'ACTIVO')->get();
    }
}
