<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>{{config('laikacms.default.cmsname.long')}}</title>


        @include('laikacms::layouts._head')
        <meta name="_token" content="{{ csrf_token() }}" />


    </head>
    <body class="fixed-sidebar minibar">
        <div id="wrapper">
            <nav class="navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="nav-header">
                            <div class="dropdown profile-element"> <span>
                                    <h1 style="color: whitesmoke"><a href="/{{$cmsprefix}}/">{{nl2br(config('laikacms.default.cmsname.long'))}}</a></h1>
                                </span>

                                <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                    <!--<li><a href="profile.html">Profile</a></li>
                                    <li><a href="contacts.html">Contacts</a></li>
                                    <li><a href="mailbox.html">Mailbox</a></li>
                                    <li class="divider"></li> -->
                                    <li><a href="/{{$cmsprefix}}/logout">Logout</a></li>
                                </ul>
                            </div>
                            <div class="logo-element">
                                <a href="/{{$cmsprefix}}/">{{config('laikacms.default.cmsname.short')}}</a>
                            </div>
                        </li>
                        @if(in_array('cms', $coremodules))
                        <li @if($current_module == "cms") class="active" @endif><a href="/{{$cmsprefix}}/cms/pages" title="Seiten"><i class="fa fa-file-text"></i><span class="nav-label">Seiten</span></a></li>
                        @endif
                        @if(in_array('content', $coremodules))
                        <li @if($current_module == "content") class="active" @endif><a href="/{{$cmsprefix}}/cms/content" title="Phrasen"><i class="fa fa-pencil-square-o"></i><span class="nav-label">Phrasen</span></a></li>
                        @endif
                        @if(in_array('user', $coremodules))
                        <li @if($current_module == "user") class="active" @endif><a href="/{{$cmsprefix}}/user/" title="User"><i class="fa fa-user"></i><span class="nav-label">User</span></a></li>
                        @endif
                        <!--<li><a href="/{{$cmsprefix}}/seminare/"><i class="fa fa-th-large"></i><span class="nav-label">Seminarverwaltung</span></a></li>-->
                        @foreach($module_defintion as $bModule)
                        @if (isset($bModule->actions))
                        @foreach($bModule->actions as $mAction)
                        <li @if($current_module == $bModule->module) class="active" @endif>
                             <a href="#" title="{{$mAction->label}}">
                                <i class="fa {{$mAction->icon}}"></i>
                                <span class="nav-label">{{$mAction->label}}</span>@if(isset($mAction->subs)) <span class="fa arrow"></span> @endif</a>
                            @if(isset($mAction->subs))
                            <ul class="nav nav-second-level collapse" style="" aria-expanded="false">

                            @foreach($mAction->subs as $sAction)
                                <li class="active">
                                    <a href="/{{$cmsprefix}}/{{$sAction->route}}"><i class="fa {{$sAction->icon}}"></i><span class="nav-label">{{$sAction->label}}</span></a>
                                </li>
                            @endforeach
                                                             </ul>
                            @endif
                        </li>
                        @endforeach
                        @endif
                        @endforeach
                        @if(in_array('assets', $coremodules))
                        <li @if($current_module == "assets") class="active" @endif><a href="/{{$cmsprefix}}/assets/folder/1" title="Dateien"><i class="fa fa-image-o"></i><span class="nav-label">Dateimanager</span></a></li>
                        @endif
                        <li> <a href="/{{$cmsprefix}}/logout">
                                <i class="fa fa-sign-out"></i> <span class="nav-label">Abmelden</span>
                            </a></li>
                    </ul>
                </div>
            </nav>
            <div id="page-wrapper" class="gray-bg dashbard-1">
                <div class="row border-bottom">
                    <nav class="navbar navbar-static-top white-bg" role="navigation" style="">
                        <div class="navbar-header">
                            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                            <form role="search" class="navbar-form-custom" method="get" action="javascript:void(0)">
                                <div class="form-group">
                                    <input type="text" placeholder="Suche etwas ..." class="form-control" name="query" id="top-search">
                                </div>
                            </form>
                        </div>


                        <ul class="nav navbar-top-links navbar-right" style="">
                            @yield('action-nav')
                            <li>
                                <a data-toggle="modal" class="clear-cache"><i class="fa fa-server"></i> Cache löschen</a>
                            </li>

                            <li>
                                <a href="/{{$cmsprefix}}/logout">
                                    <i class="fa fa-sign-out"></i> Log out
                                </a>
                            </li>
                        </ul>

                    </nav>
                </div>
                <div class="row  border-bottom" style="margin-top: 60px; margin-left:30px; width: 97%; position: relative; height: 100%;">
                    
                    @yield('content')
                </div>
                <div class="footer">
                    <div class="pull-right">
                        {{config('laikacms.default.version')}}
                    </div>
                    <div>
                        {{config('laikacms.default.copyright')}}
                    </div>
                </div>

            </div>

        </div>

        <!-- /container -->    



        <script>
// Fixed Sidebar
// unComment this only whe you have a fixed-sidebar
            $(window).bind("load", function () {
                if ($("body").hasClass('fixed-sidebar')) {
                    $('.sidebar-collapse').slimScroll({
                        height: '100%',
                        railOpacity: 0.9,
                    });
                }

                $('a.navbar-minimalize').bind('click', function () {
                    if ($('body').hasClass('mini-navbar')) {
                        $.cookie("showminibar", "true", {path: '/{{$cmsprefix}}'});
                    } else {
                        $.cookie("showminibar", "false", {path: '/{{$cmsprefix}}'});
                    }
                })

                if ($.cookie("showminibar") === "true") {
                    $('body').addClass('mini-navbar')
                }
                 @if (Session::has('message')) Jbkcms.UI.sendNotification("{{ Session::get('message') }}"); @endif
                


            })
        </script>
        <style>
            .dataTables_filter{
                width: auto;
                display: inline-block;
            }

            .dataTables_length{
                width: auto;
                display:inline-block;
                float:right;
                margin-right: 20px;
            }

            .header-alert{
                margin:0px;
            }

            .navbar-top-links li a {
                min-height: 50px;
                padding: 20px 10px 10px;
            }

            body.fixed-sidebar.mini-navbar #page-wrapper {
                margin: 0 0 0 70px;
            }

            body.fixed-sidebar.mini-navbar .navbar-static-side {
                width: 70px;
            }

            body.fixed-sidebar.mini-navbar .navbar-static-side {
                width: 70px;
            }

            body.fixed-sidebar.mini-navbar .nav-label, 
            body.fixed-sidebar.mini-navbar .navbar-default .nav li a span {
                display: none;
            }

            body.fixed-sidebar.mini-navbar .navbar-static-side .nav-label, 
            body.fixed-sidebar.mini-navbar .navbar-static-side .navbar-default .nav li a span, 
            body.fixed-sidebar.mini-navbar .navbar-static-side .profile-element, 
            body.fixed-sidebar.mini-navbar .navbar-static-side .nav-second-level {
                display: none;
            }

            body.fixed-sidebar.mini-navbar .navbar-static-side .fa{
                font-size: 20px;
            }
            body.fixed-sidebar .border-bottom .navbar-static-top{
                margin-bottom: 0px; 
                position: fixed; 
                width: 100%;
            }

            body.fixed-sidebar .border-bottom .navbar-static-top .navbar-top-links{
                margin-right: 220px;
            }

            body.fixed-sidebar.mini-navbar .border-bottom .navbar-static-top{
                margin-bottom: 0;
                position: fixed;
                width: 100%;
            }

            body.fixed-sidebar.mini-navbar .border-bottom .navbar-static-top .navbar-top-links{
                margin-right: 70px;
            }

            body.fixed-sidebar.mini-navbar .pace .pace-progress{
                left: 70px;
            }

            .nav.navbar-right > li > a {
                color:#444;
                height:54px;
                margin-top:2px;
                font-size: 12px;
            }

            .nav.navbar-right > li > a .fa{
                font-size: 15px;
            }

        </style>
    </body>
</html>
