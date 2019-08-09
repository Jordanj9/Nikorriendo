@extends('layouts.app')
@section('content')
<div class="login-box" style="width: 800px !important">
    <div class="login-logo">
        <a href="{{url('/')}}">{{config('app.name')}}<b>Valledupar</b></a>
    </div>
    <div class="login-box-body">
        <p class="login-box-msg" style="font-size: 24px"><b>Registro de Usuarios</b></p>
        <div class="col-md-12">
            @component('layouts.errors')
            @endcomponent
        </div>
        <div class="row">
            {!! Form::open(['route'=>'usuario.new','method'=>'POST','role'=>'form','files'=>'true'])!!}
            @csrf
            <div class="col-md-4">
                <div class="form-group">
                    <label>Tipo de Usuario</label>
                    {!! Form::select('rol',['CONDUCTOR'=>'CONDUCTOR','PQR'=>'USUARIO PQR/FAQ'],null,['class'=>'form-control chosen-select','placeholder'=>'-- Seleccione una opción --','required','onchange'=>'verificar(this.value)']) !!}
                </div>
            </div>
            <div class="col-md-12">
                <h4 class="head" style="color: #2c3e50"><b>Datos Personales</b></h4>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Identificación</label>
                        <input class="form-control" type="text" name="identificacion" required="required">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nombres</label>
                        <input class="form-control" type="text" required="required" name="nombres">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Apellidos</label>
                        <input class="form-control" type="text" required="required" name="apellidos">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Dirección</label>
                        <input class="form-control" type="text" required="required" name="direccion">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Telefono</label>
                        <input class="form-control" type="text" required="required" name="telefono">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Correo</label>
                        <input class="form-control" type="email" required="required" name="email">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Contraseña</label>
                        <input class="form-control" type="password" required="required" name="password">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Foto</label>
                        <input class="form-control" type="file" required="required" name="foto" id="foto">
                    </div>
                </div>
            </div>
            <div class="col-md-12" id="fromambu">
                <h4 class="head" style="color: #2c3e50"><b>Datos de la Ambulancia</b></h4>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Marca</label>
                        <input class="form-control" type="text" name="marca" required="required" id="marca">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Placa</label>
                        <input class="form-control" type="text" name="placa" id="placa">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Modelo</label>
                        <input class="form-control" type="text" name="modelo" id="modelo">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Año</label>
                        <input class="form-control" type="number" name="anio" id="anio">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Entidad</label>
                        <input class="form-control" type="text" required="required" name="entidad" id="entidad">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Distintivo</label>
                        <input class="form-control" type="file" required="required" name="distintivo" id="distintivo">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Tarjeta de Propiedad</label>
                        <input class="form-control" type="file" required="required" name="tarjetapropiedad" id="tarjetapropiedad">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Soat</label>
                        <input class="form-control" type="file" required="required" name="soat" id="soat">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Tecnomecanica</label>
                        <input class="form-control" type="file" required="required" name="tecnomecanica" id="tecnomecanica">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Licencia</label>
                        <input class="form-control" type="file" required="required" name="licencia" id="licencia">
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <button class="btn btn-primary btn-raised btn-flat pull-right" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                    <button class="btn btn-info btn-raised btn-flat pull-right" type="reset"><i class="fa fa-fw fa-lg fa-trash-o"></i>Limpiar</button>
                    <a class="btn btn-danger btn-raised btn-flat pull-right" href="{{route('login')}}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->  
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function () {
        $("#fromambu").attr('style', 'display:none');
        $("#conductor").attr('style', 'display:none');
    });

    function verificar(id) {
        if (id == 'CONDUCTOR') {
            $("#fromambu").removeAttr('style');
            $("#conductor").removeAttr()('style');
        } else {
            $("#fromambu").attr('style', 'display:none');
            $("#conductor").attr('style', 'display:none');
        }
    }
</script>
@endsection
