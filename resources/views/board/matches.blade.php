@extends('layouts')

@section('title_description', '')

@section('meta_description', '')

@section('tabs')

  <ul class="tabs-panel">
    <!-- <li><a href="{{ action('MatchController@createMatchInArea', [$sport->slug, $area->id]) }}"><span class="glyphicon glyphicon-plus"></span> Создать матч</a></li> -->
    <li class="active"><a href="#">Матчи</a></li>
    <li><a href="{{ action('SportController@getMatchesWithCalendar', [$sport->slug, $area->id]) }}">Календарь</a></li>
    <li><a href="{{ action('SportController@getInfo', [$sport->slug, $area->id]) }}"><span class="glyphicon glyphicon-info-sign"></span> Информация</a></li>
  </ul>

@endsection

@section('content')

  <div class="col-lg-8 col-md-8 col-sm-12">
    <ol class="breadcrumb">
      <li><a href="{{ url('/') }}"><span class="glyphicon glyphicon-menu-left"></span> Главная</a></li>
      <li><a href="{{ url('sport/'.$sport->slug) }}">{{ $sport->title }}</a></li>
      <li class="active">{{ $area->title }}</li>
    </ol>

    @include('partials.alerts')

    <?php $current_hour = date('H').':00'; ?>
    <?php $current_week = (int) date('w'); ?>
    <?php $current_date = date('Y-m-d'); ?>

    @foreach($area->fields as $field)
      <h4>{{ $area->title.' - '.$field->title }}</h4>
      <ul class="nav nav-tabs">
        @foreach ($days as $day)
          @if ($day['year'] == $date)
            <li class="active"><a href="{{ url('sport/'.$sport->slug.'/'.$area->id.'/matches/'.$day['year']) }}"><b>{{ $day['short_weekday'].', '.$day['day'] }}</b></a></li>
            <?php $index_weekday = (int) $day['index_weekday']; ?>
          @else
            <li><a href="{{ url('sport/'.$sport->slug.'/'.$area->id.'/matches/'.$day['year']) }}">{{ $day['short_weekday'].', '.$day['day'] }}</a></li>
          @endif
        @endforeach
      </ul>
      <div class="table-responsive">
        <table class="table table-matches table-bordered">
          <thead>
            <tr>
              <th>Время старта</th>
              <th>Номер</th>
              <th>Игроки</th>
              <th>Цена</th>
            </tr>
          </thead>
          <tbody>
            @foreach(trans('data.hours') as $hour_key => $hour)
              @continue($hour < $area->start_time)

              @if ($current_date >= $date AND $current_hour >= $hour)
                <?php $game = false;?>
                @foreach ($field->matches->where('date', $date)->where('status', 1) as $num => $match)
                  @if ($match->start_time <= $hour AND $match->end_time >= $hour)
                    <tr>
                      <td class="hours">{{ $hour }}</td>
                      <td>
                        <span class="glyphicon glyphicon-time"></span> Матч {{ $match->id }}
                        <span class="pull-right label label-default">Конец игры</span>
                      </td>
                      <td>{{ $match->usersCount.'/'.$match->number_of_players }}</td>
                      <td>{{ $match->price }} тг</td>
                      <?php $game = true; ?>
                    </tr>
                  @endif
                @endforeach

                @if ($game == false)
                  <tr class="active">
                    <td class="hours">{{ $hour }}</td>
                    <td><span>Время прошло</span></td>
                    <td></td>
                    <td></td>
                  </tr>
                @endif
              @else
                <?php $game = false; ?>
                <?php $id = $field->id.'-'.$date.'_'.$hour_key; ?>
                @foreach ($field->matches->where('date', $date) as $match)
                  @if ($match->start_time <= $hour AND $match->end_time >= $hour)
                    <?php $game = true; ?>
                    <tr id="{{ $id }}">
                      <td class="hours">{{ $hour }}</td>
                      @if ($match->status == 1)
                        <td>
                          <span class="glyphicon glyphicon-time"></span>
                          <a href="{{ url('sport/'.$sport->slug.'/'.$area->id.'/match/'.$match->id) }}">
                            Матч {{ $match->id }}
                            @if ($match->match_type == 'open')
                              <span class="pull-right label label-success">Открытая игра</span>
                            @else
                              <span class="pull-right label label-default">Закрытая игра</span>
                            @endif
                          </a>
                        </td>
                      @else
                        <td>
                          <span class="glyphicon glyphicon-refresh spin"></span> <span>В обработке</span>
                        </td>
                      @endif
                      <td>{{ $match->users_count.'/'.$match->number_of_players }}</td>
                      <td>{{ $match->price }} тг</td>
                    </tr>
                  @endif
                @endforeach

                @if ($game == false)
                  <?php $game = true; ?>
                  @foreach($field->schedules->where('week', $index_weekday) as $schedule)
                    @if ($schedule->start_time <= $hour AND $schedule->end_time >= $hour)
                      <tr id="{{ $id }}" class="bg-info">
                        <td class="hours">{{ $hour }}</td>
                        <td><span>Поле свободно</span></td>
                        <td>0</td>
                        <td>{{ $schedule->price }} тг</td>
                      </tr>
                    @endif
                  @endforeach
                @endif
              @endif
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
          channel = 'area-{{ $area->id }}_date-{{ $date }}';

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
        var startTime = data.startTime.split(':'),
            endTime = data.endTime.split(':'),
            cycle = +endTime[0] - +startTime[0],
            newRowId = null,
            rowId = null;

        console.log(data);

        if (data.status == 0) {

          for (var i = 0; i <= cycle; i++) {
            rowId = data.fieldId + '-' + data.date + '_' + +startTime[0];
            newRowId =
              '<tr id="' + rowId + '">' +
                '<td class="hours">' + startTime[0]++ + ':00</td>' +
                '<td><span class="glyphicon glyphicon-refresh"></span> <span>В обработке</span></td>' +
                '<td>' + data.usersCount + '/' + data.numberOfPlayers + '</td>' +
                '<td>' + data.price + ' тг</td>' +
              '</tr>';

            $('#' + rowId).replaceWith(newRowId);
          }

        } else if (data.status == 1) {

          var matchType = (data.matchType == 'open')
                ? '<span class="pull-right label label-success">Открытая игра</span>'
                : '<span class="pull-right label label-default">Закрытая игра</span>';

          for (var i = 0; i <= cycle; i++) {
            rowId = data.fieldId + '-' + data.date + '_' + +startTime[0];
            newRowId =
              '<tr id="' + rowId + '">' +
                '<td class="hours">' + startTime[0]++ + ':00</td>' +
                '<td><span class="glyphicon glyphicon-time"></span> <a href="/sport/' + data.sportSlug + '/' + data.areaId + '/match/' + data.id + '">Игра  ' + data.id + matchType + '</a></td>' +
                '<td>' + data.usersCount + '/' + data.numberOfPlayers + '</td>' +
                '<td>' + data.price + ' тг</td>' +
              '</tr>';

            $('#' + rowId).replaceWith(newRowId);
          }
        }
      });

      $(function () {
        $('[data-toggle="tooltip"]').tooltip()
      });
    </script>
@endsection
