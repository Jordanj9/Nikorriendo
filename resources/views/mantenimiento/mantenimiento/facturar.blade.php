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
                        <td class="contact" colspan="2" ><center><b>TECNICO</b></center></td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>DATOS</b></td>
                        <td class="subject">{{$persona->identificacion.' => '.$persona->primer_nombre.'  '.$persona->primer_apellido}}</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Sucursal</b></td>
                        <td class="subject">{{$persona->identificacion.' => '.$persona->primer_nombre.'  '.$persona->primer_apellido}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="form-group">
                <div class="col-md-12" style="margin-top: 20px !important">
                    <button class="btn btn-success icon-btn pull-right" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                    <button class="btn btn-info icon-btn pull-right" type="reset"><i class="fa fa-fw fa-lg fa-trash-o"></i>Limpiar</button>
                    <a class="btn btn-danger icon-btn pull-right" href="{{route('repuesto.index')}}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                </div>
            </div>
            {!! Form::close() !!}
            <div class="clearfix"></div>
            <div id="resultados" class="col-md-12" style="margin-top:10px"><table class="table">
                    <tbody><tr>
                        <th class="text-center">CODIGO</th>
                        <th class="text-center">CANT.</th>
                        <th>DESCRIPCION</th>
                        <th class="text-right">PRECIO UNIT.</th>
                        <th class="text-right">PRECIO TOTAL</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td class="text-center">999910</td>
                        <td class="text-center">1</td>
                        <td>Test motherboard</td>
                        <td class="text-right">150.00</td>
                        <td class="text-right">150.00</td>
                        <td class="text-center"><a href="#" onclick="eliminar('25224')"><i class="glyphicon glyphicon-trash"></i></a></td>
                    </tr>
                    <tr>
                        <td class="text-right" colspan="4">SUBTOTAL $</td>
                        <td class="text-right">150.00</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="text-right" colspan="4">IVA (13)% $</td>
                        <td class="text-right">19.50</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="text-right" colspan="4">TOTAL $</td>
                        <td class="text-right">169.50</td>
                        <td></td>
                    </tr>

                    </tbody></table>
            </div><!-- Carga los datos ajax -->
            <br><br>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(function () {
            $('#example1').DataTable();
        });
    </script>
@endsection

