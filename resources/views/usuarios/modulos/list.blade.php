@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Usuarios
    <small>Modulos del Sistema</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('admin.usuarios')}}"><i class="fa fa-home"></i> Usuarios</a></li>
    <li class="active"><a><i class="fa fa-users"></i> Modulos</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="alert alert-warning">
            <p class="h4"><strong>Detalles: </strong>Los módulos generales del sistema son las aplicaciones generales representadas en las opciones del menú. Ejemplo de módulo general: MOD_INICIO, MOD_USUARIOS.
                <br/><strong>Nota: </strong> No modifique los nombres de los módulos ya creados ya que puede ocasionar fallas en el sistema.
            </p>
        </div>
    </div>
</div>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Listado de Modulos</h3>
        <div class="box-tools pull-right">
            <a href="{{route('modulo.create')}}" type="button" class="btn btn-box-tool" data-toggle="tooltip"
               title="Nuevo Modulo">
                <i class="fa fa-plus-circle"></i></a>
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Minimizar">
                <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Cerrar">
                <i class="fa fa-times"></i></button>
        </div>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table id="example1" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr class="danger">
                        <th>ID</th>
                        <th>MÓDULO</th>
                        <th>DESCRIPCIÓN</th>
                        <th>CREADO</th>
                        <th>MODIFICADO</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($modulos as $modulo)
                    <tr>
                        <td>{{$modulo->id}}</td>
                        <td>{{$modulo->nombre}}</td>
                        <td>{{$modulo->descripcion}}</td>
                        <td>{{$modulo->created_at}}</td>
                        <td>{{$modulo->updated_at}}</td>
                        <td style="text-align: center;">
                            <a href="{{ route('modulo.edit',$modulo->id)}}" data-toggle="tooltip" data-placement="top" title="Editar Módulo" style="color: green; margin-left: 10px;"><i class="fa fa-edit"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $(function () {
        $('#example1').DataTable({
            responsive:true
        });
    });
    function ir(id) {
        $("#id").val(id);
    }
</script>
@endsection
