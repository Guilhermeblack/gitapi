<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Cosntrumobile</title>
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.0/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css"> --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

    {{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script> --}}
</head>

<body id="page-top">
    <script type="text/javascript">
        $(document).ready(function(){
            $(".nav-item" ).on('mouseover', function() {
                    $(this).css( "background-color", 'rgb(46, 85, 202)' );
                    $(this).css('cursor', 'pointer');
                    $(this).on('click', function(){
                        // console.log($(this));
                        $('.dropdown-menu').hide();
                        $(this).find('.dropdown-menu').show();
                        $(this).find('.dropdown-menu').css('border','none');

                    });
            });
            $(this).find('.dropdown-item').on('mouseover', function() {
                $(this).css('background-color', 'rgb( 38, 53, 190)' )
            });
            $(this).find('.dropdown-item').on('mouseout', function() {
                $(this).css('background-color', 'transparent' )
            });
            $(".nav-item" ).on('mouseout',function() {
                $( this ).css( "background-color",'transparent' );
            });


        });


    </script>

    <div id="wrapper">
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient p-0" style="background-color: rgb(63, 104, 230)">
            <div class="container-fluid d-flex  p-0 ">
                <a class="navbar-brand d-flex ml-auto mr-auto m-1"  href="{{ url('home') }}" style="height: auto; width: 50%">
                    <div class="sidebar-brand-image" ><img style="border-radius: 25px; " class=' img-thumbnail d-sm-flex' src="{{ asset('/img/gitz.png') }}" /></div>
                </a>
                {{-- <hr class="sidebar-divider my-0"> --}}
                <ul class="nav navbar-nav text-light " id="accordionSidebar">
                    @guest
                        <li class="nav-item nav-pills nav-fill " role="presentation"><a class="nav-link" href="{{ url('login') }}" style="color: #fff"><i class="far fa-user-circle" ></i><span><b>Login</b></span></a></li>
                    @endguest
                    <hr class="sidebar-divider my-2" >
                    @auth

                    <li class="nav-item" role="presentation"><a aria-expanded="false" href="{{ url('cad') }}" style="color:#fff">
                        <div class="nav-item" style="padding: 16px;"><i class="fas fa-user-plus" style="margin-right: 4px;"></i>Cadastro Geral
                        </div>
                    </li></a>

                    @endauth
                </ul>
                {{-- <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div> --}}
            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle mr-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                    <form class="form-inline d-none d-sm-inline-block mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" method="POST" action="{{url('search')}}">
                            <div class="input-group">
                                <input class="bg-light form-control border-0 small" type="text" placeholder="Search for ...">
                                <div class="input-group-append">
                                    <button class="btn btn-primary py-0" type="button"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                        <ul class="nav navbar-nav flex-nowrap ml-auto">
                            <li class="nav-item dropdown d-sm-none no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><i class="fas fa-search"></i></a>
                                <div class="dropdown-menu dropdown-menu-right p-3 animated--grow-in" role="menu" aria-labelledby="searchDropdown">
                                    <form class="form-inline mr-auto navbar-search w-100">
                                        <div class="input-group"><input class="bg-light form-control border-0 small" type="text" placeholder="Search for ...">
                                            <div class="input-group-append"><button class="btn btn-primary py-0" type="button"><i class="fas fa-search"></i></button></div>
                                        </div>
                                    </form>
                                </div>
                            </li>
                            <li class="nav-item dropdown no-arrow mx-1" role="presentation"></li>
                            <li class="nav-item dropdown no-arrow mx-1" role="presentation">
                                <div class="shadow dropdown-list dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown"></div>
                            </li>
                            <div class="d-none d-sm-block topbar-divider"></div>
                            @auth
                            <li class="nav-item dropdown no-arrow" role="presentation">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><span class="d-none d-lg-inline mr-2 text-gray-600 small">{{ Auth::user()->name }}</span><img class="border rounded-circle img-profile" src="{{ asset('img/user.PNG') }}"></a>
                                    <div
                                        class="dropdown-menu shadow dropdown-menu-right animated--grow-in" role="menu"><a class="dropdown-item" role="presentation" href="#"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Perfil</a><a class="dropdown-item" role="presentation" href="#"><i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Settings</a>
                                            <div class="dropdown-divider"></div><a class="dropdown-item" href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();">
                                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;{{ __('Logout') }}
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                            </form></div>
                    </div>
                    </li>
                    @endauth
                    </ul>
            </div>
            </nav>
            <div class="container-fluid">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            @yield('content')

            </div>
        </div>
    <footer class="bg-white sticky-footer align-bottom">
        <div class="container my-auto">
            <div class="text-center my-auto copyright"><span>Copyright © IbSystem 2020</span></div>
        </div>
    </footer>
    </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a></div>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="{{ asset('js/script.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('tableExport/libs/FileSaver/FileSaver.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('tableExport/libs/js-xlsx/xlsx.core.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('tableExport/libs/jsPDF/jspdf.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('tableExport/libs/jsPDF-AutoTable/jspdf.plugin.autotable.js') }}"></script>
    <script type="text/javascript" src="{{ asset('tableExport/tableExport.min.js') }}"></script>
    <!-- Entire bundle -->
    <script src="https://cdn.jsdelivr.net/npm/@shopify/draggable@1.0.0-beta.6/lib/draggable.bundle.js"></script>
    <!-- legacy bundle for older browsers (IE11) -->
    <script src="https://cdn.jsdelivr.net/npm/@shopify/draggable@1.0.0-beta.6/lib/draggable.bundle.legacy.js"></script>
    <!-- Draggable only -->
    <script src="https://cdn.jsdelivr.net/npm/@shopify/draggable@1.0.0-beta.6/lib/draggable.js"></script>
    <!-- Sortable only -->
    <script src="https://cdn.jsdelivr.net/npm/@shopify/draggable@1.0.0-beta.6/lib/sortable.js"></script>
    <!-- Droppable only -->
    <script src="https://cdn.jsdelivr.net/npm/@shopify/draggable@1.0.0-beta.6/lib/droppable.js"></script>
    <!-- Swappable only -->
    <script src="https://cdn.jsdelivr.net/npm/@shopify/draggable@1.0.0-beta.6/lib/swappable.js"></script>
    <!-- Plugins only -->
    <script src="https://cdn.jsdelivr.net/npm/@shopify/draggable@1.0.0-beta.6/lib/plugins.js"></script>

</body>

</html>
