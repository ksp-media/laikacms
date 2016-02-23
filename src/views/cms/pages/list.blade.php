@extends('laikacms::layouts.pages')
@section('action-nav')
<li><a class="" href="/{{$cmsprefix}}/cms/page/create">+ Neue Seite</a></li>
@stop
@section('sub-sidebar')
<div class="sidebar sidebar-tree">
    <div class="btn-toolbar" role="toolbar">
        <div class="btn-group btn-group-xs" role="group" aria-label="...">
            <a href="/{{$cmsprefix}}/cms/page/create">+ Neue Seite</a>
        </div>
        <div class="btn-group btn-group-xs pull-right handler" role="group" aria-label="...">
            <a class="sidebar-handle"><i class="fa fa-angle-left"></i></a>
        </div>

    </div>
    <div class="dd sidebar-content" id="page-structure">
        {!! \KSPM\LCMS\Model\Page::htmlTree() !!}
    </div>
</div>
@endsection
@section('mod-content')

<script>
$(document).ready(function () {
   /** $('.dd-item').each(function(){
        $(this).append('<div class="dd-item-actions">\n\
<i class="fa fa-edit fa-lg item-edit"></i>&nbsp;\n\
<i class="fa fa-eye fa-lg item-preview"></i>\n\
<i class="fa fa-trash fa-lg item-trash"></i>\n\
</div>');
    }); 
    
    $('.item-edit').each(function(){$(this).click(function(){location.href = "/{{$cmsprefix}}/cms/page/"+$(this).parent().parent().attr('data-id')+"/edit"})})
    $('.item-trash').each(function(){$(this).click(function(){
            if(confirm('Wirklich?')){
                location.href = "/{{$cmsprefix}}/cms/page/"+$(this).parent().parent().attr('data-id')+"/delete";
            }
            
        })})**/
})
</script>
<style>

    body.DTTT_Print {
        background: #fff;

    }
    .DTTT_Print #page-wrapper {
        margin: 0;
        background:#fff;
    }

    button.DTTT_button, div.DTTT_button, a.DTTT_button {
        border: 1px solid #e7eaec;
        background: #fff;
        color: #676a6c;
        box-shadow: none;
        padding: 6px 8px;
    }
    button.DTTT_button:hover, div.DTTT_button:hover, a.DTTT_button:hover {
        border: 1px solid #d2d2d2;
        background: #fff;
        color: #676a6c;
        box-shadow: none;
        padding: 6px 8px;
    }

    .dataTables_filter label {
        margin-right: 5px;

    }
    
    .dd-item-actions{
        right: 10px;
        top: 5px;
        position: absolute;
    }
    
    .dd-item-actions i.fa{
        margin-left: 5px;
        cursor:pointer;
    }
</style>
@stop
