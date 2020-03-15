<!DOCTYPE html>
<html lang="en">
<head> @inject('globalsetting', 'App\Http\Controllers\IndexController')
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Limitless - Responsive Web Application Kit by Eugene Kopyov</title>

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
    <script src="/js/app.js"></script>

    <script src="/global_assets/js/plugins/ui/ripple.min.js"></script>
    <script src="/global_assets/js/plugins/notifications/pnotify.min.js"></script>
    <!-- /theme JS files -->


    <script src="https://use.fontawesome.com/7c8f9239c1.js"></script>


    {{--    <script type="text/javascript" src="/default/assets/js/plugins/forms/styling/switchery.min.js"></script>--}}
    <script type="text/javascript" src="/default/assets/js/plugins/forms/styling/switch.min.js"></script>
    {{-- <script type="text/javascript" src="/default/assets/js/pages/appearance_draggable_panels.js"></script>--}}
    <script type="text/javascript" src="/default/assets/js/plugins/notifications/jgrowl.min.js"></script>
    @yield('newjs', '')
</head>
{{--<a href="
viber://pa?chatURI=wististest&context=text2">Вибер</a>
<body class="pace-done">--}}
<body class="sidebar-secondary-hidden pace-done has-detached-right sidebar-xs">
{{--sidebar-xs  --}}


@include('main_navbar')


<!-- /main navbar -->


<!-- Page container -->
<div class="page-container">

    <!-- Page content -->
    <div class="page-content ">

        <!-- Main sidebar -->
        <div class="sidebar sidebar-main">
            <div class="sidebar-content">


                <!-- /user menu -->


                <!-- Main navigation -->
            @include('phscript.menu')
            <!-- /main navigation -->

            </div>
        </div>
        @include('phscript.secondary_sitebar')
        <!-- /main sidebar -->


        <!-- Main content -->
        <div class="content-wrapper">
            <!-- Content area -->
            <div class="content">

            @yield('content')

            <!-- Footer -->
                <div class="footer text-muted">

                </div>
                <!-- /footer -->

            </div>
            <!-- /content area -->
        </div>
        <!-- /main content -->

  
    </div>
    <!-- /page content -->

</div>@yield('my_modal' )
<script type="text/javascript" src="https://vk.com/js/api/openapi.js?154"></script>

<!-- VK Widget -->
<script type="text/javascript" src="https://vk.com/js/api/openapi.js?154"></script>

{{--<!-- VK Widget -->
<div id="vk_community_messages"></div>
<script type="text/javascript">
    VK.Widgets.CommunityMessages("vk_community_messages", 153817342, {expanded: "1",tooltipButtonText: "Есть вопрос?"});
</script>--}}
<!-- /page container -->
<script type="text/javascript" src="/js/myscript.js?{{time()}}"></script>
@yield('skriptdop', '')

@yield('skript_callstat', '')
</body>
</html>
