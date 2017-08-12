<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Etibe NG</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">

        @yield('added_css')

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 80vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .half-height {
                height: 35vh;
            }

            .quarter-height {
                height: 20vh;
            }

            .push-down {
                padding-top: 15vh;
                font-size:70px;
            }

            .fa {
                opacity: 0.2;
                filter: alpha(opacity=20);
                z-index: -10;
            }

            .more-padding {
                padding-top: 15vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 50px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            @media (max-width:767px) {
                .fa {
                    opacity: 0.1;
                    filter: alpha(opacity=10);
                    z-index: -10;
                }

                .push-down {
                    padding-top: 20vh;
                    font-size:45px;
                }

                .title {
                    font-size: 20px;
                }

                .btn-lg {
                    font-size:14px;
                }
            }
            .text-xxxl {
                font-size: 50px;
            }
        </style>
    </head>
    <body>

        @yield('content')

        @yield('added_js')
    
    </body>
</html>
