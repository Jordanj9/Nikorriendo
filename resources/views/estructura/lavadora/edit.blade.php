@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Estructura
    <small>Lavadoras del sistema</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('admin.estructura')}}"><i class="fa fa-users"></i> Estructura</a></li>
    <li><a href="{{route('lavadora.index')}}"><i class="fa fa-users"></i> Lavadoras</a></li>
    <li class="active"><a> Editar</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="alert alert-warning">
            <p class="h4"><strong>Nota: </strong> gestiona la información de cada una de las Lavadoras de la empresa.
            </p>
        </div>
    </div>
</div>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Editar Lavadora</h3>
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
            {!! Form::open(['route'=>['lavadora.update',$lavadora->id],'method'=>'PUT','role'=>'form',])!!}
            <div class="col-md-6">
                <div class="form-group">
                    <label>Serial</label>
                    <input type="number" class="form-control" placeholder="Numero de Identificación de la lavadora" name="serial" required value="{{$lavadora->serial}}"/>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Marca</label>
                    <input type="text" class="form-control" placeholder="Marca de la Lavadora" name="marca" required value="{{$lavadora->marca}}"/>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Estado Lavadora</label>
                    <select name="estado_lavadora" id="" class="form-control" data-placeholder="-- Seleccione una opción --">
                       @switch($lavadora->estado_lavadora)
                           @case('DISPONIBLE')
                            <option value="DISPONIBLE" selected>DISPONIBLE</option>
                            <option value="SERVICIO">SERVICIO</option>
                            <option value="MANTENIMIENTO">MANTENIMIENTO</option>
                            <option value="INACTIVA">INACTIVA</option>
                           @break
                            @case('SERVICIO')
                            <option value="DISPONIBLE" >DISPONIBLE</option>
                            <option value="SERVICIO" selected>SERVICIO</option>
                            <option value="MANTENIMIENTO">MANTENIMIENTO</option>
                            <option value="INACTIVA">INACTIVA</option>
                            @break
                            @case('MANTENIMIENTO')
                            <option value="DISPONIBLE" >DISPONIBLE</option>
                            <option value="SERVICIO">SERVICIO</option>
                            <option value="MANTENIMIENTO" selected>MANTENIMIENTO</option>
                            <option value="INACTIVA">INACTIVA</option>
                            @break
                            @case('INACTIVA')
                            <option value="DISPONIBLE" >DISPONIBLE</option>
                            <option value="SERVICIO">SERVICIO</option>
                            <option value="MANTENIMIENTO" selected>MANTENIMIENTO</option>
                            <option value="INACTIVA">INACTIVA</option>
                            @break
                        @endswitch
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Bodegas</label>
                    {!! Form::select('bodega_id',$bodegas,$lavadora->bodega->id,['class'=>'form-control','placeholder'=>'-- Seleccione una opción --','required']) !!}
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12" style="margin-top: 20px !important">
                <button class="btn btn-success icon-btn pull-right" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                <button class="btn btn-info icon-btn pull-right" type="reset"><i class="fa fa-fw fa-lg fa-trash-o"></i>Limpiar</button>
                <a class="btn btn-danger icon-btn pull-right" href="{{route('lavadora.index')}}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
            </div>
        </div>
        {!! Form::close() !!}
        </form>
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
