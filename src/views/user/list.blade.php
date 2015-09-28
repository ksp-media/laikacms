@extends('laikacms::layouts.cms')
@section('action-nav')
<li>
  <a onclick="Jbkcms.User.loadUserDetailModal('new')">+ Neuer User</a>
</li>
@stop
@section('mod-content')
<link href="/packages/kspm/laikacms/resources/admin/theme/plugins/css/dataTables/dataTables.tableTools.min.css" rel="stylesheet">
<!-- Data Tables -->
<script src="/packages/kspm/laikacms/resources/admin/theme/plugins/js//dataTables/jquery.dataTables.js"></script>
<script src="/packages/kspm/laikacms/resources/admin/theme/plugins/js//dataTables/dataTables.bootstrap.js"></script>
<script src="/packages/kspm/laikacms/resources/admin/theme/plugins/js//dataTables/dataTables.responsive.js"></script>
<script src="/packages/kspm/laikacms/resources/admin/theme/plugins/js//dataTables/dataTables.tableTools.min.js"></script>



<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Content</h5>

    </div>
    <div class="ibox-content">
        <table class="table table-striped table-bordered table-hover dataTable-phrases">
            <thead>
                <tr>
                    <th>ID#</th>
                    <th>E-Mail</th>
                    <th>Name</th>
                    <th nowrap>Gruppe / Rechte</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td width="1">{{$user->id}}</td>
                    <td width="1">{{$user->email}}</td>
                    <td>{{$user->full_name}}</td>
                    <td width="1" nowrap>{{$user->role->label}}</td>
                    <td width="1"><a onclick="Jbkcms.User.loadUserDetailModal('{{$user->id}}')" class="btn btn-primary btn-sm">bearbeiten</a></td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

  
<style>
    
    
    .rte-text{
        width: 100%;
        height: auto;
    }
    
    .modal-content{
     height: 100%;   
    }
    
    .modal-body{
     height: 80%;   
     overflow:hidden;
    }
    
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
</style>
@stop
