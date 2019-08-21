@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Usuarios
    <small>Grupos de Usuarios ó Roles </small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('inicio')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('admin.usuarios')}}"><i class="fa fa-users"></i> Usuarios</a></li>
    <li><a href="{{route('grupousuario.index')}}"><i class="fa fa-user"></i> Grupos de Usuarios</a></li>
    <li class="active"><a> Crear</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="alert alert-warning">
            <p class="h4"><strong>Agregue nuevos grupos,</strong> Los grupos de usuarios son los roles o agrupaciones de usuarios que permite asignarle privilegios a todo un conglomerado de usuarios que comparte funciones. Ejemplo de grupos de usuarios: ADMINISTRADOR, TÉCNICO, CENTRAL, MENSAJERO, ETC.
            </p>
        </div>
    </div>
</div>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Datos del Grupo de Usuario</h3>
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
            @component('layouts.errors')
            @endcomponent
        </div>
        <div class="col-md-12">
            {!! Form::open(['route'=>'grupousuario.store','method'=>'POST','role'=>'form'])!!}
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" class="form-control" placeholder="Escriba el nombre del grupo o rol de usuario" name="nombre" required="required" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Descripción</label>
                    <input type="text" class="form-control" placeholder="Descripción del grupo (Opcional)" name="descripcion"/>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Seleccione los Módulos a los que el Grupo Tendrá Acceso</label>
                    <select class="form-control show-tick select2" name="modulos[]" placeholder="Seleccione los Módulos a los que el Grupo Tendrá Acceso" required="" multiple="">
                        @foreach($modulos as $key=>$value)
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12" style="margin-top: 20px !important">
                    <button class="btn btn-success icon-btn pull-right" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                    <button class="btn btn-info icon-btn pull-right" type="reset"><i class="fa fa-fw fa-lg fa-trash-o"></i>Limpiar</button>
                    <a class="btn btn-danger icon-btn pull-right" href="{{route('grupousuario.index')}}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $('.select2').select2();
    $(function () {
        $('#example1').DataTable();
    });
</script>
@endsection