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
            <td>Игроки</td>
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
              <tr>
                <td>Матч {{ $match->id }}</td>
                <td>{{ $match->user->name }}</td>
                <td>{{ $match->date }}</td>
                <td>{{ $match->start_time.' - '.$match->end_time }}</td>
                <td><b>{{ 1 + $match->users->count() }}</b>/{{ $match->number_of_players }}</td>
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
                  <a class="btn btn-primary btn-xs" href="{{ url('panel/admin-matches/'.$match->id.'/edit') }}" title="Редактировать"><span class="glyphicon glyphicon-edit"></span></a>
                  <form method="POST" action="{{ url('panel/admin-matches/'.$match->id) }}" accept-charset="UTF-8" class="btn-delete">
                    <input name="_method" type="hidden" value="DELETE">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                    <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Удалить запись ({{ $match->id }})?')"><span class="glyphicon glyphicon-trash"></span></button>
                  </form>
                </td>
              </tr>
            @endforeach
            <tr>
              <td colspan="10">
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
@endsection