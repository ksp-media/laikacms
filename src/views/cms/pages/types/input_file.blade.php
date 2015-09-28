<!--<input type="file" class="form-control" name="page[content][{{$c['key']}}]" value="{{$c['value']}}" /> -->

<div class="asset-box" style="background-image: @if($c['value'])url({{$c['value']}}) @endif">
    <input type="hidden" class="form-control" name="page[content][{{$c['key']}}]" value="{{$c['value']}}" />
    <i class="fa  @if(!$c['value']) fa-plus @endif"></i>
</div>