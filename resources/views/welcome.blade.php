<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Idabooks</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
        
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
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
                font-size: 84px;

            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            #mainImage {
                background-image: url("images/Trees_1920x1234.png");
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;

            }

            .info-box {
                font-size: 14px;
                text-align: center;
                margin-top: 60px;
                margin-bottom: 60px;
            }
        </style>
    </head>
    <body>
        <div id="mainImage" class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/customers') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}?customer=1">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="row">
                <div class="content">
                    <div class="title m-b-md">
                        Idabooks
                    </div>
                    <small>Order items from from you local stores online.</small>
                </div>
            </div>

        </div>
                   
        <div class="row">

            <div class="col-md-12 info-box">
                <h3>Are you a company? Register <a href="/business">here</a></h3>
            </div>
           
        </div>
        
    </body>
</html>
