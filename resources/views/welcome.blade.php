@extends('layouts.spa')

@section('added_css')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
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
                    <h1 class="cover-heading">Welcome To Etibe</h1>
                    <p class="lead">Etibe is a platform that provides a convenient way for individuals or groups to organize and manage personal or contributory savings.</p>
                    <p class="lead">
                        <a href="#" class="btn btn-lg btn-default">Learn more</a>
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