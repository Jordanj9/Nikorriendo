@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Usuarios
    <small>Privilegio a páginas </small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('inicio')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('admin.usuarios')}}"><i class="fa fa-users"></i> Usuarios</a></li>
    <li class="active"><a><i class="fa fa-rouble"></i> Privilegio a Páginas</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="alert alert-warning">
            <p class="h4"><strong>Detalles: </strong>Los privilegios a páginas son los permisos que se deben asignar a los grupos de usuarios o roles para acceder a las funciones específicas de los módulos, es decir, sus páginas. En este sentido, si añade páginas a un grupo de usuario usted le estaría concediendo permisos al grupo para actuar sobre dichas páginas.<br/>
                <strong>Modo de Operar:</strong> Seleccione un grupo de usuario y agregue permisos de izquierda a derecha o elimine privilegios del grupo pasando de derecha a izquierda.
            </p>
        </div>
    </div>
</div>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Gestionar las Páginas de un Grupo de Usuarios</h3>
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
                        <br/>{!! Form::select('grupousuario_id',$grupos,null,['class'=>'form-control','placeholder'=>'Seleccione Grupo o Rol de Usuario','onchange="traerData()"','id'=>'grupousuario_id']) !!}
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card">
                        <div class="body bg-red" style="padding: 10px">
                            <strong>PÁGINAS DEL SISTEMA</strong>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            {!! Form::select('paginas[]',$paginas,null,['class'=>'form-control','style'=>'height: 250px','multiple','size="20"','id'=>'paginas']) !!}
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
                            <strong>PRIVILEGIOS DEL GRUPO</strong>
                        </div>
                    </div>
                    {!! Form::open(['route'=>'grupousuario.guardar','method'=>'POST','class'=>'form-horizontal','name'=>'form-privilegios','id'=>'form-privilegios'])!!}
                    {!! Form::hidden('id',null,['class'=>'form-control','id'=>'id']) !!}
                    <div class="form-group">
                        <div class="form-line">
                            <select name="privilegios[]" id="privilegios" class="form-control" style="height: 250px" multiple="" size="20" required="required"></select>
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
            notify('Atención', 'Debe seleccionar un grupo de usuarios para agregar privilegios.', 'warning');
        } else {
            $('#privilegios option').each(function () {
                var valor = $(this).attr('value');
                $("#privilegios").find("option[value='" + valor + "']").prop("selected", true);
            });
            $("#form-privilegios").submit();
        }
    }
    function agregar() {
        var id = $("#grupousuario_id").val();
        if (id === null) {
            notify('Atención', 'Debe seleccionar un grupo de usuarios para agregar privilegios.', 'warning');
        } else {
            $.each($('#paginas :selected'), function () {
                var valor = $(this).val();
                var texto = $(this).text();
                if (!existe(valor)) {
                    $("#privilegios").append("<option value='" + valor + "'>" + texto + "</option>");
                    $("#paginas").find("option[value='" + valor + "']").prop("disabled", true);
                }
            });
        }
    }

    function agregarTodas() {
        var id = $("#grupousuario_id").val();
        if (id === null) {
            notify('Atención', 'Debe seleccionar un grupo de usuarios para agregar privilegios.', 'warning');
        } else {
            $('#paginas option').each(function () {
                var valor = $(this).attr('value');
                var texto = $(this).text();
                if (texto !== "-- Seleccione una opción --") {
                    if (!existe(valor)) {
                        $("#privilegios").append("<option value='" + valor + "'>" + texto + "</option>");
                        $("#paginas").find("option[value='" + valor + "']").prop("disabled", true);
                    }
                }
            });
        }
    }

    function existe(valor) {
        var array = [];
        $("#privilegios option").each(function () {
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
        $.each($('#privilegios :selected'), function () {
            var valor = $(this).val();
            $("#paginas").find("option[value='" + valor + "']").prop("disabled", false);
            $(this).remove();
        });
    }

    function retirarTodas() {
        $('#privilegios option').each(function () {
            var valor = $(this).attr('value');
            $("#paginas").find("option[value='" + valor + "']").prop("disabled", false);
            $(this).remove();
        });
    }

    function traerData() {
        var id = $("#grupousuario_id").val();
        $("#id").val(id);
        $.ajax({
            type: 'GET',
            url: url + "/usuarios/grupousuario/" + id + "/traerdata/privilegios",
            data: {},
        }).done(function (msg) {
            $('#privilegios option').each(function () {
                $(this).remove();
            });
            if (msg !== "null") {
                var m = JSON.parse(msg);
                $('#paginas option').each(function () {
                    var valor = $(this).attr('value');
                    $("#paginas").find("option[value='" + valor + "']").prop("disabled", false);
                });
                $.each(m, function (index, item) {
                    $("#privilegios").append("<option value='" + item.id + "'>" + item.value + "</option>");
                    $("#paginas").find("option[value='" + item.id + "']").prop("disabled", true);
                });
            } else {
                notify('Atención', 'El grupo de usuarios seleccionado no tiene privilegios asignados aún.', 'error');
                $('#paginas option').each(function () {
                    var valor = $(this).attr('value');
                    $("#paginas").find("option[value='" + valor + "']").prop("disabled", false);
                });
            }
        });
    }
</script>
@endsection
