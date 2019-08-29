@extends('layouts.admin')
@section('style')
    <style>

        .boton{
            color: #FFFFFF !important;
            font-weight: bold;
            border: 1px solid gray;
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
    Mantenimiento
    <small>Menú de Mantenimiento</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('inicio')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li class="active"><a><i class="fa fa-wrench"></i> Mantenimiento</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Menú Mantenimiento</h3>
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
            @if(session()->exists('PAG_MANTENIMIENTO-REPUESTO'))
            <a class="btn btn-app btn-lg bg-purple-gradient boton" href="{{route('repuesto.index')}}" style="color: #66639E; font-weight: bold">
                <i class="fa fa-cogs"></i> REPUESTOS
                <div class="ripple-container"></div></a>
            @endif
            @if(session()->exists('PAG_MANTENIMIENTO-MANTENIMIENTOS'))
            <a class="btn btn-app btn-lg bg-purple-gradient boton " href="{{route('mantenimiento.index')}}"  style="color: #66639E; font-weight: bold">
                <i class="fa fa-list-ul"></i> >MANTENIMIENTOS
                <div class="ripple-container"></div></a>
            @endif
            @if(session()->exists('PAG_MANTENIMIENTO-FACTURAR-MANTENIMIENTO'))
            <a class="btn btn-app btn-lg bg-purple-gradient boton " href="{{route('mantenimiento.create')}}"  style="color: #66639E; font-weight: bold">
                <i class="fa fa-check-square-o"></i>FACTURAR MANTENIMIENTO
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

