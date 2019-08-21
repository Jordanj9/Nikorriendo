@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Usuarios
    <small>Páginas del Sistema </small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('inicio')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('admin.usuarios')}}"><i class="fa fa-home"></i> Usuarios</a></li>
    <li class="active"><a><i class="fa fa-file-powerpoint-o"></i> Páginas del Sistemas</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="alert alert-warning">
            <p class="h4"><strong>Detalles:</strong> Las páginas o ítems de los módulos del sistema son las funcionalidades más específicas o detalladas de los módulos. Ejemplo de página general: PAG_MODULOS, PAG_PAGINAS, PAG_USUARIOS, PAG_PRIVILEGIOS, ETC.
                <br/><strong>Nota: </strong> No modifique los nombres de las páginas ya creadas ya que puede ocasionar fallas en el sistema.
            </p>
        </div>
    </div>
</div>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Listado de Páginas</h3>
        <div class="box-tools pull-right">
            <a href="{{route('pagina.create')}}" type="button" class="btn btn-box-tool" data-toggle="tooltip"
               title="Nueva Página">
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
                        <th>PÁGINA</th>
                        <th>DESCRIPCIÓN</th>
                        <th>CREADO</th>
                        <th>MODIFICADO</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paginas as $pagina)
                    <tr>
                        <td>{{$pagina->id}}</td>
                        <td>{{$pagina->nombre}}</td>
                        <td>{{$pagina->descripcion}}</td>
                        <td>{{$pagina->created_at}}</td>
                        <td>{{$pagina->updated_at}}</td>
                        <td style="text-align: center;">
                            <a href="{{ route('pagina.edit',$pagina->id)}}" data-toggle="tooltip" data-placement="top" title="Editar Página" style="color: green; margin-left: 10px;"><i class="fa fa-edit"></i></a>
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
<script type="text/javascript">
    $(function () {
        $('#example1').DataTable({
            responsive:true
        });
    });
    function ir(id) {
        $("#id").val(id);
    }
</script>
@endsection
