<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{config('app.name','Nikorriendo')}}</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css')}}">
        <!-- Ionicons -->
        <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css')}}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css')}}">
        <!-- Material Design -->
        <link rel="stylesheet" href="{{ asset('dist/css/bootstrap-material-design.min.css')}}">
        <link rel="stylesheet" href="{{ asset('dist/css/ripples.min.css')}}">
        <link rel="stylesheet" href="{{ asset('dist/css/MaterialAdminLTE.min.css')}}">
        <!-- Plugins -->
        <link rel="stylesheet" type="text/css" href="{{asset('plugins/chosen_v1.7.0/chosen.css')}}"/>
        <link href="{{asset('plugins/pnotify/dist/pnotify.css')}}" rel="stylesheet">
        <link href="{{asset('plugins/pnotify/dist/pnotify.buttons.css')}}" rel="stylesheet">
        <link href="{{asset('plugins/pnotify/dist/pnotify.nonblock.css')}}" rel="stylesheet">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="{{ asset('dist/css/skins/all-md-skins.min.css')}}">
        <!-- Select2 -->
        <link rel="stylesheet" href="{{ asset('select2/dist/css/select2.min.css')}}">
        <link href="{{asset('css/themes/all-themes.css')}}" rel="stylesheet"/>
        <!-- DataTables -->
        <link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
        <link rel="shortcut icon" href="{{asset('images/logomio.png')}}">

        <link rel="stylesheet" href="{{asset('bower_components/datatables.net/css/responsive.dataTables.min.css')}}">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js')}}"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js')}}"></script>
        <![endif]-->

        <!-- Google Font -->
        <link rel="stylesheet"
              href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

        @yield('style')
    </head>
    <body class="hold-transition skin-red sidebar-mini">

        <!-- Site wrapper -->
        <div class="wrapper">

            <header class="main-header">
                <!-- Logo -->
                <a href="{{route('home')}}" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini">N<b>i</b>k<b>o</b></span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg">{{ config('app.name', 'Consejo') }}<b> Valledupar</b></span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>

                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li class="dropdown notifications-menu">
                                <a href="#" class="dropdown-toggle" onclick="dropdown(event)">
                                    <i class="fa fa-bell-o"></i>
                                    <span class="label label-warning">10</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">You have 10 notifications</li>
                                    <li>
                                        <!-- inner menu: contains the actual data -->
                                        <ul class="menu">
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                                                    page and may cause design problems
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-users text-red"></i> 5 new members joined
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-user text-red"></i> You changed your username
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="footer"><a href="#">View all</a></li>
                                </ul>
                            </li>
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" onclick="dropdown(event)">
                                    <img src="{{ asset('dist/img/user-160x160.jpg')}}" class="user-image" alt="User Image">
                                    <span class="hidden-xs">{{Auth::user()->nombres." ".Auth::user()->apellidos}}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="{{ asset('dist/img/user-160x160.jpg')}}" class="img-circle" alt="User Image">

                                        <p>
                                            {{Auth::user()->nombres." ".Auth::user()->apellidos}}
                                            <small>{{Auth::user()->rol}}</small>
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="{{route('home')}}" class="btn btn-default btn-flat">Inicio</a>
                                        </div>
                                        <div class="pull-right">
                                            <a class="btn btn-default btn-flat" href="{{ route('logout') }}"
                                               onclick="event.preventDefault();
                                                       document.getElementById('logout-form').submit();">
                                                Salir
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                  style="display: none;">
                                                @csrf
                                            </form>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- =============================================== -->
            <!-- Left side column. contains the sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="{{ asset('dist/img/user-160x160.jpg')}}" class="img-circle" alt="User Image">
                        </div>
                        <div class="pull-left info">
                            <p>{{Auth::user()->nombres}}</p>
                            <a href="#"><i class="fa fa-circle text-success"></i> Conectado </a>
                        </div>
                    </div>
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu" data-widget="tree">
                        <li class="header"><h4>MENÚ PRINCIPAL</h4></li>
                        @if(session()->exists('MOD_INICIO'))
                        @if($location=='inicio')
                        <li class="active"><a href="{{route('home')}}"><i class="fa fa-home"></i>
                                <span>Inicio</span></a></li>
                        @else
                        <li><a href="{{route('home')}}"><i class="fa fa-home"></i> <span>Inicio</span></a></li>
                        @endif
                        @endif
                        @if(session()->exists('MOD_USUARIOS'))
                        @if($location=='usuarios')
                        <li class="active"><a href="{{route('admin.usuarios')}}"><i class="fa fa-users"></i> <span>Usuarios</span></a>
                        </li>
                        @else
                        <li><a href="{{route('admin.usuarios')}}"><i class="fa fa-users"></i> <span>Usuarios</span></a>
                        </li>
                        @endif
                        @endif
                        @if(session()->exists('MOD_ESTRUCTURA'))
                        @if($location=='estructura')
                        <li class="active"><a href="{{route('admin.estructura')}}"><i class="fa fa-th-list"></i> <span>Estructura</span></a>
                        </li>
                        @else
                        <li><a href="{{route('admin.estructura')}}"><i class="fa fa-th-list"></i>
                                <span>Estructura</span></a></li>
                        @endif
                        @endif
                        @if(session()->exists('MOD_SERVICIO'))
                        @if($location=='servicio')
                        <li class="active"><a href="{{route('admin.servicio')}}"><i class="fa  fa-indent"></i> <span>Servicio</span></a>
                        </li>
                        @else
                        <li><a href="{{route('admin.servicio')}}"><i class="fa  fa-indent"></i>
                                <span>Servicio</span></a></li>
                        @endif
                        @endif
                        @if(session()->exists('MOD_MANTENIMIENTO'))
                        @if($location=='mantenimiento')
                        <li class="active"><a href="{{route('admin.mantenimiento')}}"><i class="fa fa-gear"></i> <span>Mantenimiento</span></a>
                        </li>
                        @else
                        <li><a href="{{route('admin.mantenimiento')}}"><i class="fa fa-gear"></i>
                                <span>Mantenimiento</span></a></li>
                        @endif
                        @endif
                    </ul>
                    <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form2').submit();">
                            <i class="fa fa-sign-out"></i> Salir
                        </a>
                        <form id="logout-form2" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- =============================================== -->

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    @yield('breadcrumb')
                </section>
                <!-- Main content -->
                <section class="content">
                    @include('flash::message')
                    @yield('content')
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Version</b> 1.0.0
                </div>
                <strong> &copy;2019 <a href="#">Jordan Cuadro</a></strong>
            </footer>
        </div>
        <!-- ./wrapper -->

        <!-- jQuery 3 -->
        <script src="{{ asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
        <!-- Material Design -->
        <script src="{{ asset('dist/js/material.min.js')}}"></script>
        <script src="{{ asset('dist/js/ripples.min.js')}}"></script>
        <!-- ChartJS -->
        <script src="{{asset('bower_components/chart.js/Chart.js')}}"></script>
        <!-- SlimScroll -->
        <script src="{{ asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
        <!-- FastClick -->
        <script src="{{ asset('bower_components/fastclick/lib/fastclick.js')}}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('dist/js/adminlte.min.js')}}"></script>
        <!-- DataTables -->
        <script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
        <script src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
        <!-- CK Editor -->
        <script src="{{ asset('js/ckeditor/ckeditor.js')}}"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="{{ asset('dist/js/demo.js')}}"></script>
        <!-- Select2 -->
        <script src="{{ asset('select2/dist/js/select2.full.min.js')}}"></script>
        <!-- start: Javascript -->
        <!--        <script src="{{ asset('js/jquery.min.js')}}"></script>-->
        <script src="{{ asset('js/jquery.ui.min.js')}}"></script>
        <script src="{{asset('bower_components/datatables.net/js/dataTables.responsive.min.js')}}"></script>
        <script src="{{ asset('js/bootstrap.min.js')}}"></script>
        <script src="{{ asset('plugins/pnotify/dist/pnotify.js')}}"></script>
        <script src="{{ asset('plugins/pnotify/dist/pnotify.buttons.js')}}"></script>
        <script src="{{ asset('plugins/pnotify/dist/pnotify.nonblock.js')}}"></script>
        <script src="{{ asset('plugins/ckeditor/ckeditor.js')}}"></script>
        <script src="{{ asset('js/axios.min.js')}}"></script>
        <!-- start: Javascript -->
        <script src="{{asset('js/app.js')}}"></script>
        <script type="text/javascript">
                            var url = "<?php echo config('app.url'); ?>public/";

                            $(document).ready(function () {
                                $('.sidebar-menu').tree();
                            });
                            $.material.init();
                            function notify(title, text, type) {
                                new PNotify({
                                    title: title,
                                    text: text,
                                    type: type,
                                    styling: 'bootstrap3'
                                });
                            }
                            function dropdown(event){
                                event.preventDefault();
                                const ul = event.target.parentElement.querySelector('.dropdown-menu');
                                console.log(ul);
                                ul.classList.toggle('dropdown-active');
                                if(ul.classList.contains('dropdown-active')){
                                    ul.style.display = 'block';
                                }else{
                                    ul.style.display = 'none';
                                }

                            }
        </script>
        @yield('script')
    </body>
</html>
