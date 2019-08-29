@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Mantenimiento
    <small>Mantenimientos</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('inicio')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('admin.mantenimiento')}}"><i class="fa fa-gear"></i> Mantenimietno</a></li>
    <li class="active"><a><i class="fa fa-map-marker"></i> Mantenimientos</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="alert alert-warning">
            <p class="h4"><strong>Detalles: </strong> gestiona la información de los mantenimientos realizados.
            </p>
        </div>
    </div>
</div>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Listado de Mantenimientos</h3>
        <div class="box-tools pull-right">
            <a href="{{route('mantenimiento.create')}}" type="button" class="btn btn-box-tool" data-toggle="tooltip"
               title="Nuevo Mantenimiento">
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
                        <th>LAVADORA</th>
                        <th>TECNICO</th>
                        <th>ESTADO MANTENIMIENTO</th>
                        <th>REPUESTOS</th>
                        <th>TOTAL</th>
                        <th>CREADO</th>
                        <th>MODIFICADO</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mantenimientos as $m)
                    <tr>
                        <td>{{$m->estado_mantenimiento->lavadora->serial."-".$m->estado_mantenimiento->lavadora->marca}}</td>
                        <td>{{$m->persona->primer_nombre." ".$m->persona->primer_apellido}}</td>                       
                        <td>{{$m->estado_mantenimiento->estado}}</td>                       
                        <td>
                            <ul>
                                @foreach($m->repuestos as $r)
                                <li>{{$r->nombre." - PRECIO:$".$r->pivot->precio}}</li>
                                @endforeach
                            </ul>
                        </td>                       
                        <td>{{$m->total}}</td>
                        <td>{{$m->created_at}}</td>
                        <td>{{$m->updated_at}}</td>
                        <td style="text-align: center;">
                            <a href="{{ route('barrio.edit',$m->id)}}" data-toggle="tooltip" data-placement="top" title="Editar Barrio" style="color: green; margin-left: 10px;"><i class="fa fa-edit"></i></a>
                            <a href="#" onclick="eliminar(event,{{$m->id}})" data-toggle="tooltip" data-placement="top" title="Eliminar Barrio" style="color: red; margin-left: 10px;"><i class="fa fa-trash-o"></i></a>
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
                                responsive:true
                                });
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
                                })

                                }
</script>
@endsection
