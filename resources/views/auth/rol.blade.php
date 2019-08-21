@extends('layouts.app')

@section('content')
<div class="login-box">
    <div class="login-logo">
        <img src="{{asset('images/logo.png')}}" alt="logo" width="200" height="250">
    </div>
    <div class="login-box-body">
        <form class="form-horizontal" method="POST" action="{{ route('rol') }}">
            {{ csrf_field() }}
            <div class="input-group" style="margin: 0 auto;">
                <div class="form-line">
                    {!! Form::select('grupo',$grupos,null,['class'=>'form-control show-tick','placeholder'=>'-- Seleccione Rol Para Continuar --','required']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <button class="btn btn-block bg-orange-active" type="submit">CONTIUAR</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection