@extends('laikacms::layouts.seminar')
@section('action-nav')

    @if (!$seminar)
        <strong>Neues Seminar</strong> 
    @else
        <strong>#{{$seminar->id}} bearbeiten</strong> 
    @endif
    @if (Session::has('message'))
        <div class="inline alert alert-success">{{ Session::get('message') }}</div>
    @endif 

@stop
@section('mod-content')
<form id="seminar-form" action="/{{$cmsprefix}}/seminar/save" method="POST">
    <input type="hidden" name="seminar[id]" value="{{$seminar->id}}">
 <div class="panel-group" id="accordion">
     <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseProp">
          Eigenschaften
        </a>
      </h4>
    </div>
      
    <div id="collapseProp" class="panel-collapse collapse in">
      <div class="panel-body">
          <input type="checkbox" class="checkbox-inline" name="seminar[active]" value="1" @if ($seminar->active) checked @endif />
          <label>Aktiv</label>&nbsp;&nbsp;
           <input type="checkbox" class="checkbox-inline" name="seminar[price_is_offer]" value="1" @if ($seminar->price_is_offer) checked @endif />
          <label>Sonderangebot</label>&nbsp;&nbsp;
          <input type="checkbox" class="checkbox-inline" name="seminar[category_highlight]" value="1" @if ($seminar->category_highlight) checked @endif />
          <label>Kategorie Highlight</label>&nbsp;&nbsp;
          <input type="checkbox" class="checkbox-inline" name="seminar[start_highlight]" value="1" @if ($seminar->start_highlight) checked @endif />
          <label>Start Highlight</label><br/>
           <label>Titel</label>
          <input type="text" class="form-control" name="seminar[title]" value="{{$seminar->title}}"> 
          <label>Tags (komma separiert)</label>
          <input type="text" class="form-control" name="seminar[tags]" value="{{$seminar->tags}}">
         
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
          Website Texte
        </a>
      </h4>
    </div>
      
    <div id="collapseOne" class="panel-collapse collapse">
      <div class="panel-body">
          <label>Teaser</label>
          <textarea class="form-control rte-text" name="seminar[teaser]">{{$seminar->teaser}}</textarea>
          <label>Profil</label>
          <textarea class="form-control rte-text" name="seminar[profile]">{{$seminar->profile}}</textarea>
          <label>Essenz</label>
          <textarea class="form-control rte-text" name="seminar[essenz]">{{$seminar->essenz}}</textarea>
          <label>Methodik</label>
          <textarea class="form-control rte-text" name="seminar[methodik]">{{$seminar->methodik}}</textarea>
          <label>Seminar Inhalt</label>
          <textarea class="form-control rte-text" name="seminar[seminar_content]">{{$seminar->seminar_content}}</textarea>

      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
          Meta Tags // SEO Stuff
        </a>
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse">
      <div class="panel-body">
          <label>SEO Titel</label>
          <input type="text" class="form-control" name="seminar[meta_title]" value="{{$seminar->meta_title}}">      
          <label>Meta Keywords</label>
          <input type="text" class="form-control" name="seminar[meta_tags]" value="{{$seminar->meta_tags}}">
          <label>Meta Description</label>
          <textarea class="form-control" name="seminar[meta_desc]">{{$seminar->meta_desc}}</textarea>
          
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
          Kategorien
        </a>
      </h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse">
      <div class="panel-body">
          @foreach ($categories as $category)
            <input type="checkbox" class="checkbox-inline" name="seminar[category][]" value="{{$category->id}}" @if ($category->has_seminar($seminar->id)) checked @endif/>&nbsp;&nbsp;<label>{{$category->title}}</label>&nbsp;&nbsp;
          @endforeach
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
          Termine // Preise
        </a>
      </h4>
    </div>
    <div id="collapseFour" class="panel-collapse collapse">
      <div class="panel-body">
          <a id="add-date" class="btn btn-primary">+ Termin</a>
          <table class="table date-table">
              <thead>
              <th>Datum von</th>
              <th>Datum bis</th>
              <th>Tage</th>
              <th>Ort</th>
              <th>Preis</th>
              <th>Extratext</th>
              <th>Sonderpreis</th>
              <th>Aktiv</th>
              <th></th>
              </thead>
              <input type="hidden" class="deleted-dates" name="seminar[deleted-dates]" value="">
          @foreach ($seminar->dates as $date)
          <tr class="daterow">
              <td><input type="text" name="seminar[date][{{$date->id}}][date_start]" class="form-control" value="{{$date->date_start}}"></td>
              <td><input type="text" class="form-control"  name="seminar[date][{{$date->id}}][date_end]" value="{{$date->date_end}}"></td>
              <td><input type="text" class="form-control"  name="seminar[date][{{$date->id}}][days]" value="{{$date->days}}"></td>
              <td><input type="text" class="form-control"  name="seminar[date][{{$date->id}}][city]" value="{{$date->city}}"></td>
              <td><input type="text" class="form-control"  name="seminar[date][{{$date->id}}][price]" value="{{$date->price}}"></td>
              <td><input type="text" class="form-control"  name="seminar[date][{{$date->id}}][description]" value="{{$date->description}}"></td>
              <td><input type="checkbox"  name="seminar[date][{{$date->id}}][actionprice]" value="1" class="checkbox" @if ($date->actionprice) checked @endif></td>
              <td><input type="checkbox"  name="seminar[date][{{$date->id}}][is_active]" value="1" class="checkbox" @if ($date->is_active) checked @endif></td>
              <td><a class="btn btn-default btn-sm date-delete" data-id="{{$date->id}}">- löschen</a></td>
          </tr>
          @endforeach
          <tr class="daterow-template">
              <td><input type="text" name="%%ID%%][date_start]" class="form-control" placeholder="YYYY-MM-DD"></td>
              <td><input type="text" class="form-control"  name="%%ID%%][date_end]" placeholder="YYYY-MM-DD"></td>
              <td><input type="text" class="form-control"  name="%%ID%%][days]" ></td>
              <td><input type="text" class="form-control"  name="%%ID%%][city]"></td>
              <td><input type="text" class="form-control"  name="%%ID%%][price]" ></td>
               <td><input type="text" class="form-control"  name="%%ID%%][description]" ></td>
              <td><input type="checkbox"  name="%%ID%%][actionprice]" value="1" class="checkbox"></td>
              <td><input type="checkbox"  name="%%ID%%][is_active]" value="1" class="checkbox"></td>
              <td><a class="btn btn-default btn-sm date-delete" data-id="%%ID%%">- löschen</a></td>
          </tr>
           </table>
      </div>
    </div>
  </div>
</div>
        <button class="btn btn-primary btn-toolbar pull-left" id="btn-seminar-save">Speichern</button>
        <a class="btn btn-danger btn-toolbar pull-right" href="/{{$cmsprefix}}/seminar/{{$seminar->id}}/delete" onclick="return confirm('Wirklich?'); return false">Löschen</a>
    </form>
<script type="text/javascript">

</script>
@stop
