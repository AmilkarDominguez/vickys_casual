<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use Auth;


class AuthenticareSample extends Controller
{

    use RegistersUsers;
    protected $redirectTo = '/Consulta';
    
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function login(Request $request){

        $user = User::where('telephone', $request->telephone)->get()->first();
        //dd($user);
        if (!empty($user)) {
            if (Hash::check($request->password, $user['password']))
            {
                // Auth::login($user);
                auth()->login($user);
                return view('Consulta');
            }
            else {
                return Redirect::back()->
                with('authError', 'Email o contraseña incorrectos')->
                withInput($request->except('password'));
            }

        } else {
            User::create([
                'telephone' => $request['telephone'],
                'password' => Hash::make($request['password']),
                'remember_token' => str_random(10),
                'state' => 'ACTIVO',
            ]);
            return view('Consulta');
        }
    }
}
