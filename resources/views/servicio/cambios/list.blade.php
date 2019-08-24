@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Servicio
    <small>Solicitudes de Cambios</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('inicio')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('admin.servicio')}}"><i class="fa fa-gear"></i> Servicio</a></li>
    <li class="active"><a><i class="fa fa-map-marker"></i> Solicitudes de Cambios</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="alert alert-warning">
            <p class="h4"><strong>Detalles: </strong> gestiona la informacion de las solicitudes de cambios
            </p>
        </div>
    </div>
</div>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Listado de Solicitudes</h3>
        <div class="box-tools pull-right">
            <a href="{{route('barrio.create')}}" type="button" class="btn btn-box-tool" data-toggle="tooltip"
               title="Nuevo Barrio">
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
                        <th>TELEFONO</th>
                        <th>CLIENTE</th>
                        <th>DIRECCIÓN</th>
                        <th>#LAVADORAS</th>
                        <th>#DIAS</th>
                        <th>TIEMPO PENDIENTE</th>
                        <th>OBSERVACIÓN</th>
                        <th>ESTADO</th>
                        <th>MENSAJERO</th>
                        <th>CREACIÓN</th>
                        <th>ACTUALIZADO</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($solicitudes as $s)
                    <tr>
                        <td>{{$s->servicio->cliente->telefono}}</td>
                        <td>{{$s->servicio->cliente->nombre}}</td>
                        <td>{{$s->servicio->direccion}}</td>
                        <td>{{$s->servicio->num_lavadoras}}</td>
                        <td>{{$s->servicio->dias}}</td>
                        <td>{{$s->tiempopendiente}}</td>
                        <td>{{$s->observacion}}</td>
                        <td>@if($s->estado == 'PENDIENTE')
                            <label class="label label-warning">{{$s->estado}}</label>
                            @else
                            <label class="label label-success">{{$s->estado}}</label>
                            @endif
                        </td>
                        <td>{{$s->servicio->persona->primer_nombre.' '.$s->servicio->persona->primer_apellido}}</td>
                        <td>{{$s->created_at}}</td>
                        <td>{{$s->updated_at}}</td>
                        <td style="text-align: center;">
                            <a href="{{route('servicio.show',$s->id)}}" data-toggle="tooltip"
                               data-placement="top" title="Detalle del Servicio"
                               style="color: deepskyblue; margin-left: 10px;"><i class="fa fa-eye"></i></a>
                            <a href="{{route('servicio.show',$s->id)}}" data-toggle="tooltip"
                               data-placement="top" title="Ubicación del Servicio"
                               style="color: deepskyblue; margin-left: 10px;"><i class="fa  fa-map-marker"></i></a>
                            <a href="{{route('servicio.liberarServicio',$s->id)}}" data-toggle="tooltip"
                               data-placement="top" title="Liberar Servicio"
                               style="color: orangered; margin-left: 10px;"><i class="fa  fa-times-circle"></i></a>
                            <a href="{{route('servicio.entregarServicio',$s->id)}}" data-toggle="tooltip"
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
            let url = 'barrio/' + id;
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
    })

}
</script>
@endsection
