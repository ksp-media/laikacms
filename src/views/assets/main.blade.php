@extends('laikacms::layouts.cms')
@section('action-nav')
<li>
<a href="/{{$cmsprefix}}/assets/folder/{{$folder->id}}/create?view={{$viewtype}}"><i class="fa fa-plus"></i> Neuer Ordner</a>
</li>
@stop
@section('mod-content')

@include('laikacms::assets._folderview')
@stop
