<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:300,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #000000;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            div {
                padding: 5px 0;
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

            .button {
                background-color: #e7e7e7;
                color: black;
                border: none;
                padding: 15px 32px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .title2 {
                font-size: 42px;
            }

            .m-b-md {
                margin-bottom: 40px;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 22px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .row {
                display: table;
                width: 100%;
                table-layout: fixed;
                border-spacing: 10px;
            }

            .column {
                display: table-cell;
            }

            .right {
                text-align: right;
            }

            .left {
                text-align: left;
            }

            strong {
                font-weight: 600;
            }
        </style>
    </head>
    <body>
        <div class="@yield('custom_style')">
            <div class="content">

                @yield('content')

            </div>
        </div>
    </body>
</html>


