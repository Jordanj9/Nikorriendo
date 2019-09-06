@extends('layouts.admin')
@section('breadcrumb')
<h1>
    General
    <small>Clientes </small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('inicio')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('admin.estructura')}}"><i class="fa fa-gear"></i> General</a></li>
    <li class="active"><a><i class="fa fa-archive"></i> Clientes</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="alert alert-warning">
            <p class="h4"><strong>Detalles: </strong> gestiona la información de cada una de los clientes de la empresa.
            </p>
        </div>
    </div>
</div>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Listado de </br> Clientes</h3>
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
                        <th>TELEFONO</th>
                        <th>NOMBRE</th>
                        <th>DIRECCION</th>
                        <th>BARRIO</th>
                        <th>CREADO</th>
                        <th>MODIFICADO</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clientes as $cliente)
                    <tr>
                        <td>{{$cliente->telefono}}</td>
                        <td>{{$cliente->nombre}}</td>
                        <td>{{$cliente->direccion}}</td>
                        <td>{{$cliente->barrio->nombre}}</td>
                        <td>{{$cliente->created_at}}</td>
                        <td>{{$cliente->updated_at}}</td>
                        <td style="text-align: center;">
                            <a href="{{ route('cliente.edit',$cliente->id)}}" data-toggle="tooltip" data-placement="top" title="Editar Cliente" style="color: green; margin-left: 10px;"><i class="fa fa-edit"></i></a>
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
</script>
@endsection
