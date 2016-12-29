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

        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#DateTime">Забронировать</button>

        <!-- Modal -->
        <div class="modal fade" id="DateTime" tabindex="-1" role="dialog" aria-labelledby="myDateTime">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
              </div>
              <div class="modal-body">

                <ul class="nav nav-tabs nav-justified">
                  <li role="presentation" class="active"><a href="#">24 Ср</a></li>
                  <li role="presentation"><a href="#">25 Чт</a></li>
                  <li role="presentation" ><a href="#">26 Пт</a></li>
                  <li role="presentation"><a href="#">27 Сб</a></li>
                  <li role="presentation" ><a href="#">28 Вс</a></li>
                  <li role="presentation"><a href="#">29 Пн</a></li>
                  <li role="presentation" ><a href="#">30 Вт</a></li>
                </ul>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
              </div>
            </div>
          </div>
        </div>


    <form action="{{ url('book-time') }}" method="post">
      {!! csrf_field() !!}
      <div class="form-group">
        <label for="city_id">Города</label>
        <select id="city_id" name="city_id" class="form-control" required>
          @foreach($cities as $city)
            @if(old('city_id') == $city->id)
              <option value="{{ $city->id }}" selected>{{ $city->title }}</option>
            @else
              <option value="{{ $city->id }}">{{ $city->title }}</option>
            @endif
          @endforeach
        </select>
      </div>
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
          <input type="radio" name="match_type" id="match_type"> Закрытый
        </label>
        <label class="radio-inline">
          <input type="radio" name="match_type" id="match_type" checked> Открытый
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
          <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
              <tbody>
                @foreach(trans('data.hours') as $hour)
                  <tr>
                    <td>{{ $hour }}</td>
                    <td>
                      @foreach($field->schedules->where('week', $current_week) as $schedule)
                        @if ($schedule->start_time <= $hour AND $schedule->end_time >= $hour)
                          {{ $schedule->price }}
                        @endif
                      @endforeach
                    </td>
                    <td>
                      @if ($current_hour >= $hour)
                        <?php $game = false; ?>
                        @foreach($field->matches->where('date', date('Y-m-d')) as $match)
                          @if ($match->start_time <= $hour AND $match->end_time >= $hour)
                            <span class="text-default">Игра состоялось</span>
                            <?php $game = true; ?>
                          @endif
                        @endforeach

                        @if ($game == false)
                          <span class="text-muted">Время прошло</span>
                        @endif
                      @else
                        <?php $game = false; ?>
                        @foreach($field->matches->where('date', date('Y-m-d')) as $match)
                          @if ($match->start_time <= $hour AND $match->end_time >= $hour)
                            <span class="text-success">Игра</span>
                            <?php $game = true; ?>
                          @endif
                        @endforeach

                        @if ($game == false)
                          <label class="checkbox-inline text-info">
                            <input type="checkbox" name="hours[]" value="{{ $hour }}"> Забронировать
                          </label>
                        @endif
                      @endif
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @endforeach

        @foreach($active_area->fields as $field)
          <h3>{{ $field->title }}</h3>
          <input type="hidden" name="field_id" value="{{ $field->id }}">
          <div class="table-responsive">
            <table class="table-calendar table-bordered">
              <thead>
                <tr>
                  <th></th>
                  @foreach($days as $day)
                    @if ($current_date == $day['year'])
                      <th class="bg-info">{{ $day['day'] }}<br>{{$day['weekday'] }}</th>
                    @else
                      <th>{{ $day['day'] }}<br>{{$day['weekday'] }}</th>
                    @endif
                  @endforeach
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="time-matches">
                    @foreach(trans('data.hours') as $hour)
                      <div><div>{{ $hour }}</div></div>
                    @endforeach
                  </td>
                  @foreach($days as $day)
                    <td class="status-matches">

                      @foreach(trans('data.hours') as $hour)

                        @if ($current_date >= $day['year'] AND $current_hour >= $hour)
                          <?php $game = false; ?>
                          @foreach($field->matches->where('date', $day['year']) as $match)
                            @if ($match->start_time <= $hour AND $match->end_time >= $hour)
                              <div class="bg-warning">
                                <div class="text-default">Игра состоялось</div>
                              </div>
                              <?php $game = true; ?>
                            @endif
                          @endforeach

                          @if ($game == false)
                            <div>
                              <div class="text-muted">Время прошло</div>
                            </div>
                          @endif
                        @else
                          <?php $game = false; ?>
                          @foreach($field->matches->where('date', $day['year']) as $num => $match)
                            @if ($match->start_time <= $hour AND $match->end_time >= $hour)
                              <div class="bg-success">
                                <div><a href="#">Игра</a></div>
                              </div>
                              <?php $game = true; ?>
                            @endif
                          @endforeach

                          @if ($game == false)
                            <div>
                              <label class="checkbox-inline text-info">
                                <input type="checkbox" name="hours[]" value="{{ $day['year'].' '.$hour }}"> Купить
                              </label>
                            </div>
                          @endif
                        @endif
                      @endforeach
                    </td>
                  @endforeach

                  <!-- <td class="status-matches">
                    <div>
                      <label class="checkbox-inline">
                        <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                      </label>
                    </div>
                    <div>
                      <div class="text-warning">Занят</div>
                    </div>
                    <div>
                      <div class="text-warning">Занят</div>
                    </div>
                    <div>
                      <label class="checkbox-inline">
                        <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                      </label>
                    </div>
                    <div>
                      <label class="checkbox-inline">
                        <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                      </label>
                    </div>
                    <div>
                      <div class="text-warning">Занят</div>
                    </div>
                    <div>
                      <div class="text-warning">Занят</div>
                    </div>
                    <div>
                      <div class="text-warning">Занят</div>
                    </div>
                    <div>
                      <div class="text-info">В процессе</div>
                    </div>
                    <div>
                      <label class="checkbox-inline">
                        <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                      </label>
                    </div>
                    <div>
                      <label class="checkbox-inline">
                        <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                      </label>
                    </div>
                    <div>
                      <label class="checkbox-inline">
                        <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                      </label>
                    </div>
                    <div>
                      <label class="checkbox-inline">
                        <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                      </label>
                    </div>
                    <div>
                      <label class="checkbox-inline">
                        <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                      </label>
                    </div>
                    <div>
                      <label class="checkbox-inline">
                        <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                      </label>
                    </div>
                    <div>
                      <label class="checkbox-inline">
                        <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                      </label>
                    </div>
                    <div>
                      <label class="checkbox-inline">
                        <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                      </label>
                    </div>
                    <div>
                      <label class="checkbox-inline">
                        <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                      </label>
                    </div>
                    <div>
                      <label class="checkbox-inline">
                        <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                      </label>
                    </div>
                    <div>
                      <label class="checkbox-inline">
                        <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                      </label>
                    </div>
                    <div>
                      <label class="checkbox-inline">
                        <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                      </label>
                    </div>
                    <div>
                      <label class="checkbox-inline">
                        <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                      </label>
                    </div>
                    <div>
                      <label class="checkbox-inline">
                        <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                      </label>
                    </div>
                  </td> -->
                </tr>
              </tbody>
            </table>
          </div>
        @endforeach

      </div>
      <div class="form-group">
        <label>Дата и время игры</label><br>
        <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-time"></span> Забронировать время</button>
      </div>
    </form>

@endsection
