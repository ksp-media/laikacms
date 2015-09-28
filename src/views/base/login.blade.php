<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>{{config('laikacms.default.cmsname.long')}}</title>

        <link href="/packages/kspm/laikacms/resources/admin/theme/vendor/bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="/packages/kspm/laikacms/resources/admin/theme/vendor/font-awesome-4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link href="/packages/kspm/laikacms/resources/admin/theme/vendor/animate.css" rel="stylesheet" type="text/css"/>
        <link href="/packages/kspm/laikacms/resources/admin/theme/default/css/main.css" rel="stylesheet" type="text/css"/>


    </head>


    <body class="gray-bg login-screen" style="background-image: url({{config('laikacms.default.loginbackground')}});">

        <div class="middle-box text-center loginscreen  animated fadeInDown">
            <div>
                <div class="row">
                    <div class="col-md-4">
                        <div>

                            <h1 class="logo-name">{{config('laikacms.default.cmsname.long')}}</h1>

                        </div>
                        <h3>Welcome ... </h3>
                        <p>Login in. To see it in action.</p>
                    </div>
                    <div class="col-md-8">
                        <br />
                        <form class="m-t" role="form" method="POST" action="/{{$cmsprefix}}/login">
                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                            <div class="form-group">
                                <input type="email" class="form-control" placeholder="E-Mail Adresse" name="user[email]" required="">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="Kennwort" name="user[password]" required="">
                            </div>
                            <button type="submit" class="btn btn-primary block full-width m-b">Login</button>
                            @if (Session::has('message'))
                            <div class="inline alert alert-success">{{ Session::get('message') }}</div>
                            @endif 
                                        <!--<a href="#"><small>Forgot password?</small></a>
                                        <p class="text-muted text-center"><small>Do not have an account?</small></p>
                                        <a class="btn btn-sm btn-white btn-block" href="register.html">Create an account</a> -->
                        </form>
                       
                    </div>
                </div>
            </div>
             <p class="m-t pull-right logincopy"> <small>{{config('laikacms.default.version')}} - {{config('laikacms.default.copyright')}}</small> </p>
        </div>

        <!-- Mainly scripts -->
        <script src="/packages/kspm/laikacms/resources/admin/theme/vendor/jquery-1.11.3.min.js" type="text/javascript"></script>
        <script src="/packages/kspm/laikacms/resources/admin/theme/vendor/bootstrap-3.3.5-dist/js/bootstrap.min.js" type="text/javascript"></script>

    </body>
</html>
