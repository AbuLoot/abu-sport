
  <div class="media">
    <div class="media-left hidden-xs">
      <a href="{{ url('sport/'.$sport->slug.'/'.$area->id) }}">
        <img class="media-object" src="/img/organizations/{{ $area->org_id.'/'.$area->image }}" alt="...">
      </a>
    </div>
    <div class="media-body">
      <h4 class="media-heading"><a href="{{ url('sport/'.$sport->slug.'/'.$area->id) }}">{{ $area->title }}</a></h4>
      <p>Адрес: {{ $area->address }}</p>
      <p>Игроков: <span class="badge">59</span></p>
      <p>Матчей: <span class="badge">20</span></p>
      <p>{{ $area->description }}</p>
    </div>
  </div>
