@extends('layouts.admin')
@section('breadcrumb')
    <h1>
        Bienvenido
        <small>Sr(a). {{Auth::user()->nombres}}</small>
    </h1>
    <ol class="breadcrumb">
        <li class="active"><a href="{{route('inicio')}}"><i class="fa fa-home"></i> Inicio</a></li>
    </ol>
@endsection
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Inicio</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                        title="Minimizar">
                    <i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                        title="Cerrar">
                    <i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">
            @if(session()->exists('MOD_INICIO'))
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-green-gradient"><i class="fa fa-home"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Inicio</span>
                            <a href="{{route('inicio')}}" class="info-box-number">Inicio</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
            @endif
            @if(session()->exists('MOD_USUARIOS'))
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua-gradient"><i class="fa fa-users"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Gestión De</span>
                            <a href="{{route('admin.usuarios')}}" class="info-box-number">Usuarios</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
            @endif
            @if(session()->exists('MOD_ESTRUCTURA'))
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-yellow-gradient"><i class="fa fa-gear"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Gestión De</span>
                            <a href="{{route('admin.estructura')}}" class="info-box-number">General</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
            @endif
            @if(session()->exists('MOD_SERVICIO'))
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-red-gradient"><i class="fa fa-indent"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Gestión De</span>
                            <a href="{{route('admin.servicio')}}" class="info-box-number">Servicios</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
            @endif
            @if(session()->exists('MOD_MANTENIMIENTO'))
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-purple-gradient"><i class="fa fa-wrench"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Gestión De</span>
                            <a href="{{route('admin.mantenimiento')}}" class="info-box-number">Mantenimientos</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
            @endif
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-danger"><i class="fa fa-sign-out"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Adiós</span>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form3').submit();" class="info-box-number">
                            Salir</a>
                        <form id="logout-form3" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
        </div>
    </div>
@endsection
