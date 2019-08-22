@extends('layouts.admin')
@section('breadcrumb')
<h1>
    General
    <small>Asignar lavadoras a empleado</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('inicio')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('admin.estructura')}}"><i class="fa fa-gear"></i> General</a></li>
    <li class="active"><a><i class="fa fa-exchange"></i> Asignar Lavadora</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="alert alert-warning">
            <p class="h4"><strong>Detalles: </strong>Este módulo permite asignar lavadoras a un empleado específico, el cual responderá por las lavadoras asignadas.<br/>
                <strong>Modo de Operar: </strong> Seleccione un mensajero y agregue las lavadoras de izquierda a derecha o elimine las lavadoras del mensajero pasando de derecha a izquierda.
            </p>
        </div>
    </div>
</div>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Gestionar las Lavadoras Asigandas</h3>
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
            <div class="row clearfix">
                <div class="col-md-12" style="margin-bottom: 30px">
                    <div class="form-group">
                        <br/>{!! Form::select('persona_id',$personas,null,['class'=>'form-control','placeholder'=>'Seleccione el Empleado','onchange="traerData()"','id'=>'persona_id']) !!}
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card">
                        <div class="body bg-red" style="padding: 10px">
                            <strong>LAVADORAS SIN ASIGNAR</strong>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            {!! Form::select('lavadoras[]',$lavadoras,null,['class'=>'form-control','style'=>'height: 400px;  overflow-x: scroll;','placeholder'=>'-- Seleccione una opción --','multiple','size="20"','id'=>'lavadoras']) !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-2" style="margin-top: 5%;">
                    <div class="col-md-12">
                        <center><button type="button" class="btn btn-sm bg-maroon-active" onclick="agregar()"> Agregar </button></center>
                    </div>
                    <div class="col-md-12">
                        <center><button type="button" class="btn btn-sm bg-orange-active" onclick="retirar()"> Quitar </button></center>
                    </div>
                    <div class="col-md-12">
                        <center><button type="button" class="btn btn-sm bg-maroon-active" onclick="agregarTodas()"> Agregar Todo </button></center>
                    </div>
                    <div class="col-md-12">
                        <center><button type="button" class="btn btn-sm bg-orange-active" onclick="retirarTodas()"> Quitar Todo </button></center>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card">
                        <div class="body bg-red" style="padding: 10px">
                            <strong>LAVADORAS DEL EMPLEADO</strong>
                        </div>
                    </div>
                    {!! Form::open(['route'=>'lavadora_persona.guardar','method'=>'POST','class'=>'form-horizontal','name'=>'form-asignadas','id'=>'form-asignadas'])!!}
                    {!! Form::hidden('id',null,['class'=>'form-control','id'=>'id']) !!}
                    <div class="form-group">
                        <div class="form-line">
                            <select name="asignadas[]" id="asignadas" class="form-control" style="height: 400px;  overflow-x: scroll;" multiple="" size="20" required="required"></select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <br/><button type="submit" id="btn-enviar" class="btn bg-red waves-effect btn-block"><strong>Guardar los Cambios Para el Grupo Seleccionado</strong></button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function () {
        $("#btn-enviar").click(function (e) {
            validar(e);
        });
    });
    function validar(e) {
        e.preventDefault();
        var id = $("#id").val();
        if (id.length === 0) {
            notify('Atención', 'Debe seleccionar un empleado de la empresa para agregar lavadoras.', 'warning');
        } else {
            $('#asignadas option').each(function () {
                var valor = $(this).attr('value');
                $("#asignadas").find("option[value='" + valor + "']").prop("selected", true);
            });
            $("#form-asignadas").submit();
        }
    }
    function agregar() {
        var id = $("#persona_id").val();
        if (id === null) {
            notify('Atención', 'Debe seleccionar un empleado para agregar lavadoras.', 'warning');
        } else {
            $.each($('#lavadoras :selected'), function () {
                var valor = $(this).val();
                var texto = $(this).text();
                if (!existe(valor)) {
                    $("#asignadas").append("<option value='" + valor + "'>" + texto + "</option>");
                    $("#lavadoras").find("option[value='" + valor + "']").prop("disabled", true);
                }
            });
        }
    }

    function agregarTodas() {
        var id = $("#persona_id").val();
        if (id === null) {
            notify('Atención', 'Debe seleccionar un grupo de usuarios para agregar lavadoras.', 'warning');
        } else {
            $('#lavadoras option').each(function () {
                var valor = $(this).attr('value');
                var texto = $(this).text();
                if (texto !== "-- Seleccione una opción --") {
                    if (!existe(valor)) {
                        $("#asignadas").append("<option value='" + valor + "'>" + texto + "</option>");
                        $("#lavadoras").find("option[value='" + valor + "']").prop("disabled", true);
                    }
                }
            });
        }
    }

    function existe(valor) {
        var array = [];
        $("#asignadas option").each(function () {
            array.push($(this).attr('value'));
        });
        var index = $.inArray(valor, array);
        if (index !== -1) {
            return true;
        } else {
            return false;
        }
    }

    function retirar() {
        $.each($('#asignadas :selected'), function () {
            var valor = $(this).val();
            $("#lavadoras").find("option[value='" + valor + "']").prop("disabled", false);
            $(this).remove();
        });
    }

    function retirarTodas() {
        $('#asignadas option').each(function () {
            var valor = $(this).attr('value');
            $("#lavadoras").find("option[value='" + valor + "asignadas']").prop("disabled", false);
            $(this).remove();
        });
    }

    function traerData() {
        var id = $("#persona_id").val();
        $("#id").val(id);
        $.ajax({
            type: 'GET',
            url: "lavadora_persona/" + id + "/asignadas",
            data: {},
        }).done(function (msg) {
            $('#asignadas option').each(function () {
                $(this).remove();
            });
            if (msg !== "null") {
                var m = JSON.parse(msg);
                $('#lavadoras option').each(function () {
                    var valor = $(this).attr('value');
                    $("#lavadoras").find("option[value='" + valor + "']").prop("disabled", false);
                });
                $.each(m, function (index, item) {
                    $("#asignadas").append("<option value='" + item.id + "'>" + item.value + "</option>");
                    $("#lavadoras").find("option[value='" + item.id + "']").prop("disabled", true);
                });
            } else {
                notify('Atención', 'El empleado seleccionado no tiene lavadoras asignadas aún.', 'error');
                $('#lavadoras option').each(function () {
                    var valor = $(this).attr('value');
                    $("#lavadoras").find("option[value='" + valor + "']").prop("disabled", false);
                });
            }
        });
    }
</script>
@endsection
