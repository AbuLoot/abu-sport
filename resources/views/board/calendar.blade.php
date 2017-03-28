@extends('layouts')

@section('title_description', '')

@section('meta_description', '')

@section('tabs')

  <ul class="tabs-panel">
    <li><a href="{{ action('MatchController@createMatchInArea', [$sport->slug, $area->id]) }}"><span class="glyphicon glyphicon-plus"></span> Создать матч</a></li>
    <li><a href="{{ action('SportController@getMatches', [$sport->slug, $area->id]) }}">Матчи</a></li>
    <li class="active"><a href="#">Календарь</a></li>
    <li><a href="{{ action('SportController@getInfo', [$sport->slug, $area->id]) }}">Информация</a></li>
  </ul>

@endsection

@section('content')

  <div class="col-lg-8 col-md-8 col-sm-12">
    <ol class="breadcrumb">
      <li><a href="{{ url('/') }}"><span class="glyphicon glyphicon-menu-left"></span> Главная</a></li>
      <li><a href="{{ url('sport/'.$sport->slug) }}"><span class="glyphicon glyphicon-menu-left"></span> {{ $sport->title }}</a></li>
      <li class="active">{{ $area->title }}</li>
    </ol>

    <?php $current_hour = date('H').':00'; ?>
    <?php $current_week = (int) date('w'); ?>
    <?php $current_date = date('Y-m-d'); ?>
    <?php $current_uri = 'sport/'.$sport->slug.'/'.$area->id.'/calendar'; ?>

    @foreach($area->fields as $field)
      <h3>{{ $field->title }}</h3>
      <input type="hidden" name="field_id" value="{{ $field->id }}">

      <ul class="nav nav-tabs">
        <li @if (Request::is($current_uri.'/1')) class="active" @endif><a href="{{ action('SportController@getMatchesWithCalendar', [$sport->slug, $area->id, 1]) }}">1 День</a></li>
        <li @if (Request::is($current_uri.'/3', $current_uri)) class="active" @endif><a href="{{ action('SportController@getMatchesWithCalendar', [$sport->slug, $area->id, 3]) }}">3 дня</a></li>
        <li @if (Request::is($current_uri.'/7')) class="active" @endif><a href="{{ action('SportController@getMatchesWithCalendar', [$sport->slug, $area->id, 7]) }}">Неделя</a></li>
      </ul>

      <div class="table-responsive">
        <table class="table table-hover table-bordered">
          <thead>
            <tr>
              <th class="empty-th text-center h3"><span class="glyphicon glyphicon-time"></span></th>
              @foreach($days as $day)
                @if ($current_date == $day['year'])
                  <th class="bg-info" @if (Request::is($current_uri.'/1')) colspan="2" @endif>{{ $day['day'] }}<br>{{$day['weekday'] }}</th>
                @else
                  <th @if (Request::is($current_uri.'/1')) colspan="2" @endif>{{ $day['day'] }}<br>{{$day['weekday'] }}</th>
                @endif
              @endforeach
            </tr>
          </thead>
          <tbody>
            @foreach(trans('data.hours') as $hour_key => $hour)
              @continue($hour < $area->start_time)
              <tr>
                <td class="hours"><span>{{ $hour }}</span></td>

                @foreach($days as $day)

                  @if (Request::is('create-match/1'))
                    <td>
                      @foreach($field->schedules->where('week', $current_week) as $schedule)
                        @if ($schedule->start_time <= $hour AND $schedule->end_time >= $hour)
                          {{ $schedule->price }} тг
                        @endif
                      @endforeach
                    </td>
                  @endif

                  @if ($current_date >= $day['year'] AND $current_hour >= $hour)
                    <?php $game = false; ?>
                    @foreach($field->matches->where('date', $day['year'])->where('status', 1) as $match)
                      @if ($match->start_time <= $hour AND $match->end_time >= $hour)
                        <td class="bg-warning">
                          <span>Игра состоялось</span>
                        </td>
                        <?php $game = true; ?>
                      @endif
                    @endforeach

                    @if ($game == false)
                      <td class="bg-warning">
                        <span class="text-muted">Время прошло</span>
                      </td>
                    @endif
                  @else
                    <?php $game = false; ?>
                    @foreach($field->matches->where('date', $day['year']) as $match)
                      <?php $id = $field->id.'-'.$day['year'].'-'.$hour_key; ?>
                      @if ($match->start_time <= $hour AND $match->end_time >= $hour)
                        <?php $game = true; ?>
                        @if ($match->status == 0)
                          <td id="td-{{ $id }}">
                            <span class="glyphicon glyphicon-refresh"></span>
                            <span>В обработке</span>
                          </td>
                        @else
                          <td id="td-{{ $id }}">
                            <span class="glyphicon glyphicon-time"></span>
                            <a href="{{ url('sport/'.$sport->slug.'/'.$area->id.'/match/'.$match->id) }}">Игра {{ $match->id }}</a>
                          </td>
                        @endif
                      @endif
                    @endforeach

                    @if ($game == false)
                      <?php $id = $field->id.'-'.$day['year'].'-'.$hour_key; ?>
                      <td id="td-{{ $id }}">
                        <span>Свободно</span>
                      </td>
                    @endif
                  @endif
                @endforeach
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endforeach
  </div>
  <div class="col-lg-2 col-md-2 col-sm-12">
    <a href="{{ url('sport/'.$sport->slug.'/'.$area->id.'/create-match') }}" class="btn btn-primary text-uppercase pull-right"><span class="glyphicon glyphicon-plus"></span> Создать матч</a>
  </div>

@endsection

@section('scripts')
    <script src="/js/socket.io-1.4.5.js"></script>
    <script>
      var socket = io(':6001'),
          channel = 'area-{{ $area->id }}';

      socket.on('connect', function() {
        socket.emit('subscribe', channel)
      });

      socket.on('error', function() {
        console.warn('Error', error);
      });

      socket.on('message', function(message) {
        console.log(message);
      });

      socket.on(channel, function(data) {
        if (data.status == 0) {
          var startTime = data.startTime.split(':'),
              endTime = data.endTime.split(':'),
              cycle = +endTime[0] - +startTime[0];

          for (var i = 0; i <= cycle; i++) {
            $('#td-' + data.fieldId + '-' + data.date + '-' + startTime[0]++).empty().append('<span class="glyphicon glyphicon-refresh"></span> <span>В обработке</span>');
          }
        } else {
          var startTime = data.startTime.split(':'),
              endTime = data.endTime.split(':'),
              cycle = +endTime[0] - +startTime[0];

          for (var i = 0; i <= cycle; i++) {
            $('#td-' + data.fieldId + '-' + data.date + '-' + startTime[0]++).empty().append('<span class="glyphicon glyphicon-time"></span> <a href="/sport/' + data.sportSlug + '/' + data.areaId + '/match/' + data.id + '">Игра  ' + data.id + '</a>');
          }
        }
      });
    </script>
@endsection