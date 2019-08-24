@extends('layouts.admin')
@section('breadcrumb')
    <h1>
        Servicios
        <small>Empleados de la empresa</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('inicio')}}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="{{route('admin.servicio')}}"><i class="fa fa-gear"></i>Servicios</a></li>
        <li><a href="{{route('servicio.index')}}"><i class="fa fa-users"></i> Solicitudes</a></li>
        <li class="active"><a> Ver</a></li>
    </ol>
@endsection
@section('content')
    <div class="row clearfix">
        <div class="col-md-12">
            <div class="alert alert-warning">
                <p class="h4"><strong>Datos del servicio, </strong> detalle de cada uno de los sevicios.
                </p>
            </div>
        </div>
    </div>
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Datos del servicio</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                        title="Minimizar">
                    <i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Cerrar">
                    <i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">
            <div class="col-md-12">
                @component('layouts.errors')
                @endcomponent
            </div>
            <div class="row clearfix">
                <div class="col-md-12">
                    <table class="table table-hover">
                        <tbody>
                        <tr class="read">
                            <td class="contact bg-green" colspan="2" ><center><b>Información del Cliente</b></center></td>
                        </tr>
                        <tr class="read">
                            <td class="contact"><b>Telefono</b></td>
                            <td class="subject">{{$servicio->cliente->telefono}}</td>
                        </tr>
                        <tr class="read">
                            <td class="contact"><b>Nombre</b></td>
                            <td class="subject">{{$servicio->cliente->nombre}}</td>
                        </tr>
                        <tr class="read">
                            <td class="contact"><b>Dirección</b></td>
                            <td class="subject">{{$servicio->cliente->direccion}}</td>
                        </tr>
                        <tr class="read">
                            <td class="contact"><b>Barrio</b></td>
                            <td class="subject">{{$servicio->cliente->barrio->nombre}}</td>
                        </tr>
                        <tr class="read">
                            <td class="contact bg-green" colspan="2" ><center><b>Información del Servicio</b></center></td>
                        </tr>
                        <tr class="read">
                            <td class="contact"><b>Numero de Lavadoras</b></td>
                            <td class="subject">{{$servicio->num_lavadoras}}</td>
                        </tr>
                        <tr class="read">
                            <td class="contact"><b>Numero de Dias</b></td>
                            <td class="subject">{{$servicio->dias}}</td>
                        </tr>
                        <tr class="read">
                            <td class="contact"><b>Dirrección</b></td>
                            <td class="subject">{{$servicio->direccion}}</td>
                        </tr>
                        <tr class="read">
                            <td class="contact"><b>Barrio</b></td>
                            <td class="subject">{{$servicio->barrio->nombre}}</td>
                        </tr>
                        <tr class="read">
                            <td class="contact"><b>Estado</b></td>
                            @if($servicio->estado == 'PENDIENTE')
                                <td class="subject bg-orange">{{$servicio->estado}}</td>
                            @elseif($servicio->estado == 'ASIGNADA')
                                <td class="subject bg-info">{{$servicio->estado}}</td>
                            @elseif($servicio->estado == 'RECOGER')
                                <td class="subject bg-danger">{{$servicio->estado}}</td>
                            @elseif($servicio->estado == 'ENTREGADA')
                                <td class="subject bg-primary">{{$servicio->estado}}</td>
                            @elseif($servicio->estado == 'CANCELADO')
                                <td class="subject bg-purple-gradient">{{$servicio->estado}}</td>
                            @else
                                <td class="subject bg-success">{{$servicio->estado}}</td>
                            @endif
                        </tr>

                        @if($servicio->persona_id != null)
                            <tr class="read">
                                <td class="contact bg-green" colspan="2" ><center><b>Información del Mensajero Encargado del Servicio</b></center></td>
                            </tr>
                            <tr class="read">
                                <td class="contact"><b>Nombre</b></td>
                                <td class="subject">{{$servicio->persona->primer_nombre}} {{$servicio->persona->primer_apellido}}</td>
                            </tr>
                            <tr class="read">
                                <td class="contact"><b>Telefono</b></td>
                                <td class="subject">{{$servicio->persona->telefono}}</td>
                            </tr>
                        @endif

                        @if($servicio->estado == 'ENTREGADO' || $servicio->estado == 'RECOGER' || $servicio->estado == 'FINALIZADO' )

                            <tr class="read">
                                <td class="contact bg-green" colspan="2" ><center><b>Datos de Entrega del servicio</b></center></td>
                            </tr>

                            <tr class="read">
                                <td class="contact"><b>Fecha de Entrega</b></td>
                                <td class="subject">{{$servicio->fechaentrega}}</td>
                            </tr>

                            <tr class="read">
                                <td class="contact"><b>Fecha Final de Servicio</b></td>
                                <td class="subject">{{$servicio->fechafin}}</td>
                            </tr>


                            <tr class="read">
                                <td class="contact bg-green" colspan="2" ><center><b>Firma del Cliente</b></center></td>
                            </tr>

                            <tr class="read">
                                <td class="contact bg-white" colspan="2">
                                        <img src="{{ url('/') . '/docs/firma_entregas/'.$servicio->firma_recibido_cliente}}" alt="firma del cliente" width="150" height="150">
                                </td>
                            </tr>

                        @endif

                        @if($servicio->lavadoras->count() > 0)

                            <tr class="read">
                                <td class="contact bg-green" colspan="2" ><center><b>Lavadora(s) Entregada(s) en el Servicio</b></center></td>
                            </tr>

                                @foreach($servicio->lavadoras as $lavadora)
                                    <tr class="read">
                                        <td  colspan="2" class="contact">{{$lavadora->serial.' - '.$lavadora->marca.' -BODEGA:'.$lavadora->bodega->nombre.' -SUCURSAL:'.$lavadora->bodega->sucursal->nombre}}</td>
                                    </tr>
                                @endforeach

                        @endif

                        @if($servicio->estado == 'FINALIZADO')

                            <tr class="read">
                                <td class="contact bg-green" colspan="2" ><center><b>Datos de Finalización del servicio</b></center></td>
                            </tr>

                            <tr class="read">
                                <td class="contact"><b>Fecha de Recogida</b></td>
                                <td class="subject">{{$servicio->fecharecogido}}</td>
                            </tr>

                            <tr class="read">
                                <td class="contact bg-green" colspan="2" ><center><b>Firma del Cliente</b></center></td>
                            </tr>

                            <tr class="read">
                                <td class="contact bg-white" colspan="2">
                                    <img src="{{ url('/') . '/docs/firma_recogidas/'.$servicio->firma_entrega_cliente}}" alt="firma del cliente" width="150" height="150">
                                </td>
                            </tr>

                        @endif

                        </tbody>
                    </table>
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

