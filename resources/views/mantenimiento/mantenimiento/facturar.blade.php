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
                           {!! Form::select('estado_mantenimiento_id',$mantenimientos,null,['class'=>'form-control','placeholder'=>'-- Seleccione una opción --','required']) !!}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="form-group">
                <div class="col-md-12" style="margin-top: 20px !important">
                    <button class="btn btn-success icon-btn pull-right" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                    <button class="btn btn-warning icon-btn pull-right"><i class="fa fa-fw fa-lg  fa-plus-square"></i>Agregar Repuesto</button>
                    <button class="btn btn-info icon-btn pull-right" type="reset"><i class="fa fa-fw fa-lg fa-trash-o"></i>Limpiar</button>
                    <a class="btn btn-danger icon-btn pull-right" href="{{route('admin.mantenimiento')}}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                </div>
            </div>

            <div class="clearfix"></div>
            <div id="resultados" class="col-md-12" style="margin-top:10px">
                <table class="table table-responsive" style="overflow-x: scroll;">
                    <tbody>
                    <tr>
                        <th class="text-center">ID</th>
                        <th>DESCRIPCION</th>
                        <th class="text-right">PRECIO UNIT.</th>
                        <th class="text-right">PRECIO TOTAL</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td class="text-center">999910</td>
                        <td>Test motherboard</td>
                        <td class="text-right">150.00</td>
                        <td class="text-right">150.00</td>
                        <td class="text-center"><a href="#" onclick="eliminar('25224')"><i class="glyphicon glyphicon-trash"></i></a></td>
                    </tr>
                    <tr>
                        <td class="text-right" colspan="3">TOTAL $</td>
                        <td class="text-right">169.50</td>
                    </tr>
                    </tbody>
                </table>
            </div><!-- Carga los datos ajax -->
            <br><br>

            {!! Form::close() !!}
    </div>

        <!-- Modal para agregar los repuestos a los tecnicos -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>


@endsection
@section('script')
    <script type="text/javascript">
        $(function () {
            $('#example1').DataTable();
        });
    </script>
@endsection

