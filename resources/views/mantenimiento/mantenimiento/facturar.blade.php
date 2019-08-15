@extends('layouts.admin')
@section('breadcrumb')
    <h1>
        Mantenimiento
        <small>Facturar</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="{{route('admin.mantenimiento')}}"><i class="fa fa-users"></i> Mantenimiento</a></li>
        <li class="active"><a> Crear</a></li>
    </ol>
@endsection
@section('content')
    <div class="row clearfix">
        <div class="col-md-12">
            <div class="alert alert-warning">
                <p class="h4"><strong>Agregue nuevos Repuestos,</strong> gestiona la información de cada una de los reuestos de las lavadoras de la empresa.
                </p>
            </div>
        </div>
    </div>

    <div class="panel panel-info">
        <div class="panel-heading">
            <h4><i class="glyphicon glyphicon-edit"></i> Nueva Factura</h4>
        </div>
        <div class="panel-body">
            {!! Form::open(['route'=>'repuesto.store','method'=>'POST','role'=>'form','class'=>''])!!}

            <div class="col-md-12">

                <table class="table">
                    <tbody>
                    <tr class="read">
                        <td class="contact" colspan="2" ><center><b>TÉCNICO</b></center></td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>DATOS</b></td>
                        <td class="subject">{{$persona->identificacion.' - '.$persona->primer_nombre.'  '.$persona->primer_apellido.' - CARGO:'.$persona->tipo}}</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>SUCURSAL</b></td>
                        <td class="subject">{{$persona->sucursal->nombre}}</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>LAVADORA POR MANTENIMIENTO</b></td>
                        <td class="subject">
                           {!! Form::select('estado_mantenimiento_id',$mantenimientos,null,['class'=>'form-control chosen-select','placeholder'=>'-- Seleccione una opción --','required']) !!}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="form-group">
                <div class="col-md-12" style="margin-top: 20px !important">
                    <button class="btn btn-success icon-btn pull-right" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                    <a href="" type="button" class="btn btn-warning icon-btn pull-right" onclick="agregarRepuesto(event)"><i class="fa fa-fw fa-lg  fa-plus-square"></i>Agregar Repuesto</a>
                    <button class="btn btn-info icon-btn pull-right" type="reset"><i class="fa fa-fw fa-lg fa-trash-o"></i>Limpiar</button>
                    <a class="btn btn-danger icon-btn pull-right" href="{{route('admin.mantenimiento')}}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                </div>
            </div>

            <div class="clearfix"></div>
            <div id="resultados" class="col-md-12" style="margin-top:10px">
                <table class="table table-responsive" style="overflow-x: scroll;" id="detalle-repuesto">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th>DESCRIPCION</th>
                            <th class="text-right">PRECIO UNIT.</th>
                            <th class="text-right">PRECIO TOTAL</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div><!-- Carga los datos ajax -->
            <br><br>

            {!! Form::close() !!}
    </div>
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Buscar Repuesto</h4>
                    </div>
                    <div class="modal-body">
                        <div class="outer_div">
                            <div class="table-responsive">
                                <table class="table" id="example1">
                                    <thead class="danger">
                                        <tr class="warning">
                                            <th>ID</th>
                                            <th>Repuesto</th>
                                            <th><span class="">Precio</span></th>
                                            <th class="text-center" style="width: 36px;">Agregar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($repuestos as $repuesto)
                                        <tr>
                                            <td>{{$repuesto->id}}</td>
                                            <td>{{$repuesto->nombre}}</td>
                                            <td>${{$repuesto->precio}}</td>
                                            <td class="text-center">
                                                <a href="#" onclick="agregar(event,{
                                                    id: '{{$repuesto->id}}',
                                                    nombre:'{{$repuesto->nombre}}',
                                                    precio:'{{$repuesto->precio}}'
                                                })" data-toggle="tooltip" data-placement="top" title="Agregar Repuesto" style="color: deepskyblue; margin-left: 10px;"><i class="glyphicon glyphicon-plus"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection
@section('script')
    <script type="text/javascript">
        let detalles_repuestos = [];
        let total = 0;

        $(function () {
            $('#example1').DataTable();
        });

        function agregarRepuesto(event) {
            event.preventDefault();
            $('#myModal').modal('show');
        }

        /*let trtotal = document.createElement('tr');
        html = `<td class="text-right" colspan="3">TOTAL $</td>
                    <td class="text-right">${total}</td>
                    `;
        trtotal.innerHTML = html;
        tabla.appendChild(trtotal);*/

        function agregar(event,repuesto) {

            event.preventDefault();

            let tabla = document.querySelector('#detalle-repuesto tbody');
            let band = true;

            detalles_repuestos.forEach(x => {
               if(x.id == repuesto.id){
                  band = false;
               }
            });

            if(band){
                detalles_repuestos.push(repuesto);
                total = parseInt(total) + parseInt(repuesto.precio);
            }

            let html = '';

            detalles_repuestos.forEach( x => {
                html += `<tr>
                            <td class="text-center">${x.id}</td>
                            <td>${x.nombre}</td>
                            <td class="text-right">${x.precio}</td>
                            <td class="text-right">${x.precio}</td>
                            <td class="text-center"><a href="#" onclick="eliminar(${x.id})"><i class="glyphicon glyphicon-trash"></i></a></td>
                        </tr>
                       `;
            });

            tabla.innerHTML = html;

            let trtotal = document.createElement('tr');
            html = `<tr>
                        <td class="text-right" colspan="3">TOTAL $</td>
                        <td class="text-right">${total}</td>
                    </tr>
                    `;
            trtotal.innerHTML = html;
            tabla.appendChild(trtotal);

        }

    </script>
@endsection

