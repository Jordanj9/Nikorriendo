@extends('layouts.admin')
@section('breadcrumb')
    <h1>
        Estructura
        <small>Empleados de la Empresa</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="{{route('admin.estructura')}}"><i class="fa fa-home"></i> Estructura</a></li>
        <li class="active"><a><i class="fa fa-users"></i> Empleados</a></li>
    </ol>
@endsection
@section('content')
    <div class="row clearfix">
        <div class="col-md-12">
            <div class="alert alert-warning">
                <p class="h4"><strong>Detalles: </strong> gestiona la información de cada una de los empleados de la empresa.
                </p>
            </div>
        </div>
    </div>
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Listado de Empleados</h3>
            <div class="box-tools pull-right">
                <a href="{{route('persona.create')}}" type="button" class="btn btn-box-tool" data-toggle="tooltip"
                   title="Nuevo Empleado">
                    <i class="fa fa-plus-circle"></i></a>
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
                        <th>IDENTIFICACIÓN</th>
                        <th>NOMBRE</th>
                        <th>SEXO</th>
                        <th>DIRECCION</th>
                        <th>CORREO</th>
                        <th>TELEFONO</th>
                        <th>ESTADO</th>
                        <th>CREADO</th>
                        <th>MODIFICADO</th>
                        <th>ACCIONES</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($empleados as $empleado)
                        <tr>
                            <td>{{$empleado->identificacion}}</td>
                            <td>{{$empleado->nombre}}</td>
                            <td>{{$empleado->sexo}}</td>
                            <td>{{$empleado->direccion}}</td>
                            <td>{{$empleado->email}}</td>
                            <td>{{$empleado->telefono}}</td>
                            <td>{{$empleado->estado}}</td>
                            <td>{{$empleado->created_at}}</td>
                            <td>{{$empleado->updated_at}}</td>
                            <td style="text-align: center;">
                                <a href="{{ route('persona.edit',$empleado->id)}}" data-toggle="tooltip" data-placement="top" title="Editar empleado" style="color: green; margin-left: 10px;"><i class="fa fa-edit"></i></a>
                                <a href="#" onclick="eliminar(event,{{$empleado->id}})" data-toggle="tooltip" data-placement="top" title="Eliminar empleado" style="color: red; margin-left: 10px;"><i class="fa fa-trash-o"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script type="text/javascript">
        $(function () {
            $('#example1').DataTable();
        });
        function ir(id) {
            $("#id").val(id);
        }
        function eliminar(event,id){
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
                    let url = 'persona/'+id;
                    axios.delete(url).then(result => {
                       let data = result.data;
                        if(data.status == 'ok'){
                            Swal.fire(
                                'Eliminado!',
                                 data.message,
                                'success'
                            ).then(result => {
                                location.reload();
                            });
                        }else{
                            Swal.fire(
                                'Error!',
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
