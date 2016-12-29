@extends('layouts')

@section('title_description', '')

@section('meta_description', '')

@section('tabs')

  <ul class="tabs-panel">
    <li class="active"><a href="#">Мои Матчи</a></li>
  </ul>

@endsection

@section('content')

  <div class="col-lg-8 col-md-8 col-sm-12">
    @include('partials.alerts')

    <div>
      <?php $current_hour = date('H').':00'; ?>
      <?php $current_week = (int) date('w'); ?>
      <?php $current_date = date('Y-m-d'); ?>

      <div class="table-responsive">
        <table class="table table-hover table-bordered">
          <thead>
            <tr>
              <th>Номер</th>
              <th>Игроки</th>
              <th>Цена</th>
              <th>Цена за игрока</th>
              <th>Время старта</th>
            </tr>
          </thead>
          <tbody>
            @foreach(Auth::user()->matches->sortByDesc('date') as $match)
              @if ($current_date >= $match->date)
                <tr>
                  <td>
                    <span class="match-link">
                      Матч {{ $match->id }}
                      <span class="pull-right label label-default">Конец игры</span>
                    </span>
                    @if ($match->user_id == Auth::id()) <b>Вы организатор</b> @endif
                  </td>
                  <td>{{ $match->users->count().'/'.$match->number_of_players }}</td>
                  <td>{{ $match->price }}</td>
                  <td>{{ $match->priceForEach }}</td>
                  <td>{{ $match->matchDate }}. Время: {{ $match->start_time.' - '.$match->end_time }}</td>
                </tr>
              @else
                <tr>
                  <td>
                    <a class="match-link" href="{{ url('sport/'.$match->field->area->sport->slug.'/'.$match->field->area_id.'/match/'.$match->id) }}">
                      Матч {{ $match->id }}
                      @if ($match->match_type == 'open')
                        <span class="pull-right label label-success">Открытая игра</span>
                      @else
                        <span class="pull-right label label-default">Закрытая игра</span>
                      @endif
                    </a>
                    @if ($match->user_id == Auth::id()) <b>Вы организатор</b> @endif
                  </td>
                  <td>{{ $match->users->count().'/'.$match->number_of_players }}</td>
                  <td>{{ $match->price }}</td>
                  <td>{{ $match->priceForEach }}</td>
                  <td>{{ $match->matchDate }}. Время: {{ $match->start_time.' - '.$match->end_time }}</td>
                </tr>
              @endif
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

@endsection