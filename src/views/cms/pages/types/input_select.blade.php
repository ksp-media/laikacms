<select class="form-control" name="page[content][{{$c['key']}}]">
    @foreach($c['params'] as $key => $val)
    <option value="{{$key}}" @if($c['value'] == $key) selected @endif>{{$val}}</option>
    @endforeach
</select>