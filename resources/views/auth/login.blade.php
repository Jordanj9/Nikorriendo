@extends('layouts.app')
@section('style')
    <style>
        .login-box-body {
          border-radius: 20px;
          border: 1px solid white;
          opacity: 0.95;
          color: black;
        }
        @media (max-width: 468px){
            .login-logo a{
                font-size: 28px;
            }
        }

    </style>
@endsection
@section('content')
<div class="login-box">
    <div class="login-logo">
        <a href="">{{config('app.name')}}<b>Valledupar</b></a>
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
                <!-- /.col -->
                <div class="col-md-12">
                    <button type="submit" class="btn btn-danger btn-raised btn-block btn-flat"> Ingresar</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
@endsection
