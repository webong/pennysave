<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery-ui.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery-ui.structure.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery-ui.theme.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sweet-alert.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    @yield('added_css')

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="@if(Auth::check()){{ route('main-dashboard') }}@else{{ url('/') }}@endif">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" id="dLabel" class="dropdown-toggle" role="button" data-toggle="dropdown">
                                    <span class="text-info fa fa-bell"></span>
                                    <span class="badge info margin-left-sm padding-bottom-mmd"></span>
                                </a>
                                <ul class="dropdown-menu notifications" role="menu" aria-labelledby="dLabel">
                                    <div class="notification-heading">
                                        <h4 class="menu-title dLabel">Notifications</h4>
                                        <h4 class="menu-title pull-right">View all
                                            <i class="fa fa-arrow-circle-right margin-left-sm"></i>
                                        </h4>
                                    </div>
                                    <div class="notifications-wrapper">
                                        <a class="content view-notification" href="#">
                                            <div class="notification-item">
                                                <h4 class="item-title">Evaluation Deadline  <small> 1 day ago</small></h4>
                                                <p class="item-info">Mr hassan has followed you!</p>
                                            </div>  
                                        </a>
                                    </div>
                                    <div class="notifications-wrapper">
                                        <a class="content view-notification" href="#">
                                            <div class="notification-item">
                                                <h4 class="item-title">Evaluation Deadline  <small> 1 day ago</small></h4>
                                                <p class="item-info">Mr hassan has followed you!</p>
                                            </div>  
                                        </a>
                                    </div>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" id="dLabel" class="dropdown-toggle" role="button" data-toggle="dropdown">
                                    <span class="text-info fa fa-envelope"></span>
                                    <span class="badge info margin-left-sm padding-bottom-mmd">3</span>
                                </a>
                                <ul class="dropdown-menu notifications" role="menu" aria-labelledby="dLabel">
                                    <div class="notification-heading">
                                        <h4 class="menu-title dLabel">Messages</h4>
                                        <a href="@if(isset($team_id)){{ url('/teams/' . $team_id . '/messages') }}
                                                @else{{ url('/teams/' . $team->id . '/messages') }}@endif">
                                            <h4 class="menu-title pull-right">View all
                                                <i class="fa fa-arrow-circle-right margin-left-sm"></i>
                                            </h4>
                                        </a>
                                    </div> 
                                    <div class="notifications-wrapper">
                                        <a class="content view-message" href="#">
                                            <div class="notification-item">
                                                <h4 class="item-title">Evaluation Deadline  <small> 1 day ago</small></h4>
                                                <p class="item-info">Mr hassan has followed you!</p>
                                            </div>  
                                        </a>
                                    </div>
                                    <div class="notifications-wrapper">
                                        <a class="content view-message" href="#">
                                            <div class="notification-item">
                                                <h4 class="item-title">Evaluation Deadline  <small> 1 day ago</small></h4>
                                                <p class="item-info">Mr hassan has followed you!</p>
                                            </div>  
                                        </a>
                                    </div>
                                </ul>
                            </li>
                            <li class="dropdown user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    <img src="{{ asset(urldecode(Auth::user()->avatar)) }}" class="user-image" alt="User Image"> <span class="hidden-xs">{{ Auth::user()->first_name }}</span> <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                  <!-- User image -->
                                  <li class="user-header">
                                      <a href="/profile">
                                        <img src="{{ asset(urldecode(Auth::user()->avatar)) }}" class="img-circle img-header" alt="User Image">
                                        <p class="text-center margin-top-sm">
                                            {{ Auth::user()->full_name() }}
                                        </p>
                                      </a>
                                  </li>
                                  <!-- Menu Footer-->
                                  <li class="user-footer">
                                    <div class="list-group">
                                      <a href="{{ url('/settings') }}" class="list-group-item"><i class="fa fa-fw fa-cog"></i> Settings</a>
                                      <a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="list-group-item">
                                      <i class="fa fa-fw fa-power-off"></i> Log Out</a>
                                  </div>
                                      <div class="pull-right">

                                      </div>
                                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                          {{ csrf_field() }}
                                      </form>
                                  </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">

            @include('partials._notices')

            @yield('content')

        </div>

        @include('partials._footer')

    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/modernizr-custom.js') }}"></script>
    <script src="{{ asset('js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/sweet-alert.min.js') }}"></script>
    <script type="text/javascript">
        $( document ).tooltip();

        // DataPicker for Date Input types
        if (!Modernizr.touch || !Modernizr.inputtypes.date) {
            $('input[type=date].date').datepicker({
                // Consistent format with the HTML5 picker
                minDate: 0,
                dateFormat: 'yy-mm-dd',
                numberOfMonths: 2
            });
            $('input[type=date].date-single').datepicker({
                // Consistent format with the HTML5 picker
                minDate: 0,
                dateFormat: 'yy-mm-dd'
            });
        }
    </script>
    <script src="{{ asset('js/custom.js') }}"></script>
    @yield('added_js')
</body>
</html>
