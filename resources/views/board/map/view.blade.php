
  <div class="media">
    <div class="media-left hidden-xs">
      <a href="{{ url('sport/'.$sport->slug.'/'.$area->id) }}">
        <img class="media-object" src="/img/organizations/{{ $area->org_id.'/'.$area->image }}" alt="...">
      </a>
    </div>
    <div class="media-body">
      <div class="pull-left">
        <h4 class="media-heading"><a href="{{ url('sport/'.$sport->slug.'/'.$area->id) }}">{{ $area->title }}</a></h4>
        <p><b>Адрес:</b> {{ $area->address }}</p>
      </div>
      <div class="pull-left">
        <dl class="dl-horizontal">
          Игроков: <span class="badge">59</span><br>
          Матчей: <span class="badge">20</span>
        </dl>
      </div>
      <div class="clearfix"></div>
      <p>{{ $area->description }}</p>
    </div>
  </div>
