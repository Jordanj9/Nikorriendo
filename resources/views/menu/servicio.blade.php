@extends('layouts.admin')
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
            <a href="{{route('servicio.index')}}" class="btn bg-red-gradient margin">
                <div>
                    <span style="color: white">SERVICIOS</span>
                    <span class="ink animated"></span>
                </div>
            </a>
            @endif
            @if(session()->exists('PAG_SERVICIO-SOLICITUD-SERVICIO'))
            <a href="{{route('servicio.getServiciosPendientes')}}" class="btn bg-red-gradient margin">
                <div>
                    <span style="color: white">SOLICITUDES DE SERVICIO</span>
                    <span class="ink animated"></span>
                </div>
            </a>
            @endif
            @if(session()->exists('PAG_SERVICIO-CAMBIOS'))
            <a href="{{route('servicio.getServiciosPendientes')}}" class="btn bg-red-gradient margin">
                <div>
                    <span style="color: white">SOLICITUDES DE CAMBIOS</span>
                    <span class="ink animated"></span>
                </div>
            </a>
            @endif
            @if(session()->exists('PAG_SERVICIO-ENTREGAR'))
            <a href="{{route('servicio.getServiciosPorEntregar')}}" class="btn bg-red-gradient margin">
                <div>
                    <span style="color: white">SERVICIOS POR ENTREGAR</span>
                    <span class="ink animated"></span>
                </div>
            </a>
            @endif
            @if(session()->exists('PAG_SERVICIO-RECOGER'))
            <a href="{{route('mantenimiento.create')}}" class="btn bg-red-gradient margin">
                <div>
                    <span style="color: white">SERVICIOS POR RECOGER</span>
                    <span class="ink animated"></span>
                </div>
            </a>
            @endif
            @if(session()->exists('PAG_SERVICIO-GEOLOCALIZACION'))
            <a href="{{route('mantenimiento.create')}}" class="btn bg-red-gradient margin">
                <div>
                    <span style="color: white">GEOLOCALIZACIÓN</span>
                    <span class="ink animated"></span>
                </div>
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

