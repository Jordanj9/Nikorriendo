@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Usuarios
    <small>Grupos de Usuarios o Roles</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('admin.usuarios')}}"><i class="fa fa-home"></i> Usuarios</a></li>
    <li class="active"><a><i class="fa fa-users"></i> Grupos de Usuarios</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="alert alert-warning">
            <p class="h4"><strong>Detalles: </strong>Los grupos de usuarios son los roles o agrupaciones de usuarios que permite asignarle privilegios a todo un conglomerado de usuarios que comparte funciones. Ejemplo de grupos de usuarios: ADMINISTRADOR, FELIGRES, ESCUELA SABATICA, MAYORDOMIA, MINISTERIO JUVENIL, ETC.
            </p>
        </div>
    </div>
</div>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Listado de Grupos de Usuarios o Roles</h3>
        <div class="box-tools pull-right">
            <a href="{{route('grupousuario.create')}}" type="button" class="btn btn-box-tool" data-toggle="tooltip"
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
                        <th>GRUPO</th>
                        <th>DESCRIPCIÓN</th>
                        <th>CREADO</th>
                        <th>MODIFICADO</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($grupos as $grupo)
                    <tr>
                        <td>{{$grupo->id}}</td>
                        <td>{{$grupo->nombre}}</td>
                        <td>{{$grupo->descripcion}}</td>
                        <td>{{$grupo->created_at}}</td>
                        <td>{{$grupo->updated_at}}</td>
                        <td>
                            <a href="{{ route('grupousuario.edit',$grupo->id)}}" style="color: green; margin-left: 10px;" data-toggle="tooltip" data-placement="top" title="Editar Grupo de Usuario"><i class="fa fa-edit"></i></a>
                            <a href="{{ route('grupousuario.show',$grupo->id)}}" style="color: green; margin-left: 10px;" data-toggle="tooltip" data-placement="top" title="Ver Datos del Grupo de Usuario"><i class="fa fa-eye"></i></a>
                            <a href="{{ route('grupousuario.delete',$grupo->id)}}" style="color: red; margin-left: 10px;" data-toggle="tooltip" data-placement="top" title="Eliminar Grupo de Usuario"><i class="fa fa-remove"></i></a>
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
        $('#example1').DataTable();
    });
    function ir(id) {
        $("#id").val(id);
    }
</script>
@endsection