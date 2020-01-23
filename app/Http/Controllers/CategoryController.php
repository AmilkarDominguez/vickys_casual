<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Http\Requests\CategoryRequest;
use Validator;
use Auth;
use App\User;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if(Auth::user()->rol=='ADMIN'){
            return view('admin.Category');
        }
        else {
            return view('Consulta');
        }
    }

    public function store(Request $request)
    {
        $rule = new CategoryRequest();
        $validator = Validator::make($request->all(), $rule->rules());
        if ($validator->fails()) {
            return response()->json(['success' => false, 'msg' => $validator->errors()->all()]);
        } else {
            Category::create($request->all());
            return response()->json(['success' => true, 'msg' => 'Registro existoso.']);
        }
    }
    public function edit(Request $request)
    {
        $Category = Category::find($request->id);
        return $Category->toJson();
    }

    public function update(Request $request)
    {
        $rule = new CategoryRequest();
        $validator = Validator::make($request->all(), $rule->rules());
        if ($validator->fails()) {
            return response()->json(['success' => false, 'msg' => $validator->errors()->all()]);
        } else {
            $Category = Category::find($request->id);
            $Category->update($request->all());
            return response()->json(['success' => true, 'msg' => 'Se actualizo existosamente.']);
        }
    }

    public function destroy(Request $request)
    {
        $Category = Category::find($request->id);
        $Category->state = "ELIMINADO";
        $Category->update();
        return response()->json(['success' => true, 'msg' => 'Registro borrado.']);
    }
    //FUNCTIONS
    public function datatable()
    {
        return datatables()->of(Category::where('state', '!=', 'ELIMINADO')->get())
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
        return Category::where('state', 'ACTIVO')->get();
    }
}
