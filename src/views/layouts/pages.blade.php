@extends('laikacms::layouts.default')

@section('content')


<div class="wrapper wrapper-content">
    @yield('sub-sidebar')
    <div class="row">
       
        <div class="col-lg-12 animated fadeInRight">
            <div class="mail-box">
                @yield('mod-content')
            </div>

        </div>
    </div>
</div>

@stop