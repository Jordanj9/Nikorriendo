@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Estructura
    <small>Menú de Estructura</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li class="active"><a><i class="fa fa-users"></i> Estructura</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Menú Estructura</h3>
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
            <a href="{{route('modulo.index')}}" class="btn bg-yellow-gradient margin">
                <div>
                    <span style="color: white">SUCURSALES</span>
                    <span class="ink animated"></span>
                </div>
            </a>
            @endif
            @if(session()->exists('PAG_ESTRUCTURA-BODEGA'))
            <a href="{{route('pagina.index')}}" class="btn bg-yellow-gradient margin">
                <div>
                    <span style="color: white">BODEGAS</span>
                    <span class="ink animated"></span>
                </div>
            </a> 
            @endif
            @if(session()->exists('PAG_ESTRUCTURA-LAVADORA'))
            <a href="{{route('grupousuario.index')}}" class="btn bg-yellow-gradient margin">
                <div>
                    <span style="color: white">LAVADORAS</span>
                    <span class="ink animated"></span>
                </div>
            </a>
            @endif
            @if(session()->exists('PAG_ESTRUCTURA-EMPLEADO'))
            <a href="{{route('grupousuario.privilegios')}}" class="btn bg-yellow-gradient margin">
                <div>
                    <span style="color: white">EMPLEADOS</span>
                    <span class="ink animated"></span>
                </div>
            </a>
            @endif
            @if(session()->exists('PAG_ESTRUCTURA-ASIGNAR-LAVADORA'))
            <a href="{{route('usuario.create')}}" class="btn bg-yellow-gradient margin">
                <div>
                    <span style="color: white">ASIGNAR LAVADORA A EMPLEADO</span>
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
    function ir(id) {
        $("#id").val(id);
    }
</script>
@endsection