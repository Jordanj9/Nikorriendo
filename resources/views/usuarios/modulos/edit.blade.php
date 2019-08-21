@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Usuarios
    <small>Módulos del sistema </small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('inicio')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('admin.usuarios')}}"><i class="fa fa-users"></i> Usuarios</a></li>
    <li><a href="{{route('modulo.index')}}"><i class="fa fa-cubes"></i> Modulos</a></li>
    <li class="active"><a> Editar</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="alert alert-warning">
            <p class="h4"><strong>Nota: </strong> No modifique los nombres de los módulos ya creados ya que puede ocasionar fallas en el sistema. Hágalo si y solo si el desarrollador indica la necesidad de la operación. El nombre del módulo debe iniciar con "MOD_" seguido del nombre que usted desee.
            </p>
        </div>
    </div>
</div>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Editar Modulo</h3>
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
            {!! Form::open(['route'=>['modulo.update',$modulo->id],'method'=>'PUT','role'=>'form',])!!}     
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" class="form-control" placeholder="Escriba el nombre del módulo u opción de menú" name="nombre" value="{{$modulo->nombre}}" required="required" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Descripción</label>
                    <input type="text" class="form-control" placeholder="Descripción del módulo (Opcional)" name="descripcion" value="{{$modulo->descripcion}}"/>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12" style="margin-top: 20px !important">
                <button class="btn btn-success icon-btn pull-right" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                <button class="btn btn-info icon-btn pull-right" type="reset"><i class="fa fa-fw fa-lg fa-trash-o"></i>Limpiar</button>
                <a class="btn btn-danger icon-btn pull-right" href="{{route('modulo.index')}}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
            </div>
        </div>
        {!! Form::close() !!}
        </form>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $(function () {
        $('#example1').DataTable();
    });
</script>
@endsection