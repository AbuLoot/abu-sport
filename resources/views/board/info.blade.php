@extends('layouts')

@section('title_description', '')

@section('meta_description', '')

@section('tabs')

  <ul class="tabs-panel">
    <li><a href="{{ action('MatchController@createMatchInArea', [$sport->slug, $area->id]) }}"><span class="glyphicon glyphicon-plus"></span> Создать матч</a></li>
    <li><a href="{{ action('SportController@getMatches', [$sport->slug, $area->id]) }}">Матчи</a></li>
    <li><a href="{{ action('SportController@getMatchesWithCalendar', [$sport->slug, $area->id]) }}">Календарь</a></li>
    <li class="active"><a href="#">Информация</a></li>
  </ul>

@endsection

@section('content')

  <div class="col-lg-8 col-md-8 col-sm-12">
    <ol class="breadcrumb">
      <li><a href="{{ url('/') }}"><span class="glyphicon glyphicon-menu-left"></span> Главная</a></li>
      <li><a href="{{ url('sport/'.$sport->slug) }}"><span class="glyphicon glyphicon-menu-left"></span> {{ $sport->title }}</a></li>
      <li class="active">{{ $area->title }}</li>
    </ol>

    <div class="col-md-4">
      <img src="/img/organizations/{{ $area->id.'/'.$area->image }}" class="center-block img-responsive">
    </div>
    <div class="col-md-8">
      <table class="table">
        <tbody>
          <tr>
            <td>Название</td>
            <td>{{ $area->title }}</td>
          </tr>
          <tr>
            <td>Номер</td>
            <td>{{ $area->sort_id }}</td>
          </tr>
          <tr>
            <td>Компания</td>
            <td>{{ $area->organization->title }}</td>
          </tr>
          <tr>
            <td>Спорт</td>
            <td>{{ $area->sport->title }}</td>
          </tr>
          <tr>
            <td>Город</td>
            <td>{{ $area->city->title }}</td>
          </tr>
          <tr>
            <td>Номера телефонов</td>
            <td>{{ $area->phones }}</td>
          </tr>
          <tr>
            <td>Emails</td>
            <td>{{ $area->emails }}</td>
          </tr>
          <tr>
            <td>Адрес</td>
            <td>{{ $area->address }}</td>
          </tr>
          <tr>
            <td>Описание</td>
            <td>{{ $area->description }}</td>
          </tr>
          <tr>
            <td>Время работы</td>
            <td>{{ $area->start_time.' - '.$area->end_time }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <div class="col-lg-2 col-md-2 col-sm-12">
    <a href="{{ url('sport/'.$sport->slug.'/'.$area->id.'/create-match') }}" class="btn btn-primary text-uppercase pull-right"><span class="glyphicon glyphicon-plus"></span> Создать матч</a>
  </div>

@endsection

@section('scripts')

@endsection