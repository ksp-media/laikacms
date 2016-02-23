@if(isset($viewtype) && $viewtype == "embeded")
<!DOCTYPE html>
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        @include('laikacms::layouts._head')
        <meta name="_token" content="{{ csrf_token() }}" />


    </head>
     <body class="iframe-body">
@endif

<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    @if(isset($viewtype) && $viewtype == "embeded")
                    <div class="sidebar sidebar-tree assets">
                    @endif
                    <div class="dd" id="assets-folder-tree" style="position: fixed; width: 20%">
                        {!! \KSPM\LCMS\Model\AssetsFolder::htmlTree() !!}
                    </div>
                     @if(isset($viewtype) && $viewtype == "embeded")
                    </div>
                    @endif
        <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="row">
                <div class="col-lg-12">
                    @if(isset($folder->name))
                    <h2 class="inline edit-attribute" data-attribute="name" data-id="{{$folder->id}}" contenteditable=true>{{$folder->name}}</h2>
                    @endif
                    <button class="btn btn-primary pull-right btn-upload" data-folder="{{$folder->id}}"><i class="fa fa-plus"></i> Upload Files</button>
                    <div class="clearfix"></div>
                    <hr />
                   {!! $assets->appends(['view' => $viewtype])->render() !!}
                    <div class="file-box-cnt">
                        @foreach($assets as $file)
                        <div class="file-box">
                            <div class="file">
                                <a href="{{$file->filepath}}/{{$file->filename}}" target="_blank">
                                    <span class="corner"></span>
                                    @if($file->filetype == 2)
                                    <div class="icon">
                                        <i class="fa fa-film"></i>
                                    </div>
                                    @elseif($file->filetype == 3)
                                    <div class="icon">
                                        <i class="fa fa-file"></i>
                                    </div>
                                    @elseif($file->filetype == 1)
                                    <div class="image">
                                        <img src="{{AssetViewHelper::thumb($file)}}" class="img-responsive" alt="image">
                                    </div>
                                    @endif
                                       </a>
                                @if(isset($viewtype) && $viewtype == "embeded")
                                <a data-id="{{$file->id}}" class="file-select" data-src="{{$file->filepath}}/{{$file->filename}}">
                                    <div class="file-name">
                                        {{$file->filename}}
                                        <div class="actions">
                                            <i class="fa fa-plus"></i>
                                           <!-- <i class="fa fa-trash" data-action="delete-file" data-id="{{$file->id}}"></i> -->
                                        </div>
                                    </div>
                                    
                                </a>
                                @else
                                 <div class="file-name">
                                        {{$file->filename}}
                                         <i class="fa fa-trash-o fa-lg pull-right" style="cursor: pointer" data-action="delete-file" data-id="{{$file->id}}"></i>
                                    </div>
                                @endif
                             
                            </div>

                        </div>
                        @endforeach
                        
                        
                    </div>
                    <div class="clearfix"></div>
                    {!! $assets->appends(['view' => $viewtype])->render() !!}

                </div>
            </div>
        </div>
    </div>
</div>
<div class="upload-preview" style="display:none"></div>

<script>Jbkcms.Assets.currentFolderId = {{$folder->id}}</script>

@if(isset($viewtype) && $viewtype == "embeded")
<script>
$(document).ready(function(){
    Jbkcms.AssetManager.viewMode = "embeded";
    Jbkcms.AssetManager.initFileActions();
})
</script>
     </body>
</html>
@endif