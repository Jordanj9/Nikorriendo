@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Usuarios
    <small>Listar Usuarios</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li class="active"><a><i class="fa fa-users"></i> Usuarios</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Listado de Usuarios</h3>
        <div class="box-tools pull-right">
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
                        <th>Identificación</th>
                        <th>Usuario</th>
                        <th>E-mail</th>
                        <th>Estado</th>
                        <th>Roles</th>
                        <th>Creado</th>
                        <th>Modificado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios as $usuario)
                    <tr>
                        <td>{{$usuario->identificacion}}</td>
                        <td>{{$usuario->nombres}} {{$usuario->apellidos}}</td>
                        <td>{{$usuario->email}}</td>
                        <td>@if($usuario->estado=='ACTIVO')<label class="label label-success">ACTIVO</label>@else<label class="label label-danger">INACTIVO</label>@endif</td>
                        <td>
                            @foreach($usuario->grupousuarios as $grupo)
                            {{$grupo->nombre}} - 
                            @endforeach
                        </td>
                        <td>{{$usuario->created_at}}</td>
                        <td>{{$usuario->updated_at}}</td>
                        <td>{!! Form::open(['route'=>'usuario.operaciones','method'=>'POST','class'=>'form-horizontal form-label-left'])!!}<input type="hidden" name="id" value="{{$usuario->identificacion}}" /><button class="btn btn-success" style="color: green; margin-left: 10px;" type="submit" data-toggle="tooltip" data-placement="top" title="Editar Usuario"><i class="fa fa-edit"></i></button>{!! Form::close() !!}</td>  
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Cambiar Contraseña</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['route'=>'usuario.cambiarPass','method'=>'POST','class'=>'form-horizontal'])!!}
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