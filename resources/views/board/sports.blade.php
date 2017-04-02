@extends('layouts')

@section('title_description', '')

@section('meta_description', '')

@section('tabs')

  <ul class="tabs-panel">
    <li class="active"><a href="#">Главная</a></li>
    <!-- <li><a href="{{ action('SportController@getHotMatches', 'football') }}">Горячие Матчи</a></li> -->
  </ul>

@endsection

@section('content')

  <div class="col-lg-8 col-md-8 col-sm-12">
    <div class="sports">
      @foreach($sports->sortBy('sort_id')->chunk(4) as $chunk)
        <div class="row">
          @foreach($chunk as $sport)
            <div class="col-md-3 col-sm-3 col-xs-6 sport-item">
              <a href="{{ url('sport/'.$sport->slug) }}">
                <img class="img-responsive" src="/img/sport/{{ $sport->image }}">
                <p class="sport-item-title">{{ $sport->title }}</p>
              </a>
            </div>
          @endforeach
        </div>
      @endforeach
    </div>
  </div>

@endsection