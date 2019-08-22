@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Usuarios
    <small>Menu de Usuarios</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('inicio')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li class="active"><a><i class="fa fa-users"></i> Usuarios</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Menu Usuarios</h3>
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
            @if(session()->exists('PAG_MODULOS'))
            <a href="{{route('modulo.index')}}" class="btn bg-aqua margin">
                <div>
                    <span>MÓDULOS DEL SISTEMA</span>
                    <span class="ink animated"></span>
                </div>
            </a>
            @endif
            @if(session()->exists('PAG_PAGINAS'))
            <a href="{{route('pagina.index')}}" class="btn bg-aqua margin">
                <div>
                    <span>PÁGINAS DEL SISTEMA</span>
                    <span class="ink animated"></span>
                </div>
            </a>
            @endif
            @if(session()->exists('PAG_GRUPO-ROLES'))
            <a href="{{route('grupousuario.index')}}" class="btn bg-aqua margin">
                <div>
                    <span>GRUPOS O ROLES DE USUARIOS</span>
                    <span class="ink animated"></span>
                </div>
            </a>
            @endif
            @if(session()->exists('PAG_PRIVILEGIOS'))
            <a href="{{route('grupousuario.privilegios')}}" class="btn bg-aqua margin">
                <div>
                    <span>PRIVILÉGIOS A PÁGINAS</span>
                    <span class="ink animated"></span>
                </div>
            </a>
            @endif
            @if(session()->exists('PAG_USUARIOS'))
            <a href="{{route('usuario.index')}}" class="btn bg-aqua margin">
                <div>
                    <span>LISTAR TODOS LOS USUARIOS</span>
                    <span class="ink animated"></span>
                </div>
            </a>
            @endif
            @if(session()->exists('PAG_USUARIO-MANUAL'))
            <a href="{{route('usuario.create')}}" class="btn bg-aqua margin">
                <div>
                    <span>USUARIO MANUAL</span>
                    <span class="ink animated"></span>
                </div>
            </a>
            @endif
        </div>
    </div>
</div>
@if(session()->exists('PAG_OPERACIONES-USUARIO'))
<div class="box">
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
</div>
@endif
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Cambiar Contraseña</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['route'=>'usuario.operaciones','method'=>'POST','class'=>'form-horizontal'])!!}
                <input type="hidden" name="id" id="id"/>
                <div class="form-group">
                    <div class="col-md-2">
                        <label class="col-md-2 control-label">Nueva Contraseña</label>
                    </div>
                    <div class="col-md-10">
                        <input class="form-control" type="password" required="required" name="password">
                    </div>
                    <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Cerrar</button>
                    <button class="btn btn-success icon-btn pull-right" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Cambiar</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
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
