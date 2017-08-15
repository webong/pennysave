@extends('layouts.spa')

@section('added_css')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.min.css') }}">
@endsection

@section('content')

    <div class="site-wrapper">
        <div class="site-wrapper-inner">
            <div class="cover-container">
                <div class="masthead clearfix">
                    <div class="inner">
                        <h3 class="masthead-brand">Etibe.NG</h3>
                        <nav>

                            @if (Route::has('login'))
                                <ul class="nav masthead-nav">
                                    @if (Auth::check())
                                        <li><a href="{{ route('main-dashboard') }}"> Dashboard</a></li>
                                    @else
                                        <li><a href="{{ url('/login') }}">Login</a></li>
                                        <li><a href="{{ url('/register') }}">Register</a></li>
                                    @endif
                                </ul>
                            @endif
                        </nav>
                    </div>
                </div>
                <div class="inner cover">
                    <h1 class="cover-heading">Welcome To 
                        <span class="flip flip1">
                            <span class="animated flipInY">Etibe</span>
                            <span>Etibe - <b>Ibibio</b></span>
                            <span>Akawo - <b>Igbo</b></span>
                            <span>Osusu - <b>Igbo</b></span>
                            <span>Ajo - <b>Yoruba</b></span>
                            <span>Okaligbo - <b>Delta</b></span>
                            <span>Susu - <b>Afro-Carribean</b></span>
                            <span>Jojuma - <b>Togo</b></span>
                            <span>Nago - <b>Ivory Coast</b></span>
                            <span>Esu - <b>Bahamas</b></span>
                            <span>Esusu - <b>Unknown</b></span>
                            <span>Onidara - <b>Unknown</b></span>
                            <span>Adashe - <b>Unknown</b></span>
                            <span>Chama - <b>Unknown</b></span>
                            <span>Cundinas - <b>Unknown</b></span>
                        </span>
                    </h1>
                    <p class="lead">Etibe is a platform that provides a convenient way for individuals or groups to organize and manage personal or contributory savings.</p>
                    <!--<p class="lead" id="etibeLanguages"></p>-->
                    <p class="lead">
                        <a href="{{ url('/about') }}" class="btn btn-lg btn-default">Learn more</a>
                    </p>
                </div>
                <div class="mastfoot">
                    <div class="inner">
                        <p>
                            <span class="footer-info">
                                &copy; {{ date('Y') }} <a href="{{ url('/') }}">Etibe.NG.</a> All Rights Reserved.
                            </span>
                            <span class="footer-social">
                                <a href="https://www.facebook.com/etibeNG"><i class="fa fa-facebook"></i></a>
                                <a href="https://www.twitter.com/etibeNG"><i class="fa fa-twitter"></i></a>
                                <a href="https://www.instagram.com/etibeNG"><i class="fa fa-instagram"></i></a>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('added_js')
    <script src="{{ asset('js/typeit.min.js') }}"></script>
    <script>
        $(function() {
            setInterval(function()  { 
                var active = $(".flip1 .animated.flipInY").removeClass('animated flipInY'); 
                if (active.next() && active.next().length) { active.next().addClass('animated flipInY'); } else { active.siblings(":first").addClass('animated flipInY'); }
            }, 5000);

            $('#etibeLanguages').typeIt({
                strings: [
                    "Etibe - <b>Ibibio</b>",
                    "Akawo - <b>Igbo</b>",
                    "Osusu - <b>Igbo</b>",
                    "Ajo - <b>Yoruba</b>",
                    "Okaligbo - <b>Delta</b>",
                    "Susu - <b>Afro-Carribean</b>",
                    "Jojuma - <b>Togo</b>",
                    "Nago - <b>Ivory Coast</b>",
                    "Esu - <b>Bahamas</b>",
                    "Esusu - <b>Unknown</b>",
                    "Onidara - <b>Unknown</b>",
                    "Adashe - <b>Unknown</b>",
                    "Chama - <b>Unknown</b>",
                    "Cundinas - <b>Unknown</b>",
                ],
                speed: 250,
                breakLines: false,
                loop: true,
                startDelete: true,
                deleteSpeed: 100,
                deleteDelay: 250
            });
        });
    </script>
@endsection
