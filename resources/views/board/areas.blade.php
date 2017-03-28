@extends('layouts')

@section('title_description', '')

@section('meta_description', '')

@section('tabs')

  <ul class="tabs-panel">
    <li class="active"><a href="#">Площадки</a></li>
    <li><a href="{{ action('SportController@getAreasWithMap', $sport->slug) }}">На карте</a></li>
    <li><a href="#">Горячие матчи</a></li>
  </ul>

@endsection

@section('content')

  <div class="col-lg-8 col-md-9 col-sm-12">
    <ol class="breadcrumb">
      <li><a href="{{ url('/') }}"><span class="glyphicon glyphicon-menu-left"></span> Главная</a></li>
      <li class="active">{{ $sport->title }}</li>
    </ol>
    <div class="areas">
      @foreach ($areas as $area)
        <div class="media">
          <a href="{{ url('sport/'.$sport->slug.'/'.$area->id.'/matches') }}">
            <img class="img-responsive pull-left" src="/img/organizations/{{ $area->org_id.'/'.$area->image }}" alt="...">
          </a>
          <div class="col-md-8 col-sm-8 col-xs-12">
            <p class="h4"><a href="{{ url('sport/'.$sport->slug.'/'.$area->id.'/matches') }}">{{ $area->title }}</a></p>
            <p><b>Адрес:</b> {{ $area->address }}</p>
            <p><b>Матчей:</b> <span class="badge">{{ $area->fieldsMatchesCount }}</span></p>
            <p>{{ $area->description }}</p>
          </div>
        </div>
      @endforeach
    </div>

    {{ $areas->render() }}
  </div>

@endsection