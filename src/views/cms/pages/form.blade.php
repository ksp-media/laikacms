@extends('laikacms::layouts.pages')
@section('action-nav')
<li><a href="/{{$cmsprefix}}/cms/page/create">+ Neue Seite</a></li>
<li><a data-toggle="modal" data-target="#versions-modal"><i class="fa fa-history"></i> Versionen</a></li>
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
<div class="sidebar sub-sidebar">
    <div class="btn-toolbar" role="toolbar">
        <div class="btn-group btn-group-xs pull-right handler" role="group" aria-label="...">
            <a class="sidebar-handle"><i class="fa fa-angle-left"></i></a>
        </div>

    </div>
    <div class="sidebar-content">
        <div class="panel panel-default panel-collapse">
            <div class="panel-heading"><i class="fa fa-info"></i> Informationen <i class="fa fa-plus pull-right co-toggle" role="button" data-toggle="collapse" data-target="#page-info" aria-expanded="false" aria-controls="page-info"></i></div> 
            <!-- List group -->
            <ul class="list-group collapse" id="page-info">
                <li class="list-group-item"><label class="label-block">Titel</label><span>{{$page->title}}</span></li>
                <li class="list-group-item"><label>erstellt am</label><span>{{$page->created_at}}</span></li>
                <li class="list-group-item"><label>geändert am</label> <span>{{$page->updated_at}}</span></li>
            </ul>

        </div>
        <div class="panel panel-collapse panel-default">
            <div class="panel-heading"><i class="fa fa-play"></i> Aktionen <i class="fa fa-minus pull-right co-toggle" role="button" data-toggle="collapse" data-target="#page-action" aria-expanded="false" aria-controls="page-action"></i></div>
            <div class="panel-body collapse in" id="page-action">

                <button class="btn btn-primary btn-block" id="btn-seminar-save" onclick="__submitForm($('#page-form'));"><i class="fa fa-save"></i> Speichern</button>
                <a target="_blank" class="btn btn-primary  btn-block" id="btn-seminar-preview" href="/{{$page->slug}}?preview"><i class="fa fa-eye"></i> Vorschau</a>
                <button class="btn btn-primary  btn-block" id="btn-seminar-release"><i class="fa fa-check"></i> Freigeben</button>
                <a class="btn btn-danger  btn-block" href="/{{$cmsprefix}}/cms/page/{{$page->id}}/delete" onclick="return confirm('Wirklich?');
                        return false"><i class="fa fa-trash"></i> Löschen</a>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-edit"></i> bearbeiten <i class="fa fa-minus pull-right co-toggle" role="button" data-toggle="collapse" data-target="#page-edit" aria-expanded="false" aria-controls="page-edit"></i></div>
            <div class="panel-body collapse in" id="page-edit">
                <ul class="nav nav-pills nav-stacked" role="tablist">
                    <li role="presentation"><a href="#options" aria-controls="options" role="tab" data-toggle="tab">Eigenschaften</a></li>
                    <li role="presentation" class="active"><a href="#content" aria-controls="content" role="tab" data-toggle="tab">Inhalt</a></li>
                    <li role="presentation"><a href="#seo" aria-controls="seo" role="tab" data-toggle="tab"> Meta Tags // SEO Stuff</a></li>
                    <li role="presentation"><a href="#template" aria-controls="template" role="tab" data-toggle="tab">Vorlage</a></li>
                </ul>
            </div>
        </div>
        <div class="bottom-spacer"></div>
    </div>
</div>
@stop
@section('mod-content')
<style>
    .wrapper-content{
        margin-left: 370px;
    }
    .navbar-static-top{

    }
</style>
<link href="/packages/kspm/laikacms/resources/admin/theme/plugins/css/codemirror/codemirror.css" rel="stylesheet">
<link href="/packages/kspm/laikacms/resources/admin/theme/plugins/css/codemirror/ambiance.css" rel="stylesheet">
<link href="/packages/kspm/laikacms/resources/admin/theme/plugins/css/summernote/summernote.css" rel="stylesheet" type="text/css">
<link href="/packages/kspm/laikacms/resources/admin/theme/plugins/css/summernote/summernote-bs3.css" rel="stylesheet" type="text/css">




<form id="page-form" action="/{{$cmsprefix}}/cms/page/save" method="POST">
    <input type="hidden" name="page[id]" value="{{$page->id}}">


    <div class="ibox float-e-margins">
        <div class="ibox-content">
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane" id="options">
                    <div class="panel-body">
                        <label>Titel</label>
                        <input type="text" class="form-control" name="page[title]" value="{{$page->title}}">  
                        <label>URL</label>
                        <input type="text" class="form-control" name="page[slug]" value="{{$page->slug}}">  
                        <label>Parent Page</label>
                        <select name="page[parent]" class="form-control selector">
                            <option value="0">---- Übergeordnete Seite wählen -----</option>
                            @foreach ($pageTree as $parentPage)
                            @if($page->id != $parentPage->id)
                            <option value="{{$parentPage->id}}" @if($parentPage->id == $page->parent)selected @endif >{{$parentPage->title}}</option>
                            @endif
                            @if($parentPage['childs'])
                            @foreach ($parentPage['childs'] as $treeParentParentPage)
                            <option value="{{$treeParentParentPage->id}}" @if($treeParentParentPage->id == $page->parent)selected @endif >--- {{$treeParentParentPage->title}}</option>

                            @endforeach
                            @endif
                            @endforeach
                        </select>
                        
                        <input type="checkbox" name="page[showinnav]" value="1" @if($page->showinnav) checked @endif />
                        <label>Anzeigen in Navigation</label> 
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane active" id="content">
                    <div class="panel-body">

                        <ul class="nav nav-tabs" role="tablist">
                            @foreach($content as $skey => $block)
                            <li role="presentation" @if($skey == 'main') class="active" @endif><a href="#{{$skey}}" aria-controls="{{$skey}}" role="tab" data-toggle="tab">{{$skey}}</a></li>
                            @endforeach
                        </ul>

                        <br />

                        <!-- Tab panes -->
                        <div class="tab-content">

                            @foreach($content as $skey => $block)
                            <div role="tabpanel" class="tab-pane @if($skey == 'main') active @endif" id="{{$skey}}">
                                <table class="table-bordered table-striped" style="width:100%">
                                    @foreach($block as $c)
                                    @if( array_key_exists ('key', $c))
                                    <tr>
                                        <td width="10%" nowrap style="padding: 10px;">{{$c['key']}}</td>
                                        <td width="90%" style="padding: 10px;">
                                            @include('laikacms::cms.pages.types.'.$c['type'], array('c'=>$c))
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </table>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="seo">

                    <div class="panel-body">
                        <label>SEO Titel</label>
                        <input type="text" class="form-control" name="page[meta_title]" value="{{$page->meta_title}}">      
                        <label>Meta Keywords</label>
                        <input type="text" class="form-control" name="page[meta_tags]" value="{{$page->meta_tags}}">
                        <label>Meta Description</label>
                        <textarea class="form-control" name="page[meta_description]">{{$page->meta_description}}</textarea>

                    </div>

                </div>
                <div role="tabpanel" class="tab-pane" id="template">

                    <div class="panel-body">
                        <textarea id="template-code" style="min-height: 500px;" name="page[template]">{{$page->template}}</textarea>



                    </div>
                </div>
            </div>

            <br />
            <!--<button class="btn btn-primary btn-toolbar pull-left" id="btn-page-save">Speichern</button>
            <a class="btn btn-danger btn-toolbar pull-right" href="/{{$cmsprefix}}/page/{{$page->id}}/delete" onclick="return confirm('Wirklich?');
                    return false">Löschen</a>
            <br /> -->
        </div>

    </div>

</form>
<style>
    .CodeMirror {
        border: 1px solid #eee;
        height: auto;
    }


    .asset-box{
        width: 100px;
        height: 100px;
        background-color: white;
        display: table;
        text-align: center;
        vertical-align: middle;
        background-color: white;
        background-position: center center;
        background-repeat: no-repeat;
        background-size: 100% auto;
        border: 1px solid lightblue;

    }
    .asset-box i{
        cursor: pointer;
        font-size: 200%;
        height: 100%;
        width:100%;
        text-align: center;
        vertical-align: middle;
        display: table-cell;

    }

    .note-editable{
        background: white;
        height: 80%;
    }

    .dd-item .dd-handle.active{
        background: #555;
        font-weight: 600;
    }

</style>
<script src="/packages/kspm/laikacms/resources/admin/theme/plugins/js//summernote/summernote.min.js" type="text/javascript"></script>
<script src="/packages/kspm/laikacms/resources/admin/theme/plugins/js//summernote/summernote.plugin.video.min.js" type="text/javascript"></script>
<script src="/packages/kspm/laikacms/resources/admin/theme/plugins/js//codemirror/codemirror.js"></script>
<script src="/packages/kspm/laikacms/resources/admin/theme/plugins/js//codemirror/mode/xml/xml.js" type="text/javascript"></script>
<script src="/packages/kspm/laikacms/resources/admin/theme/plugins/js//codemirror/mode/css/css.js" type="text/javascript"></script>
<script src="/packages/kspm/laikacms/resources/admin/theme/plugins/js//codemirror/mode/javascript/javascript.js" type="text/javascript"></script>
<script src="/packages/kspm/laikacms/resources/admin/theme/plugins/js//codemirror/mode/htmlmixed/htmlmixed.js"></script>

<script>
                    $(document).ready(function () {

                        var hasCodeMirrorEditor = false;

                        if (location.hash) {
                            $("a[aria-controls='" + location.hash.replace('#', '') + "']").trigger('click');
                            if (location.hash == "#template") {
                                CodeMirror.fromTextArea(document.getElementById("template-code"), {
                                    lineNumbers: true,
                                    matchBrackets: true,
                                    styleActiveLine: true
                                });
                                hasCodeMirrorEditor = true;
                            }
                            $(document).scrollTop(0);
                        }


                        $('.wysiwyg-text').summernote();

                        $('.asset-box').each(function () {
                            var datakey = $(this).attr('data-key');
                            /**$(this).find('i').dropzone({
                             url: "/" + laikacms_prefix + "/genius/upload-slide-asset/" + Genius.Editor.currentSlideId + "/" + datakey,
                             paramName: "file",
                             success: Genius.Editor.handleSlideAssetUpload
                             })**/
                            var assetBox = $(this);
                            $(this).find('i').jassets({
                                success: function (result, id) {
                                    console.log(result.src);
                                    assetBox.css('background-image', 'url(' + result.src + ')');
                                    assetBox.find('i').removeClass('fa-plus');
                                    assetBox.find('.form-control').val(result.src);
                                }
                            });
                        })


                        $(window).keypress(function (event) {
                            if (event.which == 115 && (event.ctrlKey || event.metaKey) || (event.which == 19)) {
                                __submitForm($('#page-form'));
                                event.preventDefault();
                                return true;
                            }

                        });



                        $("a[data-toggle='tab']").on('show.bs.tab', function (e) {
                            location.hash = $(this).attr('aria-controls');
                        });

                        $("a[aria-controls='template']").on('shown.bs.tab', function (e) {
                            if (hasCodeMirrorEditor)
                                return;
                            var templateCode = CodeMirror.fromTextArea(document.getElementById("template-code"), {
                                lineNumbers: true,
                                matchBrackets: true,
                                styleActiveLine: true
                            });
                            hasCodeMirrorEditor = true;
                            return false;
                        });


                        /**
                         * set current key in tree active
                         **/
                        $('[data-id="{{$page->id}}"] .dd-handle').first().addClass('active');



                    });

                    function __submitForm(form) {
                        form.attr('action', form.attr('action') + location.hash);
                        form.submit();
                    }
</script>
@stop
@section('modal')
@include('laikacms::cms.pages.modal.versions')
@endsection
