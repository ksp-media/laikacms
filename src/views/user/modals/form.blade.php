<div class="modal fade" id="user-form-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">User</h4>
            </div>
            <div class="modal-body">
                <form id="user-form">
                    @if($user)
                    <input type="hidden" name="user[id]" value="{{$user->id}}" />
                    @endif
                    <label>Name</label><input type="text" id="name" name="user[full_name]" value="@if($user){{$user->full_name}}@endif" placeholder="Name" class="form-control"/>
                    <label>E-Mail Adresse</label><input type="text" id="email" name="user[email]" value="@if($user){{$user->email}}@endif" placeholder="E-Mail Adresse" class="form-control"/>
                    <label>Kennwort</label><input type="password" id="password" name="user[password]" value="" placeholder="Kennwort" class="form-control"/>
                    <label>Gruppe</label>
                    <select name="user[laikacms_user_role_id]" class="form-control">
                        @foreach($roles as $role)
                        <option value="{{$role->id}}" @if($user && ($user->role->id === $role->id))selected @endif>{{$role->label}}</option>
                        @endforeach
                    </select>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="user-form-modal-save">Speichern</button>
            </div>
        </div>
    </div>
</div>
