@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Servicios
    <small>Permisos</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('inicio')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('admin.servicio')}}"><i class="fa fa-indent"></i> Servicios</a></li>
    <li class="active"><a><i class="fa fa-pencil-square-o"></i> Permisos</a></li>
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
        <h3 class="box-title">Listado de Permisos</h3>
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
                        <th>TIPO</th>
                        <th>RESPONSABLE</th>
                        <th>PERMISO A</th>
                        <th>TELEFONO</th>
                        <th>CLIENTE</th>
                        <th>DIRECCIÓN</th>
                        <th>FECHA DE ENTREGA</th>
                        <th>FECHA FIN</th>
                        <th>FECHA RECOGIDA</th>
                        <th>ESTADO SERVICIO</th>
                        <th>CREACIÓN</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($permisos as $p)
                    <tr>
                        <td>{{$p->tipo}}</td>
                        <td>@if($p->tipo == "SERVICIO")
                            {{$p->servicio->persona->primer_nombre." ".$p->servicio->persona->primer_apellido}}
                            @else
                            {{$p->solicitudcambio->servicio->persona->primer_nombre." ".$p->solicitudcambio->servicio->persona->primer_apellido}}
                            @endif
                        </td>
                        <td>{{$p->persona->primer_nombre." ".$p->persona->primer_apellido}}</td>
                        @if($p->tipo == "SERVICIO")
                        <td>{{$p->servicio->cliente->telefono}}</td>
                        <td>{{$p->servicio->cliente->nombre}}</td>
                        <td>{{$p->servicio->direccion}}</td>
                        <td>{{$p->servicio->fechaentrega == null ? 'SIN ENTREGAR' : $p->servicio->fechaentrega }}</td>
                        <td>{{$p->servicio->fechafin == null ? 'SIN CALCULAR' : $p->servicio->fechafin }}</td>
                        <td>{{$p->servicio->fecharecogido == null ? 'SIN RECOGER' : $p->servicio->fecharecogido  }}</td>
                        <td>@if($p->servicio->estado == 'PENDIENTE')
                            <label class="label label-warning">{{$p->servicio->estado}}</label>
                            @elseif($p->servicio->estado == 'ASIGNADA')
                            <label class="label label-info">{{$p->servicio->estado}}</label>
                            @elseif($p->servicio->estado == 'RECOGER')
                            <label class="label label-danger">{{$p->servicio->estado}}</label>
                            @elseif($p->servicio->estado == 'ENTREGADA')
                            <label class="label label-primary">{{$p->servicio->estado}}</label>
                            @elseif($p->servicio->estado == 'CANCELADO')
                            <label class="label label-inverse">{{$p->servicio->estado}}</label>
                            @elseif($p->servicio->estado == 'CAMBIO')
                            <label class="label label-default">{{$p->servicio->estado}}</label>
                            @else
                            <label class="label label-success">{{$p->servicio->estado}}</label>
                            @endif
                        </td>
                        @else
                        <td>{{$p->solicitudcambio->servicio->cliente->telefono}}</td>
                        <td>{{$p->solicitudcambio->servicio->cliente->nombre}}</td>
                        <td>{{$p->solicitudcambio->servicio->direccion}}</td>
                        <td>{{$p->solicitudcambio->servicio->fechaentrega == null ? 'SIN ENTREGAR' : $p->solicitudcambio->servicio->fechaentrega }}</td>
                        <td>{{$p->solicitudcambio->servicio->fechafin == null ? 'SIN CALCULAR' : $p->solicitudcambio->servicio->fechafin }}</td>
                        <td>{{$p->solicitudcambio->servicio->fecharecogido == null ? 'SIN RECOGER' : $p->solicitudcambio->servicio->fecharecogido  }}</td>
                        <td>@if($p->solicitudcambio->servicio->estado == 'PENDIENTE')
                            <label class="label label-warning">{{$p->solicitudcambio->servicio->estado}}</label>
                            @elseif($p->solicitudcambio->servicio->estado == 'ASIGNADA')
                            <label class="label label-info">{{$p->solicitudcambioservicio->estado}}</label>
                            @elseif($p->solicitudcambio->servicio->estado == 'RECOGER')
                            <label class="label label-danger">{{$p->solicitudcambio->servicio->estado}}</label>
                            @elseif($p->solicitudcambio->servicio->estado == 'ENTREGADA')
                            <label class="label label-primary">{{$p->solicitudcambio->servicio->estado}}</label>
                            @elseif($p->solicitudcambio->servicio->estado == 'CANCELADO')
                            <label class="label label-inverse">{{$p->solicitudcambio->servicio->estado}}</label>
                            @elseif($p->solicitudcambio->servicio->estado == 'CAMBIO')
                            <label class="label label-default">{{$p->solicitudcambio->servicio->estado}}</label>
                            @else
                            <label class="label label-success">{{$p->solicitudcambio->servicio->estado}}</label>
                            @endif
                        </td>
                        @endif
                        <td>{{$p->created_at}}</td>
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
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Generar Solicitud de Cambio</h4>
            </div>
            <div class="modal-body">
                <div class="outer_div">
                    {!! Form::open(['route'=>'solicitud.store','method'=>'POST','role'=>'form','class'=>''])!!}
                    <input type="hidden" name="servicio_id" id="servicio_id"/>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Observación</label>
                            <input type="text" class="form-control"
                                   placeholder="Observación acerca del motivo del cambio" name="observacion"/>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Cantidad</label>
                            <input type="number" class="form-control" placeholder="Numero de lavadora a cambiar"
                                   name="num_lavadora"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12" style="margin-top: 20px !important">
                            <button class="btn btn-success icon-btn pull-right" type="submit"><i
                                    class="fa fa-fw fa-lg fa-save"></i>Guardar
                            </button>
                            <button class="btn btn-info icon-btn pull-right" type="reset"><i
                                    class="fa fa-fw fa-lg fa-trash-o"></i>Limpiar
                            </button>
                            <a class="btn btn-danger icon-btn pull-right" data-dismiss="modal"><i
                                    class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
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
<script src="{{asset('js/axios.min.js')}}"></script>
<script type="text/javascript">
                                $(function () {
                                $('#example1').DataTable({
                                responsive: true
                                });
                                });
                                function cambio(event, id) {
                                $("#servicio_id").val(id);
                                event.preventDefault();
                                $('#myModal').modal('show');
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
                                        confirmButtonText: 'Si, Cancelarlo!',
                                        cancelButtonText: 'cancelar'
                                }).then((result) => {
                                if (result.value) {
                                let url = 'servicio/' + id;
                                axios.delete(url).then(result => {
                                let data = result.data;
                                if (data.status == 'ok') {
                                Swal.fire(
                                        'Canccelado!',
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
