<!-- Modal -->
<div class="modal fade" id="versions-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Versionen</h4>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                @foreach($page->versions()->orderBy('updated_at', 'DESC')->take(20)->get() as $version)
                <li class="list-group-item version-item" data-id="{{$version->id}}"><i class="fa fa-history"></i> {{$version->updated_at}}</li>
                @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    $('.version-item').each(function(){
        $(this).click(function(){
            if(confirm("Version wirklich wiederherstellen?")){
                location.href = '/{{$cmsprefix}}/cms/page/{{$page->id}}/version/'+$(this).data('id')+'/use';
            }
            
        }); 
    })
</script>
<style>
    .version-item{
        cursor:pointer;
    }
</style>