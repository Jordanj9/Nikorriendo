@extends('layouts.admin')
@section('breadcrumb')
    <h1>
        General
        <small>Empleados de la empresa</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('inicio')}}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="{{route('admin.estructura')}}"><i class="fa fa-gear"></i> general</a></li>
        <li><a href="{{route('persona.index')}}"><i class="fa fa-users"></i> Empleados</a></li>
        <li class="active"><a> Ver</a></li>
    </ol>
@endsection
@section('content')
    <div class="row clearfix">
        <div class="col-md-12">
            <div class="alert alert-warning">
                <p class="h4"><strong>Datos del empleado, </strong> gestiona la información de cada una de los empleados de la empresa.
                </p>
            </div>
        </div>
    </div>
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Datos del empleado</h3>
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
            <h1 class="card-inside-title">DATOS DEL EMPLEADO SELECCIONADO</h1>
            <div class="row clearfix">
                <div class="col-md-12">
                    <table class="table table-hover">
                        <tbody>
                        <tr class="read">
                            <td class="contact bg-green" colspan="2" ><center><b>Información del empleado</b></center></td>
                        </tr>
                        <tr class="read">
                            <td class="contact"><b>Sucursal</b></td>
                            <td class="subject">{{$persona->sucursal->nombre}}</td>
                        </tr>
                        <tr class="read">
                            <td class="contact"><b>Identificacion</b></td>
                            <td class="subject">{{$persona->identificacion}}</td>
                        </tr>
                        <tr class="read">
                            <td class="contact"><b>Nombre</b></td>
                            <td class="subject">{{$persona->primer_nombre." - ".$persona->primer_apellido}}</td>
                        </tr>
                        <tr class="read">
                            <td class="contact"><b>Tipo de Sangre</b></td>
                            <td class="subject">{{$persona->tipo_sangre}}</td>
                        </tr>
                        <tr class="read">
                            <td class="contact"><b>Sexo</b></td>
                            <td class="subject">{{$persona->sexo}}</td>
                        </tr>
                        <tr class="read">
                            <td class="contact"><b>Direccion</b></td>
                            <td class="subject">{{$persona->direccion}}</td>
                        </tr>
                        <tr class="read">
                            <td class="contact"><b>Email</b></td>
                            <td class="subject">{{$persona->email}}</td>
                        </tr>
                        <tr class="read">
                            <td class="contact"><b>Telefono</b></td>
                            <td class="subject">{{$persona->telefono}}</td>
                        </tr>
                        <tr class="read">
                            <td class="contact"><b>Estado</b></td>
                            <td class="subject">{{$persona->estado}}</td>
                        </tr>
                        <tr class="read">
                            <td class="contact"><b>Tipo</b></td>
                            <td class="subject">{{$persona->tipo}}</td>
                        </tr>
                        <tr class="read">
                            <td class="contact bg-green" colspan="2" ><center><b>Contacto de Emergencia</b></center></td>
                        </tr>
                        <tr class="read">
                            <td class="contact"><b>Nombre</b></td>
                            <td class="subject">{{$persona->contacto_emergencia->nombres}}</td>
                        </tr>
                        <tr class="read">
                            <td class="contact"><b>Parentezco</b></td>
                            <td class="subject">{{$persona->contacto_emergencia->parentezco}}</td>
                        </tr>
                        <tr class="read">
                            <td class="contact"><b>Correo</b></td>
                            <td class="subject">{{$persona->contacto_emergencia->email}}</td>
                        </tr> <tr class="read">
                            <td class="contact"><b>Direccion</b></td>
                            <td class="subject">{{$persona->contacto_emergencia->direccion}}</td>
                        </tr>
                        </tr> <tr class="read">
                            <td class="contact"><b>Telefono</b></td>
                            <td class="subject">{{$persona->contacto_emergencia->telefono}}</td>
                        </tr>
                        <tr class="read">
                            <td class="contact bg-green" colspan="2" ><center><b>Lavadoras Asignadas</b></center></td>
                        </tr>
                        @foreach($persona->lavadoras as $lavadora)
                             <tr class="read">
                                <td  colspan="2" class="contact">{{$lavadora->serial.' - '.$lavadora->marca.' -BODEGA:'.$lavadora->bodega->nombre.' -SUCURSAL:'.$lavadora->bodega->sucursal->nombre}}</td>
                            </tr>
                        @endforeach
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

