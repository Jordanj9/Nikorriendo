@extends('layouts.admin')
@section('style')
    <style>

        .boton {
            color: #FFFFFF !important;
            font-weight: bold;
            border-radius: 20px;
        }

        @media (max-width: 468px) {

            .boton {
                width: 100%;
            }

        }

    </style>
@endsection
@section('breadcrumb')
    <h1>
        Usuarios
        <small>Menu de Usuarios</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('inicio')}}"><i class="fa fa-home"></i> Inicio</a></li>
        <li class="active"><a><i class="fa fa-users"></i> Usuarios</a></li>
    </ol>
@endsection
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Menu Usuarios</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                        title="Minimizar">
                    <i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                        title="Cerrar">
                    <i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">
            <div class="button-demo">
                @if(session()->exists('PAG_MODULOS'))
                    <a class="btn btn-app btn-lg bg-aqua-gradient boton" href="{{route('modulo.index')}}"
                       style="color: #66639E; font-weight: bold">
                        <i class="fa fa-cubes"></i> MÓDULOS DEL SISTEMA
                        <div class="ripple-container"></div>
                    </a>
                @endif
                @if(session()->exists('PAG_PAGINAS'))
                    <a class="btn btn-app btn-lg bg-aqua-gradient boton" href="{{route('pagina.index')}}"
                       style="color: #66639E; font-weight: bold">
                        <i class="fa fa-file-powerpoint-o"></i> PÁGINAS DEL SISTEMA
                        <div class="ripple-container"></div>
                    </a>
                @endif
                @if(session()->exists('PAG_GRUPO-ROLES'))
                        <a class="btn btn-app btn-lg bg-aqua-gradient boton" href="{{route('grupousuario.index')}}"
                           style="color: #66639E; font-weight: bold">
                            <i class="fa fa-user"></i> GRUPOS O ROLES DE USUARIOS
                            <div class="ripple-container"></div>
                        </a>
                @endif
                @if(session()->exists('PAG_PRIVILEGIOS'))
                        <a class="btn btn-app btn-lg bg-aqua-gradient boton" href="{{route('grupousuario.privilegios')}}"
                           style="color: #66639E; font-weight: bold">
                            <i class="fa fa-rouble"></i> PRIVILÉGIOS A PÁGINAS
                            <div class="ripple-container"></div>
                        </a>
                @endif
                @if(session()->exists('PAG_USUARIOS'))
                        <a class="btn btn-app btn-lg bg-aqua-gradient boton" href="{{route('usuario.index')}}"
                           style="color: #66639E; font-weight: bold">
                            <i class="fa fa-users"></i> LISTAR TODOS LOS USUARIOS
                            <div class="ripple-container"></div>
                        </a>
                @endif
                @if(session()->exists('PAG_USUARIO-MANUAL'))
                        <a class="btn btn-app btn-lg bg-aqua-gradient boton" href="{{route('usuario.create')}}"
                           style="color: #66639E; font-weight: bold">
                            <i class="fa fa-user-circle-o"></i> USUARIO MANUAL
                            <div class="ripple-container"></div>
                        </a>
                @endif
            </div>
        </div>
    </div>
    @if(session()->exists('PAG_OPERACIONES-USUARIO'))
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">MODIFICACIÓN Y </br> ELIMINACIÓN DE USUARIOS</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Minimizar">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                            title="Cerrar">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="col-md-12">
                    <div class="body">
                        <div class="row clearfix">
                            <form class="form-horizontal" method="POST" action="{{route('usuario.operaciones')}}"
                                  name="form-privilegios" id="form-privilegios">
                                @csrf
                                <div class="col-md-12">
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" id="id" class="form-control"
                                                       placeholder="Escriba la identificación a consultar" name="id"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <button type="submit" class="btn btn-app btn-lg bg-orange-active btn-block boton waves-effect" href=""
                                           style="color: #66639E; font-weight: bold">
                                            <i class="fa fa-search"></i>CONSULTAR USUARIO
                                            <div class="ripple-container"></div>
                                        </button>
                                        <!--<button type="submit" class="btn bg-orange-active waves-effect btn-block boton">
                                            CONSULTAR USUARIO
                                        </button>-->
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Cambiar Contraseña</h4>
                </div>
                <div class="modal-body">
                    {!! Form::open(['route'=>'usuario.operaciones','method'=>'POST','class'=>'form-horizontal'])!!}
                    <input type="hidden" name="id" id="ide"/>
                    <div class="form-group">
                        <div class="col-md-2">
                            <label class="col-md-2 control-label">Nueva Contraseña</label>
                        </div>
                        <div class="col-md-10">
                            <input class="form-control" type="password" required="required" name="password">
                        </div>
                        <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Cerrar</button>
                        <button class="btn btn-success icon-btn pull-right" type="submit"><i
                                class="fa fa-fw fa-lg fa-save"></i>Cambiar
                        </button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@endsection
@section('script')
    <script type="text/javascript">
        $(function () {
            $('#example1').DataTable();
        });

        function ir(id) {
            $("#ide").val(id);
        }
    </script>
@endsection
