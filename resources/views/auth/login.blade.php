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
        <input type="password" id="password" class="form-control text-white @error('password') is-invalid @enderror" name="password" placeholder="contraseña" required>
        <input hidden class="form-check-input" type="checkbox" name="remember" id="remember" checked>
        <div class="d-flex flex-row bd-highlight mb-3">
            <div class="p-2 bd-highlight">
                <div class="checkbox">
                    <label>
                        <input id="show_pass" onclick="ShowPass()" type="checkbox" value="true"><span id="text_showpass"> mostrar contraseña</span>
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

<script>
function ShowPass(){
    if($("#show_pass").val()=="true"){
        $("#password").prop("type", "text");
        $("#show_pass").val("false")
        $("#text_showpass").html(" ocultar contraseña");
    }
    else{
        $("#password").prop("type", "password");
        $("#show_pass").val("true");
        $("#text_showpass").html(" mostrar contraseña");
    }
    
};
</script>
@endsection