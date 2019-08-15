@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Servicio
    <small>Solicitudes de Servicios</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('admin.servicio')}}"><i class="fa fa-home"></i> Servicios</a></li>
    <li class="active"><a><i class="fa fa-users"></i> Solicitudes</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="alert alert-warning">
            <p class="h4"><strong>Detalles: </strong> Gestiona la información de los servicios realizados.
            </p>
        </div>
    </div>
</div>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Listado de Servicios</h3>
        <div class="box-tools pull-right">
            <a href="{{route('servicio.create')}}" type="button" class="btn btn-box-tool" data-toggle="tooltip"
               title="Nuevo Servicio">
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
                        <th>CLIENTE</th>
                        <th>DIRECCIÓN</th>
                        <th>FECHA DE ENTREGA</th>
                        <th>FECHA FIN</th>
                        <th>FECHA RECOGIDA</th>
                        <th>ESTADO</th>
                        <th>MENSAJERO</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($servicios as $servicio)
                    <tr>
                        <td>{{$servico->cliente->nombre}}</td>
                        <td>{{$servicio->direccion}}</td>
                        <td>{{$servicio->fechaentrega}}</td>
                        <td>{{$servicio->fechafin}}</td>
                        <td>{{$servicio->fecharecogido}}</td>
                        <td>@if($servicio->estado == 'PENDIENTE')
                            <label class="label label-warning">{{$servicio->estado}}</label>
                            @elseif($servico->estado == 'ASIGNADA')
                            <label class="label label-info">{{$servicio->estado}}</label>
                            @elseif($servico->estado == 'RECOGER')
                            <label class="label label-danger">{{$servicio->estado}}</label>
                            @elseif($servico->estado == 'ENTREGADA')
                            <label class="label label-primary">{{$servicio->estado}}</label>
                            @else
                            <label class="label label-success">{{$servicio->estado}}</label>
                            @endif
                        </td>
                        <td>{{$servicio->persona->primer_nombre." ".$servicio->persona->segundo." ".$servicio->persona->primer_apellido." ".$servicio->segundo_apellido}}</td>
                        <td style="text-align: center;">
                            <a href="{{ route('servicio.show',$servico->id)}}" data-toggle="tooltip" data-placement="top" title="Editar Servico" style="color: green; margin-left: 10px;"><i class="fa fa-edit"></i></a>
                            <a href="#" onclick="eliminar(event,{{$bodega->id}})" data-toggle="tooltip" data-placement="top" title="Eliminar Servico" style="color: red; margin-left: 10px;"><i class="fa fa-trash-o"></i></a>
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
                                $('#example1').DataTable();
                                });
                                function ir(id) {
                                $("#id").val(id);
                                }

                                function eliminar(event, id){
                                event.preventDefault();
                                Swal.fire({
                                title: 'Estas seguro(a)?',
                                        text: "no podras revertilo!",
                                        type: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Si, eliminarlo!',
                                        cancelButtonText:'cancelar'
                                }).then((result) => {
                                if (result.value) {
                                let url = 'bodega/' + id;
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
                                } else if (data.status == 'warning'){
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
