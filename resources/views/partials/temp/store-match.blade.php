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

    <form action="{{ url('store-match') }}" method="post">
      {!! csrf_field() !!}

      <div class="form-group">
        <label for="date_time">Дата и время игры</label><br>
        <?php $current_hour = date('H').':00'; ?>
        <?php $current_week = date('w'); ?>

        @foreach($area->fields as $number => $field)
          <h3>{{ $field->title }}</h3>
          <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
              <tbody>
                @foreach($field->schedules as $key => $schedule)
                  <?php $hours = collect(trans('data.hours')); ?>
                  @foreach($hours->splice(6, 9) as $hour)
                    <tr>
                      <td>{{ $hour }} {{ $number . ' - ' . $key }}</td>
                      <td>
                        @if ($schedule->start_time <= $hour AND $schedule->end_time >= $hour)
                          {{ $schedule->price }}
                        @endif
                      </td>
                      <td>
                        @if ($current_hour >= $hour)
                          <span class="text-muted">Время прошло</span>
                        @else
                          <label class="checkbox-inline text-success">
                            <input type="checkbox" name="hours[]" value="{{ $hour }}"> Забронировать
                          </label>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                @endforeach
              </tbody>
            </table>
          </div>
        @endforeach

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
      </div>
      <div class="form-group">
        <label>Дата и время игры</label><br>
        <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-time"></span> Забронировать время</button>
      </div>
    </form>

@endsection