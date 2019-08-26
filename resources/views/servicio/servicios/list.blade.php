@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Servicios
    <small>Solicitudes de Servicios</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('inicio')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('admin.servicio')}}"><i class="fa fa-indent"></i> Servicios</a></li>
    <li class="active"><a><i class="fa fa-pencil-square-o"></i> Solicitudes</a></li>
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
                @if(session('ROL')=='CENTRAL' || session('ROL')=='ADMINISTRADOR')
                    <a href="{{route('servicio.create')}}" type="button" class="btn btn-box-tool" data-toggle="tooltip"
                       title="Nuevo Servicio">
                        <i class="fa fa-plus-circle"></i></a>
                @endif
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
                        <th>FECHA DE ENTREGA</th>
                        <th>FECHA FIN</th>
                        <th>FECHA RECOGIDA</th>
                        <th>ESTADO</th>
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
                            <td>{{$servicio->fechaentrega == null ? 'SIN ENTREGAR' : $servicio->fechaentrega }}</td>
                            <td>{{$servicio->fechafin == null ? 'SIN CALCULAR' : $servicio->fechafin }}</td>
                            <td>{{$servicio->fecharecogido == null ? 'SIN RECOGER' : $servicio->fecharecogido  }}</td>
                            <td>@if($servicio->estado == 'PENDIENTE')
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
                            <td>{{$servicio->created_at}}</td>
                            <td>{{$servicio->updated_at}}</td>
                            <td style="text-align: center;">
                                <a href="{{route('servicio.show',$servicio->id)}}" data-toggle="tooltip"
                                   data-placement="top" title="Detalle del Servicio"
                                   style="color: deepskyblue; margin-left: 10px;"><i class="fa fa-eye"></i></a>
                                @if(session('ROL') == 'CENTRAL' || session('ROL') == 'ADMINISTRADOR')
                                <a data-toggle="tooltip" data-placement="top" title="Solicitud de Cambio"
                                   onclick="cambio(event,'{{$servicio->id}}')"
                                   style="color: deeppink; margin-left: 10px;"><i class="fa fa-exclamation-circle"></i></a>
                                @endif
                                @if(session('ROL') == 'CENTRAL' || session('ROL') == 'ADMINISTRADOR')
                                    <a href="#" onclick="eliminar(event,'{{$servicio->id}}')" data-toggle="tooltip"
                                       data-placement="top" title="Cancelar Servicio"
                                       style="color: red; margin-left: 10px;"><i
                                            class="fa  fa-calendar-times-o"></i></a>
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
