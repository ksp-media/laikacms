@extends('laikacms::layouts.default')

@section('content')
<div class="row">
    <div class="col-md-2">
        <div class="ui-right bs-docs-sidebar hidden-print hidden-xs hidden-sm affix">
        <ul class="nav nav-pills nav-stacked">
            <li><input type="text" name="search_seminar" placeholder="seminar suchen" class="form-control search-form"></li>
            <li><a href="/{{$cmsprefix}}/seminare">Seminare</a></li>
            <li> <a href="/{{$cmsprefix}}/category">Kategorien</a></li>
        </ul>
        </div>
    </div>
    <div class="col-md-10">
        <nav class="subnav">
        @yield('action-nav')
        </nav>
         @yield('mod-content')
    </div>
</div>

@stop