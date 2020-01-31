<?php

namespace App\Http\Controllers;
use Auth;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class LoginUserController extends Controller
{
    use ThrottlesLogins,RegistersUsers;


    protected $redirectTo = '/consulta';

    //Intentos máximos de inicio de sesión permitidos.
    public $maxAttempts = 5;

    //Número de minutos para bloquear el inicio de sesión.
    public $decayMinutes = 3;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $this->validator($request);
        // comprueba si el usuario tiene demasiados intentos de inicio de sesión.
        if($this->hasTooManyLoginAttempts($request)) {
            // Activa el evento de bloqueo
            $this->fireLockoutEvent($request);
            //redirigir al usuario nuevamente después del bloqueo.
            return $this->sendLockoutResponse($request);
        }
        if (Auth::attempt($request->only('telephone','password'), $request->filled('remember'))) {

            return redirect()
                ->intended(route('consulta'))
                ->with('status', 'You are Logged in as Admin!');
        }
        //realizar un seguimiento de los intentos de inicio de sesión del usuario.
        $this->incrementLoginAttempts($request);

        //Error de autenticación, redirigir de nuevo con la entrada.
        $user = User::where('telephone', $request->telephone)->get()->first();
        if (!empty($user)) {

            return $this->loginFailed();
         }
         else {
             $data = $request->toArray();
             return $this->register($request);
         }

    }

    private function validator(Request $request)
    {
        $rules = [
            'telephone' => 'required|string|min:8|max:8',
            'password'  => 'required|string|min:5|max:255',
        ];
        $messages = [
            'telephone.exists' => 'Estas credenciales no coinciden con nuestros registros.',
        ];

        //validate the request.
        $request->validate($rules,$messages);
    }
    private function loginFailed(){
        return redirect()
            ->back()
            ->withInput()
            ->with('error','Login failed, please try again!');
    }
    public function register(Request $request)
    {
        //$this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));
        $this->guard()->login($user);
        return $this->registered($request, $user)
                        ?: redirect()->intended($this->redirectPath());
    }
    
    protected function create(array $data) {

        return User::create([
            'telephone' => $data['telephone'],
            'password' => Hash::make($data['password']),
            'remember_token' => str_random(20),
            'state' => 'ACTIVO',
        ]);
    }

    public function username(){
        return 'telephone';
    }
}
