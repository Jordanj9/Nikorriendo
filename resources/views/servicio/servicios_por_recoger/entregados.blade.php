@extends('layouts.admin')

@section('breadcrumb')
    <h1>
        Servicio
        <small>Solicitudes de Servicios</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('inicio')}}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="{{route('admin.servicio')}}"><i class="fa fa-home"></i> Servicios</a></li>
        <li class="active"><a><i class="fa fa-users"></i> Entregados</a></li>
    </ol>
@endsection
@section('content')
    <div class="row clearfix">
        <div class="col-md-12">
            <div class="alert alert-warning">
                <p class="h4"><strong>Detalles: </strong> Acepta los servicios que se te faciliten y que estés dispuesto
                    a realizar.
                </p>
            </div>
        </div>
    </div>
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Listado de Servicios por Recoger</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                        title="Minimizar">
                    <i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                        title="Cerrar">
                    <i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr class="danger">
                        <th>TELEFONO</th>
                        <th>CLIENTE</th>
                        <th>DIRECCIÓN</th>
                        <th>#LAVADORAS</th>
                        <th>#DIAS</th>
                        <th>ESTADO</th>
                        <th>TIEMPO EXCEDIDO</th>
                        <th>MENSAJERO</th>
                        <th>CREACIÓN</th>
                        <th>ACTUALIZADO</th>
                        <th>ACCIONES</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($servicios as $servicio)
                        <tr>
                            <td>{{$servicio->cliente->telefono}}</td>
                            <td>{{$servicio->cliente->nombre}}</td>
                            <td>{{$servicio->direccion}}</td>
                            <td>{{$servicio->num_lavadoras}}</td>
                            <td>{{$servicio->dias}}</td>
                            <td>
                                @if($servicio->estado == 'PENDIENTE')
                                    <label class="label label-warning">{{$servicio->estado}}</label>
                                @elseif($servicio->estado == 'ASIGNADA')
                                    <label class="label label-info">{{$servicio->estado}}</label>
                                @elseif($servicio->estado == 'RECOGER')
                                    <label class="label label-danger">{{$servicio->estado}}</label>
                                @elseif($servicio->estado == 'ENTREGADA')
                                    <label class="label label-primary">{{$servicio->estado}}</label>
                                @elseif($servicio->estado == 'CANCELADO')
                                    <label class="label label-inverse">{{$servicio->estado}}</label>
                                @else
                                    <label class="label label-success">{{$servicio->estado}}</label>
                                @endif
                            </td>
                            <th>{{$servicio->tiempo}}</th>
                            <td>{{$servicio->persona->primer_nombre.' '.$servicio->persona->primer_apellido}}</td>
                            <td>{{$servicio->created_at}}</td>
                            <td>{{$servicio->updated_at}}</td>
                            <td style="text-align: center;">
                                <a href="{{route('servicio.aceptarServicio',$servicio->id)}}" data-toggle="tooltip"
                                   data-placement="top" title="Liberar Servicio"
                                   style="color: orangered; margin-left: 10px;"><i class="fa  fa-times-circle"></i></a>
                                <a href="{{route('servicio.recogerServicio',$servicio->id)}}" data-toggle="tooltip"
                                   data-placement="top" title="Entregar Servicio"
                                   style="color: deepskyblue; margin-left: 10px;"><i class="fa  fa-dropbox"></i></a>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script type="text/javascript">

        $(function () {
            $('#example1').DataTable({
                responsive: true
            });
            $('.select2').select2();
        });

        function ir(id) {
            $("#id").val(id);
        }

        function eliminar(event, id) {
            event.preventDefault();
            Swal.fire({
                title: 'Estas seguro(a)?',
                text: "no podras revertilo!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminarlo!',
                cancelButtonText: 'cancelar'
            }).then((result) => {
                if (result.value) {
                    let url = 'servicio/' + id;
                    axios.delete(url).then(result => {
                        let data = result.data;
                        if (data.status == 'ok') {
                            Swal.fire(
                                'Eliminado!',
                                data.message,
                                'success'
                            ).then(result => {
                                location.reload();
                            });
                        } else if (data.status == 'warning') {
                            Swal.fire(
                                'Atención',
                                data.message,
                                'warning'
                            ).then(result => {
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                'error',
                                data.message,
                                'danger'
                            ).then(result => {
                                location.reload();
                            });
                        }
                    });
                }
            });
        }

    </script>
@endsection
