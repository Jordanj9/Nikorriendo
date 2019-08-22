@extends('layouts.admin')
@section('breadcrumb')
    <h1>
        Mantenimiento
        <small>Repuestos </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('inicio')}}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="{{route('admin.mantenimiento')}}"><i class="fa fa-wrench"></i> Mantenimiento</a></li>
        <li><a href="{{route('repuesto.index')}}"><i class="fa fa-cogs"></i> Repuestos</a></li>
        <li class="active"><a> Editar</a></li>
    </ol>
@endsection
@section('content')
    <div class="row clearfix">
        <div class="col-md-12">
            <div class="alert alert-warning">
                <p class="h4"><strong>Edite la información del repuesto,</strong> gestiona la información de cada una de los reuestos de las lavadoras.
                </p>
            </div>
        </div>
    </div>
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Editar Repuesto</h3>
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
            <div class="col-md-12">
                {!! Form::open(['route'=>['repuesto.update',$repuesto->id],'method'=>'PUT','role'=>'form'])!!}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nombre*</label>
                        <input type="text" class="form-control" placeholder="Escriba el nombre del repuesto aqui" name="nombre" required="required" value="{{$repuesto->nombre}}"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Descripcion</label>
                        <input type="text" class="form-control" placeholder="Breve descripcion del repuesto"  name="descripcion" value="{{$repuesto->descripcion}}"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Precio*</label>
                        <input type="Number"  class="form-control" placeholder="Precio del repuesto en pesos colombianos" required name="precio" value="{{$repuesto->precio}}"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Cantidad*</label>
                        <input type="number" class="form-control" placeholder="Cantidad total de repuesto a ingresar en Bodega" required name="stock" value="{{$repuesto->stock}}"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Bodega</label>
                        {!! Form::select('bodega_id',$bodegas,$repuesto->bodega_id,['class'=>'form-control','placeholder'=>'-- Seleccione una opción --','required']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12" style="margin-top: 20px !important">
                        <button class="btn btn-success icon-btn pull-right" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                        <button class="btn btn-info icon-btn pull-right" type="reset"><i class="fa fa-fw fa-lg fa-trash-o"></i>Limpiar</button>
                        <a class="btn btn-danger icon-btn pull-right" href="{{route('repuesto.index')}}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                    </div>
                </div>
                {!! Form::close() !!}
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
