<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subcategory;
use App\Http\Requests\SubcategoryRequest;
use Validator;
use Auth;
use App\User;
class SubcategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        if(Auth::user()->rol=='ADMIN'){
            return view('admin.Subcategory');
        }
        else {
            return view('Consulta');
        }
    }

    public function store(Request $request)
    {
        $rule = new SubcategoryRequest();
        $validator = Validator::make($request->all(), $rule->rules());
        if ($validator->fails()) {
            return response()->json(['success' => false, 'msg' => $validator->errors()->all()]);
        } else {
            Subcategory::create($request->all());
            return response()->json(['success' => true, 'msg' => 'Registro existoso.']);
        }
    }
    public function edit(Request $request)
    {
        $Subcategory = Subcategory::find($request->id);
        return $Subcategory->toJson();
    }

    public function update(Request $request)
    {
        $rule = new SubcategoryRequest();
        $validator = Validator::make($request->all(), $rule->rules());
        if ($validator->fails()) {
            return response()->json(['success' => false, 'msg' => $validator->errors()->all()]);
        } else {
            $Subcategory = Subcategory::find($request->id);
            $Subcategory->update($request->all());
            return response()->json(['success' => true, 'msg' => 'Se actualizo existosamente.']);
        }
    }

    public function destroy(Request $request)
    {
        $Subcategory = Subcategory::find($request->id);
        $Subcategory->state = "ELIMINADO";
        $Subcategory->update();
        return response()->json(['success' => true, 'msg' => 'Registro borrado.']);
    }
    //FUNCTIONS
    public function datatable()
    {
        return datatables()->of(Subcategory::where('state', '!=', 'ELIMINADO')->with('category')->get())
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
        return Subcategory::where('state', 'ACTIVO')->get();
    }
}
