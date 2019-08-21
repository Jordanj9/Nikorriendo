@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Usuarios
    <small>Grupos de Usuarios ó Roles</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('inicio')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('admin.usuarios')}}"><i class="fa fa-users"></i> Usuarios</a></li>
    <li><a href="{{route('grupousuario.index')}}"><i class="fa fa-user"></i> Grupos de Usuarios</a></li>
    <li class="active"><a>Ver</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Datos del Grupo Seleccionado</h3>
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
        <div class="col-md-12">
            @component('layouts.errors')
            @endcomponent
        </div>
        <div class="row clearfix">
            <div class="col-md-12">
                <table class="table table-hover">
                    <tbody>
                        <tr class="read">
                            <td class="contact"><b>Id del Grupo</b></td>
                            <td class="subject">{{$grupo->id}}</td>
                        </tr>
                        <tr class="read">
                            <td class="contact"><b>Nombre</b></td>
                            <td class="subject">{{$grupo->nombre}}</td>
                        </tr>
                        <tr class="read">
                            <td class="contact"><b>Descripción</b></td>
                            <td class="subject">{{$grupo->descripcion}}</td>
                        </tr>
                        <tr class="read">
                            <td class="contact"><b>Cantidad de Usuarios en el Grupo</b></td>
                            <td class="subject">{{$total}}</td>
                        </tr>
                        <tr class="read">
                            <td class="contact"><b>Creado</b></td>
                            <td class="subject">{{$grupo->created_at}}</td>
                        </tr>
                        <tr class="read">
                            <td class="contact"><b>Modificado</b></td>
                            <td class="subject">{{$grupo->updated_at}}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="list-group">
                    <a class="list-group-item active">
                        MÓDULOS A LOS QUE TIENE ACCESO EL GRUPO DE USUARIOS 
                    </a>
                    @foreach($grupo->modulos as $modulo)
                    <span class="list-group-item">{{$modulo->nombre}} ==> {{$modulo->descripcion}}</span>
                    @endforeach
                </div>
            </div>
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