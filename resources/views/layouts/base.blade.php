<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <link href="/css/app.css" rel="stylesheet">
    </head>
    <body>

        <div id="wrapper">

            <!-- BEGIN Header -->
    		<div id="header">
                <navigation-bar></navigation-bar>
    		</div>
            <!-- END Header -->

            <!-- BEGIN Content -->
    		<div id="content">
                <div class="container">
                    <div class="col-md-12">
                        @yield('content')
                    </div>
                </div>
    		</div>
            <!-- END Content -->

            <!-- BEGIN Footer -->
    		<div id="footer">
    		</div>
            <!-- END Footer -->
        </div>
        @yield('vue')
        <script>
            window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
            ]) !!}
        </script>
        <script src="/js/app.js"></script>
    </body>
</html>
