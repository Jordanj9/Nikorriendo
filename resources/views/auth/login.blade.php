@extends('layouts.app')
@section('content')
<div class="login-box">
    <div class="login-logo">
        <a href="../../index2.html">{{config('app.name')}}<b>Valledupar</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Iniciar Sessión</p>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group has-feedback">
                <input type="number" class="form-control{{ $errors->has('identificacion') ? ' is-invalid' : '' }}" placeholder="Identificación" id="identificacion" name="identificacion" value="{{ old('identificacion') }}" required autofocus>
                <span class="fa fa-credit-card form-control-feedback"></span>
                @if ($errors->has('identificacion'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('identificacion') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group has-feedback">
                @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('rol') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group has-feedback">
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="Contraseña">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>  Recordarme
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-md-12">
                    <button type="submit" class="btn btn-danger btn-raised btn-block btn-flat"> Ingresar</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
        <a href="{{route('register')}}" class="text-center"> ¿No tienes una cuenta? Registrate</a>
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->  
@endsection