@extends('layouts.admin')
@section('breadcrumb')
    <h1>
        Estructura
        <small>sucursales del Sistema</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="{{route('admin.estructura')}}"><i class="fa fa-home"></i> Estructura</a></li>
        <li class="active"><a><i class="fa fa-users"></i> Sucursales</a></li>
    </ol>
@endsection
@section('content')
    <div class="row clearfix">
        <div class="col-md-12">
            <div class="alert alert-warning">
                <p class="h4"><strong>Detalles: </strong> gestiona la información de cada una de las sucursales de la empresa.
                </p>
            </div>
        </div>
    </div>
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Listado de sucursales</h3>
            <div class="box-tools pull-right">
                <a href="{{route('sucursal.create')}}" type="button" class="btn btn-box-tool" data-toggle="tooltip"
                   title="Nuevo sucursal">
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
                        <th>NOMBRE</th>
                        <th>MUNICIPIO</th>
                        <th>DEPARTAMENTO</th>
                        <th>DIRECCIONES</th>
                        <th>CREADO</th>
                        <th>MODIFICADO</th>
                        <th>ACCIONES</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($sucursales as $sucursal)
                        <tr>
                            <td>{{$sucursal->nombre}}</td>
                            <td>{{$sucursal->municipo}}</td>
                            <td>{{$sucursal->departamento}}</td>
                            <td>{{$sucursal->direccion}}</td>
                            <td>{{$sucursal->created_at}}</td>
                            <td>{{$sucursal->updated_at}}</td>
                            <td style="text-align: center;">
                                <a href="{{ route('sucursal.edit',$sucursal->id)}}" data-toggle="tooltip" data-placement="top" title="Editar Módulo" style="color: green; margin-left: 10px;"><i class="fa fa-edit"></i></a>
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
