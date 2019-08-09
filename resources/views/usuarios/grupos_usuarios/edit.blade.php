@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Usuarios
    <small>Grupos de Usuarios o Roles</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('admin.usuarios')}}"><i class="fa fa-users"></i> Usuarios</a></li>
    <li><a href="{{route('grupousuario.index')}}"><i class="fa fa-users"></i> Grupos de Usuarios</a></li>
    <li class="active"><a> Editar</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="alert alert-warning">
            <p class="h4"><strong>Edite los datos de los grupos,</strong> Los grupos de usuarios son los roles o agrupaciones de usuarios que permite asignarle privilegios a todo un conglomerado de usuarios que comparte funciones. Ejemplo de grupos de usuarios: ADMINISTRADOR, FELIGRES, ESCUELA SABATICA, MAYORDOMIA, MINISTERIO JUVENIL, ETC.
            </p>
        </div>
    </div>
</div>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Editar Grupo de Usuario o Rol</h3>
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
            {!! Form::open(['route'=>['grupousuario.update',$grupo->id],'method'=>'PUT','role'=>'form',])!!}     
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" class="form-control" placeholder="Escriba el nombre del grupo o rol de usuario" name="nombre" required="required" value="{{$grupo->nombre}}" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Descripción</label>
                    <input type="text" class="form-control" placeholder="Descripción del grupo (Opcional)" name="descripcion"value="{{$grupo->descripcion}}" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Seleccione los Módulos a los que el Grupo Tendrá Acceso</label>
                    <select class="form-control show-tick select2" name="modulos[]" placeholder="Seleccione los Módulos a los que el Grupo Tendrá Acceso" required="" multiple="">
                        @foreach($modulos as $key=>$value)
                        <?php
                        $existe = false;
                        ?>
                        @foreach($grupo->modulos as $m)
                        @if($m->id==$key)
                        <?php
                        $existe = true;
                        ?>
                        @endif
                        @endforeach
                        @if($existe)
                        <option value="{{$key}}" selected>{{$value}}</option>
                        @else
                        <option value="{{$key}}">{{$value}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
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
        </form>
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