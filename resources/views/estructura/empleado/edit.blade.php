@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Estructura
    <small>Empleados de la empresa</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('admin.estructura')}}"><i class="fa fa-users"></i> Estructura</a></li>
    <li><a href="{{route('persona.index')}}"><i class="fa fa-users"></i> Empleados</a></li>
    <li class="active"><a> Editar</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="alert alert-warning">
            <p class="h4"><strong>Edite los datos del empleado,</strong> gestiona la información de cada una de los empleados de la empresa.
            </p>
        </div>
    </div>
</div>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Editar empleado</h3>
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
            {!! Form::open(['route'=>['persona.update',$persona->id],'method'=>'PUT','role'=>'form',])!!}
            <div class="col-md-12">
                <div class="alert alert-success">
                    <p class="h5"><center><b>Información del empleado</b></center></p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Identificación</label>
                    <input type="number" class="form-control" placeholder="identificacion del empleado" name="identificacion" required value="{{$persona->identificacion}}" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Primer Nombrer</label>
                    <input type="text" class="form-control" placeholder="primer nombre del empleado" name="primer_nombre" required  value="{{$persona->primer_nombre}}"/>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Segundo Nombre</label>
                    <input type="text" class="form-control" placeholder="Segundo nombre del empleado" name="segundo_nombre" value="{{$persona->segundo_nombre}}" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Primer Apellido</label>
                    <input type="text" class="form-control" placeholder="Primer apellido del empleado" name="primer_apellido" required value="{{$persona->primer_apellido}}" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Segundo Apellido</label>
                    <input type="text" class="form-control" placeholder="Segundo apellido del empleado" name="segundo_apellido" value="{{$persona->segundo_apellido}}"/>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Sexo</label>
                    {!! Form::select('sexo',
                      ['F'=>'FEMENINO','M'=>'MASCULINO'],$persona->sexo,
                    ['class'=>'form-control','placeholder'=>'-- Seleccione una opción --','required']) !!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Tipo de Sangre</label>
                    {!! Form::select('tipo_sangre',
                      ['O+'=>'O+','O-'=>'O-','A+'=>'A+',
                        'A-'=>'A-','B+'=>'B+','B-'=>'B-',
                        'AB+'=>'AB+','AB-'=>'AB-'],$persona->tipo_sangre,
                    ['class'=>'form-control','placeholder'=>'-- Seleccione una opción --','required']) !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Tipo de Empleado</label>
                    {!! Form::select('tipo',
                      ['CENTRAL'=>'CENTRAL','MENSAJERO'=>'MENSAJERO','TECNICO'=>'TÉCNICO'],$persona->tipo,
                    ['class'=>'form-control','placeholder'=>'-- Seleccione una opción --','required']) !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Correo</label>
                    <input type="email" class="form-control" placeholder="Correo electronico de contacto del empleado" required name="email" value="{{$persona->email}}"/>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Telefono</label>
                    <input type="number" class="form-control" placeholder="Telefono de contacto del empleado" required name="telefono" value="{{$persona->telefono}}"/>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Dirección</label>
                    <input type="text" class="form-control" placeholder="Domicilio donde reside el empleado" required name="direccion" value="{{$persona->direccion}}"/>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Estado</label>
                    {!! Form::select('estado',
                      ['ACTIVO'=>'ACTIVO','INACTIVO'=>'INACTIVO'],$persona->estado,
                      ['class'=>'form-control','placeholder'=>'-- Seleccione una opción --','required'])
                    !!}
                </div>
            </div>

            <div class="col-md-12">
                <div class="alert alert-success">
                    <p class="h5"><center><b>Contacto de Emergencia</b></center></p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" class="form-control" placeholder="Nombre completo del Contacto de emergencia" required name="nombre_contacto" value="{{$persona->contacto_emergencia->nombres}}"/>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Parentezco</label>
                    <input type="text" class="form-control" placeholder="Relacion con el empleado" required name="parentezco_contacto" value="{{$persona->contacto_emergencia->parentezco}}"/>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Telefono</label>
                    <input type="text" class="form-control" placeholder="Telefono de contacto" required name="telefono_contacto" value="{{$persona->contacto_emergencia->telefono}}"/>
                </div>
            </div>


            <div class="col-md-6">
                <div class="form-group">
                    <label>Correo</label>
                    <input type="text" class="form-control" placeholder="Correo del contacto de emergencia" required name="email_contacto" value="{{$persona->contacto_emergencia->email}}"/>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Dirección</label>
                    <input type="text" class="form-control" placeholder="Domicilio donde reside el contacto de emergencia" required name="direccion_contacto" value="{{$persona->contacto_emergencia->direccion}}"/>
                </div>
            </div>

            <input type="hidden" name="id_contacto" value="{{$persona->contacto_emergencia_id}}">

            <div class="form-group">
                <div class="col-md-12" style="margin-top: 20px !important">
                    <button class="btn btn-success icon-btn pull-right" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                    <button class="btn btn-info icon-btn pull-right" type="reset"><i class="fa fa-fw fa-lg fa-trash-o"></i>Limpiar</button>
                    <a class="btn btn-danger icon-btn pull-right" href="{{route('persona.index')}}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
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
