@extends('layouts')

@section('title_description', '')

@section('meta_description', '')

@section('tabs')

    <ul class="tabs-panel">
      <li class="active"><a href="#">Создание матча</a></li>
    </ul>

@endsection

@section('content')

    @include('partials.alerts')

    <form action="/store-match" method="post">
      {!! csrf_field() !!}
      <div class="form-group">
        <label for="sport_id">Спорт</label>
        <select id="sport_id" name="sport_id" class="form-control" required>
          @foreach($sports as $sport)
            @if(old('sport_id') == $sport->id)
              <option value="{{ $sport->id }}" selected>{{ $sport->title }}</option>
            @else
              <option value="{{ $sport->id }}">{{ $sport->title }}</option>
            @endif
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label for="area_id">Площадки</label>
        <select id="area_id" name="area_id" class="form-control" required>
          @foreach($areas as $area)
            @if(old('area_id') == $area->id)
              <option value="{{ $area->id }}" selected>{{ $area->title }}</option>
            @else
              <option value="{{ $area->id }}">{{ $area->title }}</option>
            @endif
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label for="number_of_players">Количество игроков</label>
        <select id="number_of_players" name="number_of_players" class="form-control" required>
          <option value="10">10 игроков = 5 x 5</option>
          <option value="12">12 игроков = 6 x 6</option>
          <option value="14">14 игроков = 7 x 7</option>
          <option value="15">15 игроков = 5 x 5 x 5</option>
          <option value="16">16 игроков = 8 x 8</option>
          <option value="18">18 игроков = 9 x 9</option>
          <option value="20">20 игроков = 10 x 10</option>
          <option value="22">22 игроков = 11 x 11</option>
        </select>
      </div>
      <div class="form-group">
        <label>Тип матча</label><br>
        <label class="radio-inline">
          <input type="radio" name="match_type" id="match_type" value="closed"> Закрытый
        </label>
        <label class="radio-inline">
          <input type="radio" name="match_type" id="match_type" value="open" checked> Открытый
        </label>
      </div>
      <div class="form-group">
        <label for="date_time">Дата и время игры</label><br>
        <?php $current_hour = date('H').':00'; ?>
        <?php $current_week = (int) date('w'); ?>
        <?php $current_date = date('Y-m-d'); ?>

        @foreach($active_area->fields as $field)
          <h3>{{ $field->title }}</h3>
          <input type="hidden" name="field_id" value="{{ $field->id }}">

          <ul class="nav nav-tabs">
            <li @if (Request::is('create-match/1')) class="active" @endif><a href="{{ url('create-match/1') }}">1 День</a></li>
            <li @if (Request::is('create-match/3', 'create-match')) class="active" @endif><a href="{{ url('create-match/3') }}">3 дня</a></li>
            <li @if (Request::is('create-match/7')) class="active" @endif><a href="{{ url('create-match/7') }}">Неделя</a></li>
          </ul>

          <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered">
              <thead>
                <tr>
                  <th class="empty-th text-center h3">
                    <span class="glyphicon glyphicon-time"></span><br>&nbsp;
                  </th>
                  @foreach($days as $day)
                    @if ($current_date == $day['year'])
                      <th class="text-center bg-info" @if (Request::is('create-match/1', 'create-match', 'create-match/3')) colspan="2" @endif>{{ $day['day'] }}<br>{{$day['weekday'] }}<br></th>
                    @else
                      <th class="text-center" @if (Request::is('create-match/1', 'create-match', 'create-match/3')) colspan="2" @endif>{{ $day['day'] }}<br>{{$day['weekday'] }}<br></th>
                    @endif
                  @endforeach
                </tr>
              </thead>
              <tbody>
                @foreach(trans('data.hours') as $hour)
                  @continue($hour < $active_area->start_time)
                  <tr>
                    <td class="hours"><span>{{ $hour }}</span></td>

                    @foreach($days as $day)
                      @if (Request::is('create-match/1', 'create-match', 'create-match/3'))
                        <td>
                          @foreach($field->schedules->where('week', (int) $day['index_weekday']) as $schedule)
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
                          @if ($match->start_time <= $hour AND $match->end_time >= $hour)
                            <?php $game = true; ?>
                            @if ($match->status == 0)
                              <td>
                                <span class="glyphicon glyphicon-refresh"></span>
                                <span>В обработке</span>
                              </td>
                            @else
                              <td>
                                <span class="glyphicon glyphicon-time"></span>
                                <a href="{{ url('sport/match/'.$area->id.'/'.$match->id) }}">Игра {{ $match->id }}</a>
                              </td>
                            @endif
                          @endif
                        @endforeach

                        @if ($game == false)
                          @foreach($field->schedules->where('week', (int) $day['index_weekday']) as $schedule)
                            @if ($schedule->start_time <= $hour AND $schedule->end_time >= $hour)
                              <td>
                                <label class="checkbox-inline text-info">
                                  <input type="checkbox" name="hours[]" data-price="{{ $schedule->price }}" value="{{ $field->id.' '.$day['year'].' '.$hour }}"> Купить
                                </label>
                              </td>
                            @endif
                          @endforeach
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
      <div class="form-group text-center">
        <button type="submit" id="store" class="btn btn-primary"><span class="glyphicon glyphicon-time"></span> Забронировать время</button>
      </div>
    </form>
@endsection

@section('scripts')
    <script src="https://cdn.socket.io/socket.io-1.4.5.js"></script>
    <script>
      var socket = io(':6001'),
          user_id = '{{ Auth::id() }}',
          channel = 'area-{{ $active_area->id }}';

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
          console.log(data.match);
      });

      // Create match
      $('#store').click(function(e){
        e.preventDefault();

        var token = $('input[name="_token"]').val(),
            sport_id = $('#sport_id').val(),
            area_id = $('#area_id').val(),
            number_of_players = $('#number_of_players').val(),
            match_type = $('input[name="match_type"]').val(),
            hours = new Array(),
            price = new Array(),
            sum = 0;
            priceForEach = 0,
            balance = $('#balance').data('balance');

        $('input[name="hours[]"]:checked').each(function() {
          hours.push($(this).val());
          price.push($(this).data('price'));
        });

        // Check balance for payment
        for (var i = price.length; i--;) {
          sum += price[i];
        }

        priceForEach = sum / number_of_players;

        if (priceForEach > balance) {
          alert('У вас недостаточно денег для создания матча'.toUpperCase());
          $('input[name="hours[]"]:checked').prop('checked', false);
        }

        // Validation create match
        for (var i = 0; i < hours.length; i++) {
          var time = hours[i].split(' ');

          if (i >= 1) {
            var n = i - 1;
            var pastTime = hours[n].split(' ');

            if (time[0] != pastTime[0]) {
              alert('Матч должен состоятся в одном поле'.toUpperCase());
              $('input[name="hours[]"]:checked').prop('checked', false);
            }

            if (time[1] != pastTime[1]) {
              alert('Матч должен состоятся в один день'.toUpperCase());
              $('input[name="hours[]"]:checked').prop('checked', false);
            }

            var hour = time[2].split(':'),
                pastHour = pastTime[2].split(':');

            pastHour[0] = +pastHour[0] + 1;

            if (+hour[0] != +pastHour[0]) {
              alert('Выберите время последовательно'.toUpperCase());
              $('input[name="hours[]"]:checked').prop('checked', false);
            }
          }
        }

        if (hours != '') {
          $.ajax({
            type: "POST",
            url: '/store-match-ajax',
            dataType: "json",
            data: {
              '_token':token,
              'sport_id':sport_id,
              'area_id':area_id,
              'number_of_players':number_of_players,
              'match_type':match_type,
              'hours':hours
            },
            success: function(data) {
              if (data['errors'] != undefined) {
                for (var e = 0; e < data['errors'].length; e++) {
                  alert(data['errors'][e].toUpperCase());
                  console.log(data['errors']);
                }
              } else {
                console.log(data['success']);
              }
            }
          });
        } else {
          alert("Выберите время для игры!");
        }
      });

    </script>
@endsection
