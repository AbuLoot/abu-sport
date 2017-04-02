@extends('layouts')

@section('tabs')

  <ul class="tabs-panel">
    <li><a href="{{ action('SportController@getAreas', $sport->slug) }}">Площадки</a></li>
    <li class="active"><a href="#">На карте</a></li>
    <li><a href="{{ action('SportController@getHotMatches', 'football') }}">Горячие матчи</a></li>
  </ul>

@endsection

@section('content')

  <div class="col-lg-8 col-md-8 col-sm-12">
    <div class="areas">

      @include('partials.alerts')
      <div class="wrapper-height" id="search_on_ya_Map" style="border: 1px solid #ccc;"></div>

    </div>
  </div>

@endsection

@section('styles')
  <style>
    #search_on_ya_Map{
      width: 100%;
      height: 500px;
    }

    .ymaps-2-1-34-b-cluster-tabs__menu, .ymaps-2-1-34-b-cluster-tabs__content-item {
      display: block;
      width: 200px;
      min-height: 290px;
    }

    .ymaps-2-1-34-balloon__content {
      max-width: 330px;
      min-height: 295px;
    }

    .ymaps-2-1-34-b-cluster-tabs{
      min-height: 300px;
    }
  </style>
@endsection

@section('scripts')
  <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
  <script>
    ymaps.ready(init);
    var myMap,
      myPlacemark;

    function init() {
      myMap = new ymaps.Map("search_on_ya_Map", {
        center: [43.250655142118, 76.931632578351],
        zoom: 13
      });

      var objectManager = new ymaps.ObjectManager({
        // Использовать кластеризацию.
        clusterize: true
      });

      myMap.geoObjects.add(objectManager);

      objectManager.add({!! str_replace("data-original", "src", json_encode($data)) !!});
    }

    $(document).ready(function(){
      //$("#search_on_ya_Map").height($(window).height() - ($(".navbar.header").height() + 40));
      //$("#search_on_ya_Map").width($(window).width() - 400);
    });
  </script>
@endsection