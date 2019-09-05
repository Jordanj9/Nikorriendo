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
            @if(session('ROL') == 'ADMINISTRADOR')
            <a type="button" class="btn btn-box-tool" data-toggle="tooltip"
               title="Nuevo Mantenimiento" onclick="crear(event)">
                <i class="fa fa-plus-circle"></i></a>
            @endif
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
                            @if($m->estado == 'PENDIENTE' && session('ROL') == 'ADMINISTRADOR')
                            <a href="#" onclick="eliminar(event,{{$m->id}})" data-toggle="tooltip" data-placement="top" title="Eliminar Mantenimiento" style="color: red; margin-left: 10px;"><i class="fa fa-trash-o"></i></a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Generar Mantenimiento</h4>
            </div>
            <div class="modal-body">
                <div class="outer_div">
                    {!! Form::open(['route'=>'mantenimiento.store2','method'=>'POST','role'=>'form','class'=>''])!!}
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Seleccione la Lavadora</label>
                            {!! Form::select('lavadora_id',$lavadoras,null,['class'=>'form-control','placeholder'=>'Seleccione el Empleado','id'=>'persona_id','required'=>'true']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12" style="margin-top: 20px !important">
                            <button class="btn btn-success icon-btn pull-right" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                            <button class="btn btn-info icon-btn pull-right" type="reset"><i class="fa fa-fw fa-lg fa-trash-o"></i>Limpiar</button>
                            <a class="btn btn-danger icon-btn pull-right" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="modal-footer">
            </div>
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
                                function crear(event) {
                                event.preventDefault();
                                $('#myModal').modal('show');
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
                                let url = 'mantenimiento/' + id;
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
