@extends('layouts')

@section('title_description', '')

@section('meta_description', '')

@section('tabs')

  <ul class="tabs-panel">
    <li><a href="{{ url('/') }}">Главная</a></li>
    <li class="active"><a href="#">Площадки</a></li>
    <li><a href="{{ action('SportController@getHotMatches', 'football') }}"><span class="glyphicon glyphicon-fire"></span> Горячие матчи</a></li>
  </ul>

@endsection

@section('content')

  <div class="col-lg-8 col-md-9 col-sm-12">

    <div class="">
      @forelse ($areas as $area)
        <div class="media">
          <a class="col-md-4 col-sm-4 col-xs-12" href="{{ url('sport/'.$area->sport->slug.'/'.$area->id.'/matches') }}">
            <img class="img-responsive pull-left" src="/img/organizations/{{ $area->org_id.'/'.$area->image }}" alt="...">
          </a>
          <div class="col-md-8 col-sm-8 col-xs-12">
            <p class="h4"><a href="{{ url('sport/'.$area->sport->slug.'/'.$area->id.'/matches') }}">{{ $area->title }}</a></p>
            <p><b>Адрес:</b> {{ $area->address }}</p>
            <p><b>Матчей:</b> <span class="badge">{{ $area->fieldsMatchesCount }}</span></p>
            <p>{{ $area->description }}</p>
          </div>
        </div>
      @empty
        <div class="media">
          <h4>Ничего не найдено</h4>
        </div>
      @endforelse
    </div>

    {{ $areas->render() }}
  </div>

@endsection