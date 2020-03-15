@inject('globalsetting', 'App\Http\Controllers\IndexController')<!DOCTYPE html>
<html>

<head> <script>var my_company_id={{Auth::user()->my_company_id}}</script>
    <title>Chat</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/templatechat/main.css">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <script type="text/javascript" src="/default/assets/js/core/libraries/jquery.min.js"></script>


    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://www.gstatic.com/firebasejs/5.7.3/firebase.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
    <script>


        // Initialize Firebase
        var config = {
            apiKey: "AIzaSyBQJopEfdZ80Ws10WcoLipSAGnFWxNg-7U",
            authDomain: "neirosru-4e93b.firebaseapp.com",
            databaseURL: "https://neirosru-4e93b.firebaseio.com",
            projectId: "neirosru-4e93b",
            storageBucket: "neirosru-4e93b.appspot.com",
            messagingSenderId: "213062603545"
        };
        firebase.initializeApp(config);

        const messaging = firebase.messaging();


    </script>


</head>

<body>
@yield('content')

<script src="/templatechat/main.js"></script>
@yield('skriptdop')
<script  type="module"  src="/js/app.js"></script>
<script>$(document).ready(function() {
        $('.my_chat_site').select2();
    });</script>
</body>

</html>

{{--

<!DOCTYPE html>
<html lang="en">
<head> @inject('globalsetting', 'App\Http\Controllers\IndexController')
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Administration')</title>
    <script src="https://www.gstatic.com/firebasejs/5.4.0/firebase.js"></script>
    <script src="https://www.gstatic.com/firebasejs/5.4.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/5.4.0/firebase-messaging.js"></script>
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="/default/assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="/default/assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="/default/assets/css/core.css" rel="stylesheet" type="text/css">
    <link href="/default/assets/css/components.css" rel="stylesheet" type="text/css">
    <link href="/default/assets/css/colors.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    --}}
{{-- <script type="text/javascript" src="/default/assets/js/plugins/loaders/pace.min.js"></script>--}}{{--

    <script type="text/javascript" src="/default/assets/js/core/libraries/jquery.min.js"></script>
    <script type="text/javascript" src="/default/assets/js/core/libraries/bootstrap.min.js"></script>
    <script type="text/javascript" src="/default/assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script type="text/javascript" src="/default/assets/js/plugins/visualization/d3/d3.min.js"></script>
    <script type="text/javascript" src="/default/assets/js/plugins/visualization/d3/d3_tooltip.js"></script>
    --}}
{{--<script type="text/javascript" src="/default/assets/js/plugins/forms/styling/switchery.min.js"></script>--}}{{--

    <script type="text/javascript" src="/default/assets/js/plugins/forms/styling/uniform.min.js"></script>
    <script type="text/javascript" src="/default/assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
    <script type="text/javascript" src="/default/assets/js/plugins/ui/moment/moment.min.js"></script>
    <script type="text/javascript" src="/default/assets/js/plugins/pickers/daterangepicker.js"></script>

    <script type="text/javascript" src="/default/assets/js/core/app.js"></script>

    <!-- /theme JS files -->

    <script type="text/javascript" src="/default/assets/js/core/libraries/jquery_ui/interactions.min.js"></script>
    <script type="text/javascript" src="/default/assets/js/core/libraries/jquery_ui/touch.min.js"></script>


    <script type="text/javascript" src="/default/assets/js/plugins/forms/tags/tagsinput.min.js"></script>
    <script type="text/javascript" src="/default/assets/js/plugins/forms/tags/tokenfield.min.js"></script>
    <script type="text/javascript" src="/default/assets/js/pages/form_tags_input.js"></script>


    --}}
{{--    <script type="text/javascript" src="/default/assets/js/plugins/forms/styling/switchery.min.js"></script>--}}{{--

    <script type="text/javascript" src="/default/assets/js/plugins/forms/styling/switch.min.js"></script>
    --}}
{{-- <script type="text/javascript" src="/default/assets/js/pages/appearance_draggable_panels.js"></script>--}}{{--

    <script type="text/javascript" src="/default/assets/js/plugins/notifications/jgrowl.min.js"></script>
    --}}
{{-- <script type="text/javascript" src="/default/assets/js/pages/form_checkboxes_radios.js"></script>--}}{{--


    @yield('newjs', '')
</head>
<body class="pace-done">

<!-- Main navbar -->
<div class="navbar navbar-default header-highlight">
    <div class="navbar-header">
        <a class="navbar-brand" href="/">--}}
{{--<img src="/default/assets/images/logo_light.png" alt="">--}}{{--
</a>

        <ul class="nav navbar-nav visible-xs-block">
            <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
            <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
        </ul>
    </div>

    <div class="navbar-collapse collapse" id="navbar-mobile">
        <ul class="nav navbar-nav">
            <li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="icon-git-compare"></i>
                    <span class="visible-xs-inline-block position-right">Git updates</span>
                    <span class="badge bg-warning-400">9</span>
                </a>

                <div class="dropdown-menu dropdown-content">
                    <div class="dropdown-content-heading">
                        Git updates
                        <ul class="icons-list">
                            <li><a href="#"><i class="icon-sync"></i></a></li>
                        </ul>
                    </div>

                    <ul class="media-list dropdown-content-body width-350">
                        <li class="media">
                            <div class="media-left">
                                <a href="#" class="btn border-primary text-primary btn-flat btn-rounded btn-icon btn-sm"><i class="icon-git-pull-request"></i></a>
                            </div>

                            <div class="media-body">
                                Drop the IE <a href="#">specific hacks</a> for temporal inputs
                                <div class="media-annotation">4 minutes ago</div>
                            </div>
                        </li>








                    </ul>

                    <div class="dropdown-content-footer">
                        <a href="#" data-popup="tooltip" title="All activity"><i class="icon-menu display-block"></i></a>
                    </div>
                </div>
            </li>
        </ul>

        <p class="navbar-text"><span class="label bg-success">Online</span></p>
        <p class="navbar-text"><a href="/logout"> <span class="label bg-danger">Logout</span></a></p>
        <p class="navbar-text">
            @if(count($globalsetting->get_sites())>1)
                <select id="selectsite" onchange="selsites()">
                    <option value="0" @if(DB::table('users')->where('id',Auth::user()->id)->first()->site==0) selected @endif >Все сайты</option>
                    @foreach($globalsetting->get_sites() as $allsites)
                        <option value="{{$allsites->id}}" @if(DB::table('users')->where('id',Auth::user()->id)->first()->site==$allsites->id) selected @endif>{{$allsites->name}}</option>
                    @endforeach
                </select>
            @endif
        </p>


        <ul class="nav navbar-nav navbar-right">


            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="icon-bubbles4"></i>
                    <span class="visible-xs-inline-block position-right">Messages</span>
                    <span class="badge bg-warning-400">2</span>
                </a>

                <div class="dropdown-menu dropdown-content width-350">
                    <div class="dropdown-content-heading">
                        Messages
                        <ul class="icons-list">
                            <li><a href="#"><i class="icon-compose"></i></a></li>
                        </ul>
                    </div>

                    <ul class="media-list dropdown-content-body">
                        <li class="media">
                            <div class="media-left">
                                <img src="/default/assets/images/placeholder.jpg" class="img-circle img-sm" alt="">
                                <span class="badge bg-danger-400 media-badge">5</span>
                            </div>

                            <div class="media-body">
                                <a href="#" class="media-heading">
                                    <span class="text-semibold">James Alexander</span>
                                    <span class="media-annotation pull-right">04:58</span>
                                </a>

                                <span class="text-muted">who knows, maybe that would be the best thing for me...</span>
                            </div>
                        </li>








                    </ul>

                    <div class="dropdown-content-footer">
                        <a href="#" data-popup="tooltip" title="All messages"><i class="icon-menu display-block"></i></a>
                    </div>
                </div>
            </li>

            <li class="dropdown dropdown-user">
                <a class="dropdown-toggle" data-toggle="dropdown">
                    <img src="/default/assets/images/placeholder.jpg" alt="">
                    <span>{{Auth::user()->name}}</span>
                    <i class="caret"></i>
                </a>

                --}}
{{--<ul class="dropdown-menu dropdown-menu-right">
                    <li><a href="#"><i class="icon-user-plus"></i> My profile</a></li>
                    <li><a href="#"><i class="icon-coins"></i> My balance</a></li>
                    <li><a href="#"><span class="badge bg-teal-400 pull-right">58</span> <i class="icon-comment-discussion"></i> Messages</a></li>
                    <li class="divider"></li>
                    <li><a href="#"><i class="icon-cog5"></i> Account settings</a></li>
                    <li><a href="#"><i class="icon-switch2"></i> Logout</a></li>
                </ul>--}}{{--

            </li>
        </ul>
    </div>
</div>
<!-- /main navbar -->


<!-- Page container -->
<div class="page-container">

    <!-- Page content -->
    <div class="page-content">

        <!-- Main sidebar -->

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

</div><script type="text/javascript" src="https://vk.com/js/api/openapi.js?154"></script>

<!-- VK Widget -->
<script type="text/javascript" src="https://vk.com/js/api/openapi.js?154"></script>

--}}
{{--<!-- VK Widget -->
<div id="vk_community_messages"></div>
<script type="text/javascript">
    VK.Widgets.CommunityMessages("vk_community_messages", 153817342, {expanded: "1",tooltipButtonText: "Есть вопрос?"});
</script>--}}{{--

<!-- /page container -->
<script type="text/javascript" src="/js/myscript.js?{{time()}}"></script>
@yield('skriptdop', '')
</body>
</html>
--}}
