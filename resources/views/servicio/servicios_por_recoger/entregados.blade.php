@extends('layouts.admin')

@section('breadcrumb')
<h1>
    Servicio
    <small>Solicitudes de Servicios</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('inicio')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('admin.servicio')}}"><i class="fa fa-indent"></i> Servicios</a></li>
    <li class="active"><a><i class="fa fa-caret-square-o-down"></i> Entregados</a></li>
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
        <h3 class="box-title">Listado de </br> Servicios</h3>
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
                        <td>{{$servicio->direccion}}</td>
                        <td>{{$servicio->cliente->nombre}}</td>
                        <td>{{$servicio->num_lavadoras}}</td>
                        <td>{{$servicio->dias}}</td>
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
                        <td>{!!$servicio->tiempo!!}</td>
                        <td>{{$servicio->persona->primer_nombre.' '.$servicio->persona->primer_apellido}}</td>
                        <td>{{$servicio->created_at}}</td>
                        <td>{{$servicio->updated_at}}</td>
                        <td style="text-align: center;">
                            <a href="{{route('servicio.show',$servicio->id)}}" data-toggle="tooltip"
                               data-placement="top" title="Detalle del Servicio"
                               style="color: deepskyblue; margin-left: 10px;"><i class="fa fa-eye"></i></a>
                            <a href="{{route('servicio.recogerServicio',$servicio->id)}}" data-toggle="tooltip"
                               data-placement="top" title="Recoger Servicio"
                               style="color: orangered; margin-left: 10px;"><i class="fa  fa-dropbox"></i></a>
                            @if(session('ROL') == 'ADMINISTRADOR')
                            <a data-toggle="tooltip" data-placement="top" title="Dar Permiso"
                               onclick="cambio(event,'{{$servicio->id}}')"
                               style="color: deeppink; margin-left: 10px;"><i class="fa fa-exclamation-circle"></i></a>
                            @endif
                            <a href="{{route('servicio.edit',$servicio->id)}}" data-toggle="tooltip"
                               data-placement="top" title="Otro Dia"
                               style="color: blue; margin-left: 10px;"><i class="fa fa-plus-circle"></i></a>
                            <a href="" data-toggle="tooltip" onclick="observacion(event,'{{$servicio->id}}')"
                               data-placement="top" title="Observación del Servicio"
                               style="color:  #00a157; margin-left: 10px;"><i class="fa fa-file-text"></i></a>
                        </td>
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
                    <input type="hidden" name="servicio_id" id="servicio_id"/>
                    <input type="hidden" name="tipo" id="tipo" value="SERVICIO"/>
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

<!-- modal -->
<div class="modal fade" id="modal_observacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Agregar Observación</h4>
            </div>
            <div class="modal-body">
                <div class="outer_div">
                    {!! Form::open(['route'=>'servicio.observacion','method'=>'POST','role'=>'form','class'=>''])!!}
                    <input type="hidden" name="servicio_id" id="servicio_id_observacion"/>
                    <div class="col-md-12">
                        <div class="form-group">
                            <textarea name="observacion" id="observacion" cols="30" rows="5" class="form-control" placeholder="Agregue una nueva observación al servicio"></textarea>
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
<script src="//cdn.datatables.net/plug-ins/1.10.11/sorting/date-eu.js" type="text/javascript"></script>
<script type="text/javascript">

                                $(function () {
                                $('#example1').DataTable({
                                responsive: true,
                                        "order": [[ 8, "desc" ]], //or asc 
                                        "columnDefs" : [{"targets":8, "type":"date-es"}],
                                        "pageLength":25,
                                });
                                $('.select2').select2();
                                });
                                function cambio(event, id) {
                                $("#servicio_id").val(id);
                                event.preventDefault();
                                $('#myModal').modal('show');
                                }

                                function ir(id) {
                                $("#id").val(id);
                                }

                                function observacion(event, id){
                                $('#servicio_id_observacion').val(id);
                                event.preventDefault();
                                $('#modal_observacion').modal('show');
                                }
</script>
@endsection
