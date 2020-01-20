@extends('layouts.vc_app')


@section('styles')
<link href="{{ asset('css/bootstrap_.css') }}" rel="stylesheet">
<link href="{{ asset('css/signin.css') }}" rel="stylesheet">
@endsection

@section('content')



<form class="form-signin" method="POST" action="{{ route('entrar') }}">
    @csrf
        <img class="mb-4" src="resources/vc.png" alt="" width="250">
        <h1 class="h3 mb-3 font-weight-normal">REGÍSTRATE</h1>

        <label for="inputEmail" class="sr-only">celular</label>
        <input type="number" id="telephone" class="form-control  @error('telephone') is-invalid @enderror" name="telephone" placeholder="celular" value="{{ old('telephone') }}" required autofocus>
        <label for="inputPassword" class="sr-only">contraseña</label>
        <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="contraseña" required>
        <div class="d-flex flex-row bd-highlight mb-3">
            <div class="p-2 bd-highlight">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" value="remember-me"> mostrar contraseña
                    </label>
                    <!--<br>
                <a class="text-white" data-toggle="modal" data-target="#exampleModal">Registrarse</a> -->
                </div>
            </div>
        </div>
        {{-- <a class="btn btn-lg bg-white btn-block text-dark" type="submit">Log in</a>> --}}
        <button class="btn btn-lg bg-white btn-block text-dark" type="submit">Log in</button>
        <a href="{{url('/redirect')}}"  style="margin-top: 15px;" class="btn btn-lg bg-white btn-block"><i class="fab fa-facebook"></i>Registrate con facebook</a>
        <!-- <p class="mt-5 mb-3 text-muted">&copy; 2020</p> -->


</form>



<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                        <br />
                        <p style="margin-left:265px">OR</p>
                        <br />
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                              <a href="{{url('/redirect')}}" class="btn btn-primary">Login with Facebook</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->
@endsection