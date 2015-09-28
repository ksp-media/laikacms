@extends('laikacms::layouts.seminar')
@section('action-nav')
<a class="btn btn-sm btn-toolbar pull-right" href="/{{$cmsprefix}}/seminar/create">+ Neues Seminar</a>
 @if (Session::has('message'))
        <div class="inline alert alert-success">{{ Session::get('message') }}</div>
    @endif 
@stop
@section('mod-content')
<h1>seminar liste</h1>
 <table class="table table-bordered table-hover">
     <tr>
         <th>#</th>
         <th>Titel</th>
         <th></th>
     </tr>
        @foreach ($seminare as $seminar)
        <tr>
            <td>{{$seminar->id}}</td>
            <td>{{$seminar->title}}</td>
            <td><a href="/{{$cmsprefix}}/seminar/{{$seminar->id}}/edit" class="btn btn-sm btn-default">bearbeiten</a></td>

        </tr>
        @endforeach
</table>
@stop
