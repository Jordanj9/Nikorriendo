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
        <h3 class="box-title">Listado de </br> Solicitudes</h3>
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
                        <th>DIRECCIÓN</th>
                        <th>CLIENTE</th>
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
                        <td>{{$s->servicio->direccion}}</td>
                        <td>{{$s->servicio->cliente->nombre}}</td>
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
                            <a href="{{route('servicio.show',$s->servicio_id)}}" data-toggle="tooltip"
                               data-placement="top" title="Detalle del Servicio"
                               style="color: deepskyblue; margin-left: 10px;"><i class="fa fa-eye"></i></a>
                            @if($s->estado == 'PENDIENTE')
                            <a href="{{route('solicitud.entregarCambio',$s->id)}}" data-toggle="tooltip"
                               data-placement="top" title="Entregar Cambio"
                               style="color: orangered; margin-left: 10px;"><i class="fa  fa-dropbox"></i></a>
                            @endif
                            @if(session('ROL') == 'ADMINISTRADOR')
                            <a data-toggle="tooltip" data-placement="top" title="Dar Permiso"
                               onclick="cambio(event,'{{$s->id}}')"
                               style="color: deeppink; margin-left: 10px;"><i class="fa fa-eye"></i></a>
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
                <h4 class="modal-title" id="myModalLabel">Generar Permiso</h4>
            </div>
            <div class="modal-body">
                <div class="outer_div">
                    {!! Form::open(['route'=>'permiso.store','method'=>'POST','role'=>'form','class'=>''])!!}
                    <input type="hidden" name="solicitudcambio_id" id="solicitudcambio_id"/>
                    <input type="hidden" name="tipo" id="tipo" value="CAMBIO"/>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Seleccione Mensajero</label>
                            {!! Form::select('persona_id',$personas,null,['class'=>'form-control','placeholder'=>'Seleccione el Empleado','id'=>'persona_id']) !!}
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

                                   function cambio(event, id) {
                                   $("#solicitudcambio_id").val(id);
                                   event.preventDefault();
                                   $('#myModal').modal('show');
                                   }

</script>
@endsection
