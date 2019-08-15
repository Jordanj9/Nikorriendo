@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Servicio
    <small>Solicitudes de Servicios</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('admin.servicio')}}"><i class="fa fa-users"></i> Servicio</a></li>
    <li><a href="{{route('servicio.index')}}"><i class="fa fa-users"></i> Solicitudes</a></li>
    <li class="active"><a> Crear</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="alert alert-warning">
            <p class="h4"><strong>Agregue nuevo servicio,</strong> gestiona la información de cada solicitud de servicios.
            </p>
        </div>
    </div>
</div>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Crear Servicio</h3>
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
            {!! Form::open(['route'=>'servicio.store','method'=>'POST','role'=>'form'])!!}
            <input type="hidden" name="latitud_cliente" id="latitud_cliente" />
            <input type="hidden" name="longitud_cliente" id="longitud_cliente" />
            <input type="hidden" name="latitud_servicio" id="latitud_servicio" />
            <input type="hidden" name="longitud_servicio" id="longitud_servicio" />
            <input type="hidden" name="id_cliente" id="id_cliente" />
            <div class="form-group">
                <div class="col-md-12"><h4 class="head" style="color: #2c3e50"><b>Datos del Cliente</b></h4></div>
                <div class="col-md-6">
                    <label>Telefono</label>
                    <input type="text" class="form-control" placeholder="Telefono del Cliente" name="telefono_cliente" id="telefono_cliente"/>
                </div>
                <div class="col-md-6">
                    <label>Si ha realizado pedidos antes pulse consultar</label>
                    <a class="btn btn-block bg-olive" onclick="ir()"><i>Consultar</i></a>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                    <label class="control-label">Nombre</label>
                    {!! Form::text('nombre',null,['class'=>'form-control','placeholder'=>'Nombres','required','id'=>'nombre']) !!}
                </div>
                <div class="col-md-6">
                    <label class="control-label">Dirección</label>
                    {!! Form::text('direccion',null,['class'=>'form-control','placeholder'=>'Dirección de residencia','required','id'=>'direccion_cliente']) !!}
                </div>
            </div>
            <div class="col-md-12"><h4 class="head" style="color: #2c3e50"><b>Datos del Servicio</b></h4></div>
            <div class="form-group">
                <div class="col-md-6">
                    <label class="control-label">Dirección del Servicio</label>
                    {!! Form::text('direccion_servico',null,['class'=>'form-control','placeholder'=>'Dirección de residencia','required','id'=>'direccion_servicio']) !!}
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12" style="margin-top: 20px !important">
                    <button class="btn btn-success icon-btn pull-right" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                    <button class="btn btn-info icon-btn pull-right" type="reset"><i class="fa fa-fw fa-lg fa-trash-o"></i>Limpiar</button>
                    <a class="btn btn-danger icon-btn pull-right" href="{{route('bodega.index')}}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
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
    function limpiar() {
        $("#nombre").html("");
        $("#telefono_cliente").html("");
        $("#direccion_servicio").html("");
        $("#direccion_cliente").html("");
        $("#latitud_cliente").html("");
        $("#longitud_cliente").html("");
        $("#latitud_servicio").html("");
        $("#longitud_servicio").html("");
    }
    function inhabilitar() {
        $("#nombre").attr('disabled', true);
        $("#telefono_cliente").attr('disabled', true);
        $("#direccion_cliente").attr('disabled', true);
    }
    function ir() {
        var id = $("#telefono_cliente").val();
        if (id.length <= 0) {
            notify('Atención', 'Debe ingresar un telefono.', 'error');
        } else {
            limpiar();
            $.ajax({
                type: 'GET',
                url: url + "servicio/servicio/" + id + "/getcliente",
                data: {},
            }).done(function (msg) {
                if (msg !== "null") {
                    var m = JSON.parse(msg);
                    $("#id_cliente").val(m.id);
                    $("#nombre").val(m.nom);
                    $("#apellidos").val(m.ape);
                    $("#telefono_cliente").val(m.tel);
                    $("#direccion_cliente").val(m.dir);
                    $("#direccion_servicio").val(m.dir);
                    $("#latitud_cliente").val(m.lat);
                    $("#longitud_cliente").val(m.lon);
                    $("#latitud_servicio").val(m.lat);
                    $("#longitud_servicio").val(m.lon);
                    inhabilitar();
                } else {
                    notify('Atención', 'No se encontro registro con ese telefono. Debe llenar el formulario.', 'error');
                    $("#telefono_cliente").removeAttr('disabled');
                }
            });
        }
    }
</script>
@endsection
