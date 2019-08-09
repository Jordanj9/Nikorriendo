@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Usuarios
    <small>Editar/Eliminar Usuario</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('admin.usuarios')}}"><i class="fa fa-users"></i> Usuarios</a></li>
    <li><a href="{{route('usuario.index')}}"><i class="fa fa-users"></i> Listar Usuarios</a></li>
    <li class="active"><a> Editar/Eliminar Usuario</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="alert alert-warning">
            <p class="h4"><strong>Detalles: </strong>Edite ó elimine un usuario del sistema. Además, puede cambiar la contraseña.
            </p>
        </div>
    </div>
</div>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">DATOS DEL USUARIO</h3>
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
            {!! Form::open(['route'=>['usuario.update',$user],'method'=>'PUT','role'=>'form',])!!}     
            <div class="col-md-6">
                <div class="form-group">
                    <br/>{!! Form::text('identificacion',$user->identificacion,['class'=>'form-control','placeholder'=>'Escriba el número de identificación del usuario, con éste tendrá acceso al sistema','required']) !!}
                </div>
                <div class="form-group">
                    <br/>{!! Form::text('nombres',$user->nombres,['class'=>'form-control','placeholder'=>'Escriba los nombres del usuario','required','id'=>'txt_nombres']) !!}
                </div>
                <div class="form-group">
                    <br/>{!! Form::text('apellidos',$user->apellidos,['class'=>'form-control','placeholder'=>'Escriba los apellidos del usuario','required','id'=>'txt_apellidos']) !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <br/>{!! Form::email('email',$user->email,['class'=>'form-control','placeholder'=>'Escriba el correo electrónico del usuario','required','id'=>'txt_email']) !!}
                </div>
                <div class="form-group">
                    <br/>{!! Form::select('estado',['ACTIVO'=>'ACTIVO','INACTIVO'=>'INACTIVO'],$user->estado,['class'=>'form-control','placeholder'=>'-- Seleccione Estado del Usuario --','required']) !!}
                </div>
                <div class="form-group">
                    <label>Seleccione los Módulos a los que el Grupo Tendrá Acceso</label>
                    <select class="form-control show-tick select2" name="grupos[]" placeholder="Seleccione los Módulos a los que el Grupo Tendrá Acceso" required="" multiple="">
                        @foreach($grupos as $key=>$value)
                        <?php
                        $existe = false;
                        ?>
                        @foreach($user->grupousuarios as $m)
                        @if($m->id==$key)
                        <?php
                        $existe = true;
                        ?>
                        @endif
                        @endforeach
                        @if($existe)
                        <option value="{{$key}}" selected>{{$value}}</option>
                        @else
                        <option value="{{$key}}">{{$value}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12" style="margin-top: 20px !important">
                <br/><br/><a class="btn btn-danger icon-btn pull-right" href="{{route('usuario.index')}}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                <button class="btn btn-info icon-btn pull-right" type="reset"><i class="fa fa-fw fa-lg fa-trash-o"></i>Limpiar</button>
                <button class="btn btn-success icon-btn pull-right" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                <a href="{{ route('usuario.delete',$user->id)}}" class="btn btn-danger icon-btn pull-right"><i class="fa fa-fw fa-lg fa-user-times"></i>Eliminar Usuario</a>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">CAMBIAR CONTRASEÑA</h3>
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
            {!! Form::open(['route'=>['usuario.cambiarPass',$user],'method'=>'POST','role'=>'form',])!!}     
            <div class="col-md-4">
                <div class="form-group">
                    <label>Identificación</label>
                    <input type="text" name="identificacion2" value="{{$user->identificacion}}" class="form-control" readonly="" required="required" />
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Escriba la Nueva Contraseña</label>
                    <input type="password" name="pass1" placeholder="Mínimo 6 caracteres" class="form-control" required="required" />
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Escriba la Nueva Contraseña</label>
                    <input type="password" name="pass2" placeholder="Mínimo 6 caracteres" class="form-control" required="required" />
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12" style="margin-top: 20px !important">
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