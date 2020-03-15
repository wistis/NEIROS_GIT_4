<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Neiros</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="/default/assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="/default/assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="/default/assets/css/core.css" rel="stylesheet" type="text/css">
    <link href="/default/assets/css/components.css" rel="stylesheet" type="text/css">
    <link href="/default/assets/css/colors.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script type="text/javascript" src="/default/assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="/default/assets/js/core/libraries/jquery.min.js"></script>
    <script type="text/javascript" src="/default/assets/js/core/libraries/bootstrap.min.js"></script>
    <script type="text/javascript" src="/default/assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->
    <script type="text/javascript" src="/vendor/jqmask/dist/jquery.mask.min.js"></script>

    <!-- Theme JS files -->
    <script type="text/javascript" src="/default/assets/js/core/app.js"></script>
    <!-- /theme JS files -->

</head>

<body class="login-container">

<!-- Main navbar -->

<!-- /main navbar -->


<!-- Page container -->
<div class="page-container">

    <!-- Page content -->
    <div class="page-content">

        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Content area -->
            <div class="content">

                <!-- Simple login form -->
            @yield('content')
            <!-- /simple login form -->


                <!-- Footer -->
                <div class="footer text-muted text-center">
                    &copy; 2015. <a href="https://neiros.ru">Neiros</a> 
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


