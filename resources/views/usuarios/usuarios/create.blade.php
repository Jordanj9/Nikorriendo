@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Usuarios
    <small>Usuario Manual </small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('inicio')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('admin.usuarios')}}"><i class="fa fa-users"></i> Usuarios</a></li>
    <li class="active"><a> Crear Usuario</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="alert alert-warning">
            <p class="h4"><strong>Agregue un usuario al sistema y registre su/sus roles de acceso, </strong>. Puede crear un usuario llenando todos los campos requeridos.
            </p>
        </div>
    </div>
</div>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Datos del Usuario</h3>
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
            {!! Form::open(['route'=>'usuario.store','method'=>'POST','role'=>'form',])!!}     
            <div class="col-md-6">
                <div class="form-group">
                    <br/>{!! Form::text('identificacion',null,['class'=>'form-control','placeholder'=>'Escriba el número de identificación del usuario, con éste tendrá acceso al sistema','required']) !!}
                </div>
                <div class="form-group">
                    <br/>{!! Form::text('nombres',null,['class'=>'form-control','placeholder'=>'Escriba los nombres del usuario','required','id'=>'txt_nombres']) !!}
                </div>
                <div class="form-group">
                    <br/>{!! Form::text('apellidos',null,['class'=>'form-control','placeholder'=>'Escriba los apellidos del usuario','required','id'=>'txt_apellidos']) !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <br/>{!! Form::email('email',null,['class'=>'form-control','placeholder'=>'Escriba el correo electrónico del usuario','required','id'=>'txt_email']) !!}
                </div>
                <div class="form-group">
                    <br/>{!! Form::select('estado',['ACTIVO'=>'ACTIVO','INACTIVO'=>'INACTIVO'],null,['class'=>'form-control','placeholder'=>'-- Seleccione Estado del Usuario --','required']) !!}
                </div>
                <div class="form-group">
                    <br/>{!! Form::password('password',['class'=>'form-control','required','placeholder'=>'Contraseña del Usuario']) !!}          
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Seleccione los Módulos a los que el Grupo Tendrá Acceso</label>
                    {!! Form::select('grupos[]',$grupos,null,['class'=>'form-control show-tick select2','placeholder'=>'Seleccione los Grupos o Roles de Usuarios','required','multiple']) !!}
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12" style="margin-top: 20px !important">
                <br/><br/><a class="btn btn-danger icon-btn pull-right" href="{{route('admin.usuarios')}}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                <button class="btn btn-info icon-btn pull-right" type="reset"><i class="fa fa-fw fa-lg fa-trash-o"></i>Limpiar</button>
                <button class="btn btn-success icon-btn pull-right" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $('.select2').select2();
    $(function () {
        $('#example1').DataTable();
    });
</script>
@endsection