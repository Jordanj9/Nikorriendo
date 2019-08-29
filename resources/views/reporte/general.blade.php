@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Reporte
    <small>General</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('inicio')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('admin.reporte')}}"><i class="fa fa-gear"></i> Reporte</a></li>
    <li class="active"><a> General</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="alert alert-warning">
            <p class="h4"><strong>Agregue nuevos Barrios,</strong> gestiona la información de los barrios.
            </p>
        </div>
    </div>
</div>
<div class="box">
    <div class="box-header with-border">
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
        <div class="panel-body">
            <div class="col-md-12">
                <div class="form-group">
                    <div class="col-md-4">
                        <div class="form-line">
                            <label class="control-label">Estado</label>
                            {!! Form::select('estado',['TODO'=>'TODO','PENDIENTE'=>'PENDIENTE','ASIGNADO'=>'ASIGNADO','ENTREGADO'=>'ENTREGADO','RECOGER'=>'RECOGER','FINALIZADO','FINALIZADO','CANCELADO'=>'CANCELADO'],null,['class'=>'form-control','placeholder'=>'-- Seleccione una opción --','required','id'=>'estado']) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-line">
                            <label class="control-label">Fecha Inicial</label>
                            <input class="form-control" type="date" required="required" name="fechai" id="fechai">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-line">
                            <label class="control-label">Fecha Final</label>
                            <input class="form-control" type="date" required="required" name="fechaf" id="fechaf">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-4">
                        <div class="form-line">
                            <label class="control-label">Sucursal</label>
                            {!! Form::select('sucursal_id',$sucursales,null,['class'=>'form-control','placeholder'=>'-- Seleccione una opción --','required','id'=>'sucursal_id','onchange'=>'getPersonas()']) !!}
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-line">
                            <label class="control-label">Empleado</label>
                            {!! Form::select('persona_id',[],null,['class'=>'form-control','id'=>'persona_id','onchange'=>'getLavadoras()']) !!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <div class="form-line">
                            <label class="control-label">Lavadora</label>
                            {!! Form::select('lavadora_id',[],null,['class'=>'form-control','id'=>'lavadora_id',]) !!}
                        </div>
                    </div>
                </div>
            </div>    
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <button onclick="getServicios()" class="btn bg-green-active icon-btn " ><i class="fa fa-search"></i>Consultar</button>      
            </div>
        </div>
        <div class="table-responsive"style="margin-top: 120px">
            <table id="tabla" class="table table-bordered table-striped table-hover table-responsive table-condensed" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>MENSAJERO</th>
                        <th>TELEFONO</th>
                        <th>CLIENTE</th>
                        <th>DIRECCIÓN</th>
                        <th>BARRIO</th>
                        <th>FECHA DE ENTREGA</th>
                        <th>FECHA FIN</th>
                        <th>FECHA RECOGIDA</th>
                        <th>ESTADO</th>
                        <th>CREACIÓN</th>
                    </tr>
                </thead>
                <tbody id="tb2">

                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="box-body">
    <!-- Line Chart -->
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>ESTADISTICAS DE SERVICIOS</h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-search"></i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="javascript:void(0);">Action</a></li>
                            <li><a href="javascript:void(0);">Another action</a></li>
                            <li><a href="javascript:void(0);">Something else here</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <canvas id="line_chart" height="150"></canvas>
            </div>
        </div>
    </div>
    <!-- #END# Line Chart -->
</div>

@endsection
@section('script')
<!-- Chart Plugins Js -->
<script src="{{ asset('js/chartjs/Chart.bundle.js')}}"></script>
<!-- Custom Js -->
<script src="{{ asset('js/admin.js')}}"></script>
<script>
                    $(function () {
                        $('#tabla').DataTable();
                    });

                    function getPersonas() {
                        $("#perosona_id").empty();
                        var id = $("#sucursal_id").val();
                        $.ajax({
                            type: 'GET',
                            url: url + "reporte/servicio/" + id + "/getpersonas",
                            data: {},
                        }).done(function (msg) {
                            if (msg !== 'null') {
                                var m = JSON.parse(msg);
                                $("#persona_id").append("<option value='0'>-- Seleccione una opción --</option>");
                                $.each(m, function (index, item) {
                                    $("#persona_id").append("<option value='" + item.id + "'>" + item.value + "</option>");
                                });
                            } else {
                                notify('Alerta', 'La sucursal seleccionada no posee mensajeros asociados', 'error');
                            }
                        });
                    }

                    function getLavadoras() {
                        $("#lavadora_id").empty();
                        var id = $("#persona_id").val();
                        $.ajax({
                            type: 'GET',
                            url: url + "reporte/servicio/" + id + "/getlavadoras",
                            data: {},
                        }).done(function (msg) {
                            if (msg !== 'null') {
                                var m = JSON.parse(msg);
                                $("#lavadora_id").append("<option value='0'>-- Seleccione una opción --</option>");
                                $.each(m, function (index, item) {
                                    $("#lavadora_id").append("<option value='" + item.id + "'>" + item.value + "</option>");
                                });
                            } else {
                                notify('Alerta', 'La persona seleccionada no posee lavadoras asociadas', 'error');
                            }
                        });
                    }
                    function getChartJs(type, meses, total, cant) {
                        var config = null;

                        if (type === 'line') {
                            config = {
                                type: 'line',
                                data: {
                                    labels: meses,
                                    datasets: [{
                                            label: "Total Ganancias",
                                            data: total,
                                            borderColor: 'rgba(0, 188, 212, 0.75)',
                                            backgroundColor: 'rgba(0, 188, 212, 0.3)',
                                            pointBorderColor: 'rgba(0, 188, 212, 0)',
                                            pointBackgroundColor: 'rgba(0, 188, 212, 0.9)',
                                            pointBorderWidth: 1
                                        }, {
                                            label: "Cantidad de Servicios",
                                            data: cant,
                                            borderColor: 'rgba(233, 30, 99, 0.75)',
                                            backgroundColor: 'rgba(233, 30, 99, 0.3)',
                                            pointBorderColor: 'rgba(233, 30, 99, 0)',
                                            pointBackgroundColor: 'rgba(233, 30, 99, 0.9)',
                                            pointBorderWidth: 1
                                        }]
                                },
                                options: {
                                    responsive: true,
                                    legend: false
                                }
                            }
                        } else if (type === 'bar') {
                            config = {
                                type: 'bar',
                                data: {
                                    labels: ["January", "February", "March", "April", "May", "June", "July"],
                                    datasets: [{
                                            label: "My First dataset",
                                            data: [65, 59, 80, 81, 56, 55, 40],
                                            backgroundColor: 'rgba(0, 188, 212, 0.8)'
                                        }, {
                                            label: "My Second dataset",
                                            data: [28, 48, 40, 19, 86, 27, 90],
                                            backgroundColor: 'rgba(233, 30, 99, 0.8)'
                                        }]
                                },
                                options: {
                                    responsive: true,
                                    legend: false
                                }
                            }
                        } else if (type === 'radar') {
                            config = {
                                type: 'radar',
                                data: {
                                    labels: ["January", "February", "March", "April", "May", "June", "July"],
                                    datasets: [{
                                            label: "My First dataset",
                                            data: [65, 25, 90, 81, 56, 55, 40],
                                            borderColor: 'rgba(0, 188, 212, 0.8)',
                                            backgroundColor: 'rgba(0, 188, 212, 0.5)',
                                            pointBorderColor: 'rgba(0, 188, 212, 0)',
                                            pointBackgroundColor: 'rgba(0, 188, 212, 0.8)',
                                            pointBorderWidth: 1
                                        }, {
                                            label: "My Second dataset",
                                            data: [72, 48, 40, 19, 96, 27, 100],
                                            borderColor: 'rgba(233, 30, 99, 0.8)',
                                            backgroundColor: 'rgba(233, 30, 99, 0.5)',
                                            pointBorderColor: 'rgba(233, 30, 99, 0)',
                                            pointBackgroundColor: 'rgba(233, 30, 99, 0.8)',
                                            pointBorderWidth: 1
                                        }]
                                },
                                options: {
                                    responsive: true,
                                    legend: false
                                }
                            }
                        } else if (type === 'pie') {
                            config = {
                                type: 'pie',
                                data: {
                                    datasets: [{
                                            data: [225, 50, 100, 40],
                                            backgroundColor: [
                                                "rgb(233, 30, 99)",
                                                "rgb(255, 193, 7)",
                                                "rgb(0, 188, 212)",
                                                "rgb(139, 195, 74)"
                                            ],
                                        }],
                                    labels: [
                                        "Pink",
                                        "Amber",
                                        "Cyan",
                                        "Light Green"
                                    ]
                                },
                                options: {
                                    responsive: true,
                                    legend: false
                                }
                            }
                        }
                        return config;
                    }

                    function getServicios() {
                        $("#tb2").html("");
                        var esta = $("#estado").val();
                        var fi = $("#fechai").val();
                        var ff = $("#fechaf").val();
                        var suc = $("#sucursal_id").val();
                        var per = $("#persona_id").val();
                        var lav = $("#lavadora_id").val();
                        if (esta == null || fi.length <= 0 || ff.length <= 0) {
                            notify('Alerta', 'Debe indicar todos los parámetros para continuar', 'warning');
                        }
                        if (suc.length <= 0) {
                            suc = null;
                        }
                        if (per == 0) {
                            per = null;
                        }
                        if (lav == 0) {
                            lav = null;
                        }
                        $.ajax({
                            type: 'GET',
                            url: url + "reporte/servicio/general/" + esta + "/" + fi + "/" + ff + "/" + suc + "/" + per + "/" + lav + "/getservicios",
                            data: {},
                        }).done(function (msg) {
                            if (msg !== "null") {
                                var m = JSON.parse(msg);
                                new Chart(document.getElementById("line_chart").getContext("2d"), getChartJs('line', m.meses, m.total, m.cant));
                                var html = "";
                                $.each(m.data, function (index, item) {
                                    html = html + "<tr><td>" + item.men + "</td>";
                                    html = html + "<td>" + item.tel_cli + "</td>";
                                    html = html + "<td>" + item.cli + "</td>";
                                    html = html + "<td>" + item.dir + "</td>";
                                    html = html + "<td>" + item.bar + "</td>";
                                    html = html + "<td>" + item.fechae + "</td>";
                                    html = html + "<td>" + item.fechaf + "</td>";
                                    html = html + "<td>" + item.fecharec + "</td>";
                                    html = html + "<td>" + item.est + "</td>";
                                    html = html + "<td>" + item.cre + "</td>";
                                    +"</tr>";
                                });
                                $("#tb2").html(html);
                            } else {
                                notify('Atención', 'No hay solicitudes para los parametros seleccionados', 'error');
                            }
                        });
                    }
</script>
@endsection
