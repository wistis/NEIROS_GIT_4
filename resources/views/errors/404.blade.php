<!DOCTYPE html>
<html lang="en">
<head>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script  type="module"  src="/js/app.js"></script>


    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Neiros - @yield('title')</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="/global_assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="/default/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">

    <link href="/default/assets/css/core.min.css" rel="stylesheet" type="text/css">
    <link href="/default/assets/css/components.min.css" rel="stylesheet" type="text/css">
    <link href="/default/assets/css/colors.min.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->
    <link href="/global_assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="/global_assets/css/icons/material/icons.css" rel="stylesheet" type="text/css">
    <!-- Core JS files -->
    <script src="/global_assets/js/core/libraries/jquery.min.js"></script>
    <script src="/global_assets/js/core/libraries/bootstrap.min.js"></script>
    <!-- /core JS files -->
    <script src="/global_assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- Theme JS files -->
    <script src="/js/app__1.js"></script>


    {{-- <script src="/global_assets/js/plugins/ui/ripple.min.js"></script>--}}
    <script src="/global_assets/js/plugins/notifications/pnotify.min.js"></script>
    <!-- /theme JS files -->


    <script src="https://use.fontawesome.com/7c8f9239c1.js"></script>


    {{--    <script type="text/javascript" src="/default/assets/js/plugins/forms/styling/switchery.min.js"></script>--}}
    <script type="text/javascript" src="/default/assets/js/plugins/forms/styling/switch.min.js"></script>
    {{-- <script type="text/javascript" src="/default/assets/js/pages/appearance_draggable_panels.js"></script>--}}
    <script type="text/javascript" src="/default/assets/js/plugins/notifications/jgrowl.min.js"></script>

</head>

<body class="login-container">

<!-- Main navbar -->
<div class="navbar  ">
    <div class="navbar-header">
        <a class="navbar-brand" href="/"><img src="https://cloud.neiros.ru/Neiros.png" alt=""></a>

        <ul class="nav navbar-nav pull-right visible-xs-block">
            <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
        </ul>
    </div>

    <div class="navbar-collapse collapse" id="navbar-mobile">



    </div>
</div>
<!-- /main navbar -->


<!-- Page container -->
<div class="page-container">

    <!-- Page content -->
    <div class="page-content">

        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Content area -->
            <div class="content">

                <!-- Error title -->
                <div class="text-center content-group">
                    <h1 class="error-title">404</h1>
                    <h5>Страница не существует</h5>
                </div>
                <!-- /error title -->


                <!-- Error content -->
                <div class="row">
                    <div class="col-lg-4 col-lg-offset-4 col-sm-6 col-sm-offset-3">
                        <form action="#" class="main-search">


                            <div class="row">
                                <div class="col-sm-6">
                                    <a href="/" class="btn btn-primary btn-block content-group"><i class="icon-circle-left2 position-left"></i></a>
                                </div>

                                <div class="col-sm-6">
                                {{--    <a href="#" class="btn btn-default btn-block content-group"><i class="icon-menu7 position-left"></i> Advanced search</a>--}}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /error wrapper -->


                <!-- Footer -->
                <div class="footer text-muted text-center">
                    &copy; 2018-{{date("Y")}}. <a href="https://neiros.ru">Neiros</a>
                </div>
                <!-- /footer -->

            </div>
            <!-- /content area -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

</div>
<!-- /page container -->

</body>
</html>
