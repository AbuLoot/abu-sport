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
          <div class="media-left">
            <a href="{{ url('sport/'.$sport->slug.'/'.$area->id.'/matches') }}">
              <img class="media-object" src="/img/organizations/{{ $area->org_id.'/'.$area->image }}" alt="...">
            </a>
          </div>
          <div class="media-body">
            <div class="pull-left">
              <h4 class="media-heading"><a href="{{ url('sport/'.$sport->slug.'/'.$area->id.'/matches') }}">{{ $area->title }}</a></h4>
              <p><b>Адрес:</b> {{ $area->address }}</p>
            </div>
            <div class="pull-right">
              <dl class="dl-horizontal">
                <dt>Матчей:</dt><dd><span class="badge">{{ $area->fieldsMatchesCount }}</span></dd>
              </dl>
            </div>
            <div class="clearfix"></div>
            <p>{{ $area->description }}</p>
          </div>
        </div>
      @endforeach
    </div>

    {{ $areas->render() }}
  </div>

@endsection