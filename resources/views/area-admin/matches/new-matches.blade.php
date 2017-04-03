@extends('area-admin.layouts')

@section('content')

    @include('partials.alerts')

    <ul class="nav nav-tabs" role="tablist">
      <li @if (Request::is('panel/admin-matches', 'panel/admin-matches/new-matches')) class="active" @endif><a href="{{ url('panel/admin-matches/new-matches') }}">Новые матчи</a></li>
      <li @if (Request::is('panel/admin-matches/today')) class="active" @endif><a href="{{ url('panel/admin-matches/today') }}">Сегодня</a></li>
      <li @if (Request::is('panel/admin-matches/comming')) class="active" @endif><a href="{{ url('panel/admin-matches/comming') }}">Предстоящие</a></li>
      <li @if (Request::is('panel/admin-matches/past')) class="active" @endif><a href="{{ url('panel/admin-matches/past') }}">Прошедшее</a></li>
      <li @if (Request::is('panel/admin-matches/all')) class="active" @endif><a href="{{ url('panel/admin-matches/all') }}">Все</a></li>
    </ul>

    <div class="table-responsive">
      <table class="table table-striped table-condensed">
        <thead>
          <tr class="active">
            <td>Матч</td>
            <td>Организатор</td>
            <td>Дата</td>
            <td>Время</td>
            <td>Кол. Игроков</td>
            <td>Цена</td>
            <td>Тип матча</td>
            <td>Статус</td>
            <td class="text-right">Функции</td>
          </tr>
        </thead>
        <tbody>
          @forelse ($area->fields as $field)
            <tr>
              <th colspan="9">{{ $field->title }}</th>
            </tr>
            @forelse ($matches[$field->id] as $match)
              <tr id="match-{{ $match->id }}">
                <td>Матч {{ $match->id }}</td>
                <td><a href="/user-profile/{{ $match->user->id }}">{{ $match->user->surname . ' ' . $match->user->name }}</a></td>
                <td>{{ $match->date }}</td>
                <td>{{ $match->start_time.' - '.$match->end_time }}</td>
                <td>{{ $match->number_of_players }}</td>
                <td>{{ $match->price }}тг</td>
                <td>
                  @if ($match->match_type == 'open')
                    <span class="label label-success">Открытая</span>
                  @else
                    <span class="label label-default">Закрытая</span>
                  @endif
                </td>
                @if ($match->status == 1)
                  <td class="text-success">Активен</td>
                @else
                  <td class="text-danger">Неактивен</td>
                @endif
                <td class="text-right">
                  <a class="btn btn-primary btn-xs" id="run" href="{{ url('panel/admin-matches/'.$match->field_id.'-'.$match->id.'/start') }}" data-match-id="{{ $match->field_id . '-' . $match->id }}" title="Запустить"><span class="glyphicon glyphicon-play"></span></a>
                  <form method="POST" action="{{ url('panel/admin-matches/'.$match->id) }}" accept-charset="UTF-8" class="btn-delete">
                    <input name="_method" type="hidden" value="DELETE">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                    <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Удалить запись ({{ $match->id }})?')"><span class="glyphicon glyphicon-trash"></span></button>
                  </form>
                </td>
              </tr>
            @endforeach
            <tr id="tr-{{ $field->id }}"></tr>
          @endforeach
        </tbody>
      </table>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.socket.io/socket.io-1.4.5.js"></script>
    <script>
      var socket = io(':6001'),
          channel = 'admin-area-{{ $area->id }}';

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

          var matchType = (data.matchType == 'open') ? '<span class="label label-success">Открытая</span>' : '<span class="label label-default">Закрытая</span>';
          var newMatch = 
              '<tr id="match-' + data.id + '">' +
                '<td>Матч ' + data.id + '</td>' +
                '<td><a href="/user-profile/' + data.userId + '">' + data.fullName + '</a></td>' +
                '<td>' + data.date + '</td>' +
                '<td>' + data.startTime + ' - ' + data.endTime + '</td>' +
                '<td>' + data.numberOfPlayers + '</td>' +
                '<td>' + data.price + 'тг</td>' +
                '<td>' + matchType + '</td>' +
                '<td class="text-danger">Неактивен</td>' +
                '<td class="text-right">' +
                  '<a class="btn btn-primary btn-xs" id="run" href="/panel/admin-matches/' + data.fieldId + '-' + data.id + '/start" data-match-id="' + data.fieldId + '-' + data.id + '" title="Запустить"><span class="glyphicon glyphicon-play"></span></a>' +
                '</td>' +
              '</tr>';

          $(newMatch).insertAfter($('#tr-' + data.fieldId));

        console.log(data);
      });

      // Create match
      $('table').on('click', 'a#run', function(e){
        e.preventDefault();

        // alert($(this).data('match-id'));
        // return null;

        var matchId = $(this).data('match-id'),
            arrMatchID = matchId.split('-');

        if (matchId != null) {
          var $btn = $(this).button('Запуск');
          $.ajax({
            type: "GET",
            url: '/panel/admin-matches-ajax/' + matchId,
            dataType: "json",
            success: function(data) {
              if (data['errors'] != undefined) {
                for (var e = 0; e < data['errors'].length; e++) {
                  alert(data['errors'][e].toUpperCase());
                  console.log(data['errors']);
                  $btn.button('reset');
                }
              } else {
                $('#match-'+arrMatchID[1]).remove();
                console.log(data['success']);
                alert(data['success']);
                $btn.button('reset');
              }
            }
          });
        } else {
          alert("Матч не запущен");
        }
      });

    </script>
@endsection
