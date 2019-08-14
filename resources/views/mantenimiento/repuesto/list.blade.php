@extends('layouts.admin')
@section('breadcrumb')
    <h1>
        Mantenimiento
        <small>Gestion de los Mantenimientos</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="{{route('admin.mantenimiento')}}"><i class="fa fa-home"></i> Mantenimiento</a></li>
        <li class="active"><a><i class="fa fa-users"></i> Repuestos</a></li>
    </ol>
@endsection
@section('content')
    <div class="row clearfix">
        <div class="col-md-12">
            <div class="alert alert-warning">
                <p class="h4"><strong>Detalles: </strong> gestiona la información de cada una de los repuestos de las lavadoras.
                </p>
            </div>
        </div>
    </div>
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Listado de repuestos</h3>
            <div class="box-tools pull-right">
                <a href="{{route('repuesto.create')}}" type="button" class="btn btn-box-tool" data-toggle="tooltip"
                   title="Nuevo repuesto">
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
                        <th>ID</th>
                        <th>NOMBRE</th>
                        <th>DESCRIPCIÓN</th>
                        <th>PRECIO</th>
                        <th>STOCK</th>
                        <th>BODEGA</th>
                        <th>CREADO</th>
                        <th>MODIFICADO</th>
                        <th>ACCIONES</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($repuestos as $repuesto)
                        <tr>
                            <td>{{$repuesto->id}}</td>
                            <td>{{$repuesto->nombre}}</td>
                            <td>{{$repuesto->descripcion}}</td>
                            <td>${{$repuesto->precio}}</td>
                            <td>{{$repuesto->stock}}</td>
                            <td>{{$repuesto->bodega->nombre}}</td>
                            <td>{{$repuesto->created_at}}</td>
                            <td>{{$repuesto->updated_at}}</td>
                            <td style="text-align: center;">
                                <a href="{{ route('repuesto.edit',$repuesto->id)}}" data-toggle="tooltip" data-placement="top" title="Editar repuesto" style="color: green; margin-left: 10px;"><i class="fa fa-edit"></i></a>
                                <a href="#" onclick="eliminar(event,{{$repuesto->id}})" data-toggle="tooltip" data-placement="top" title="Eliminar repuesto" style="color: red; margin-left: 10px;"><i class="fa fa-trash-o"></i></a>
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
                    let url = 'repuesto/'+id;
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

