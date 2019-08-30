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
    Servicio
    <small>Menú de Servicio</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('inicio')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li class="active"><a><i class="fa fa-indent"></i> Servicios</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Menú Servicio</h3>
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
            @if(session()->exists('PAG_SERVICIO-SERVICIOS'))
            <a class="btn btn-app btn-lg bg-red-gradient boton" href="{{route('servicio.index')}}">
                <i class="fa fa-list"></i> SERVICIOS
                <div class="ripple-container"></div>
            </a>
            @endif
            @if(session()->exists('PAG_SERVICIO-SOLICITUD-SERVICIO'))
            <a class="btn btn-app btn-lg bg-red-gradient boton" href="{{route('servicio.getServiciosPendientes')}}">
                <i class="fa fa-list-ol"></i> SOLICITUDES DE SERVICIO
                <div class="ripple-container"></div>
            </a>
            @endif
            @if(session()->exists('PAG_SERVICIO-CAMBIOS'))
            <a class="btn btn-app btn-lg bg-red-gradient boton" href="{{route('solicitud.index')}}">
                <i class="fa fa-refresh"></i> SOLICITUDES DE CAMBIOS
                <div class="ripple-container"></div>
            </a>
            @endif
            @if(session()->exists('PAG_SERVICIO-ENTREGAR'))
            <a class="btn btn-app btn-lg bg-red-gradient  boton" href="{{route('servicio.getServiciosPorEntregar')}}">
                <i class="fa fa-sign-in"></i> SERVICIOS POR ENTREGAR
                <div class="ripple-container"></div>
            </a>
            @endif
            @if(session()->exists('PAG_SERVICIO-RECOGER'))
            <a class="btn btn-app btn-lg  bg-red-gradient boton" href="{{route('servicio.getServiciosPorRecoger')}}">
                <i class="fa fa-motorcycle"></i> SERVICIOS POR RECOGER
                <div class="ripple-container"></div>
            </a>
            @endif
            <a class="btn btn-app btn-lg btn-block boton" href="{{route('permiso.index')}}">
                <i class="fa fa-cogs"></i> PERMISOS
                <div class="ripple-container"></div>
            </a>
            @if(session()->exists('PAG_SERVICIO-GEOLOCALIZACION'))
            <a class="btn btn-app btn-lg  bg-red-gradient boton" href="{{route('servicio.showServicios')}}">
                <i class="fa fa-map-marker"></i> GEOLOCALIZACIÓN
                <div class="ripple-container"></div>
            </a>
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
</script>
@endsection

