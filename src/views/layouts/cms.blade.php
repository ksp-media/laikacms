@extends('laikacms::layouts.default')

@section('content')

<div class="wrapper wrapper-content">
        @yield('sub-sidebar')
        <div class="row">
            
            <div class="col-lg-12 animated">
                <div class="mail-box">
                                    @yield('mod-content')
                </div>

            </div>
        </div>
</div>
<!-- Modal -->
<div class="modal fade" id="content-form-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Content</h4>
            </div>
            <div class="modal-body">
                <form id="content-form">
                    <input type="text" id="key" name="content[key]" value="" placeholder="Schlüssel" class="form-control"/>
                    <textarea style="min-height: 400px;" class="form-control" id="content-value" name="content[value]" placeholder="Inhalt"></textarea>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-save">Speichern</button>
            </div>
        </div>
    </div>
</div>
  
@stop