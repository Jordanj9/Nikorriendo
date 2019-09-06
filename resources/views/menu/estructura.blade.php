@extends('layouts.admin')
@section('style')
    <style>

        .boton{
            color: #FFFFFF !important;
            font-weight: bold;
            border-radius: 20px;
        }

        @media (max-width:468px){

            .boton{
                width: 100%;
            }

        }

    </style>
@endsection
@section('breadcrumb')
<h1>
    General
    <small>Menú General </small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('inicio')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li class="active"><a><i class="fa fa-gear"></i> General</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Menú General</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Minimizar">
                <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Cerrar">
                <i class="fa fa-times"></i></button>
        </div>
    </div>
    <div class="box-body">
        <div class="button-demo">
            @if(session()->exists('PAG_ESTRUCTURA-SUCURSAL'))
                <a class="btn btn-app btn-lg bg-yellow-gradient boton" href="{{route('sucursal.index')}}" style="font-weight: bold">
                    <i class="fa fa-sitemap"></i> SUCURSALES
                    <div class="ripple-container"></div></a>
            @endif
            @if(session()->exists('PAG_ESTRUCTURA-BODEGA'))
                    <a class="btn btn-app btn-lg bg-yellow-gradient boton" href="{{route('bodega.index')}}" style="font-weight: bold">
                        <i class="fa fa-archive"></i> BODEGAS
                        <div class="ripple-container"></div></a>
            @endif
            @if(session()->exists('PAG_ESTRUCTURA-LAVADORA'))
                    <a class="btn btn-app btn-lg bg-yellow-gradient boton" href="{{route('lavadora.index')}}" style="font-weight: bold">
                        <i class="fa fa-camera-retro"></i> LAVADORAS
                        <div class="ripple-container"></div></a>
            @endif
            @if(session()->exists('PAG_ESTRUCTURA-EMPLEADO'))
                    <a class="btn btn-app btn-lg bg-yellow-gradient boton" href="{{route('persona.index')}}" style="font-weight: bold">
                        <i class="fa fa-users"></i> EMPLEADOS
                        <div class="ripple-container"></div></a>
            @endif
            @if(session()->exists('PAG_ESTRUCTURA-ASIGNAR-LAVADORA'))
                    <a class="btn btn-app btn-lg bg-yellow-gradient boton" href="{{route('lavadora_persona.index')}}" style="font-weight: bold">
                        <i class="fa fa-exchange"></i>ASIGNAR LAVADORA A EMPLEADO
                        <div class="ripple-container"></div></a>
            @endif
            @if(session()->exists('PAG_ESTRUCTURA-SUCURSAL'))
                    <a class="btn btn-app btn-lg bg-yellow-gradient boton" href="{{route('barrio.index')}}" style="font-weight: bold">
                        <i class="fa fa-map-marker"></i>BARRIOS
                        <div class="ripple-container"></div></a>
            @endif
                @if(session()->exists('PAG_ESTRUCTURA-CLIENTE'))
                    <a class="btn btn-app btn-lg bg-yellow-gradient boton" href="{{route('cliente.index')}}" style="font-weight: bold">
                        <i class="fa fa-camera-retro"></i> CLIENTES
                        <div class="ripple-container"></div></a>
                @endif
        </div>
    </div>
</div>
<!--<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">MODIFICACIÓN Y ELIMINACIÓN DE USUARIOS</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Minimizar">
                <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Cerrar">
                <i class="fa fa-times"></i></button>
        </div>
    </div>
    <div class="box-body">
    <div class="col-md-12">
            <div class="body">
                <div class="row clearfix">
                    <form class="form-horizontal" method="POST" action="{{route('usuario.operaciones')}}" name="form-privilegios" id="form-privilegios">
                        @csrf
                        <div class="col-md-12">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="id" class="form-control" placeholder="Escriba la identificación a consultar" name="id"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <button type="submit" class="btn bg-orange-active waves-effect btn-block">CONSULTAR USUARIO</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
    </div>
</div>
</div>-->
<!-- /.modal -->
@endsection
@section('script')
<script type="text/javascript">
    $(function () {
        $('#example1').DataTable();
    });
    function ir(id) {
        $("#id").val(id);
    }
</script>
@endsection
