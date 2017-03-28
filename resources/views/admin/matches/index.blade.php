@extends('admin.layouts')

@section('content')

    @include('partials.alerts')
    <div class="table-responsive">
      <table class="table-admin table table-striped table-condensed">
        <thead>
          <tr class="active">
            <td>№</td>
            <td>Площадка</td>
            <td>Поле</td>
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
          <?php $i = 1; ?>
          @forelse ($matches as $match)
            <tr>
              <td>{{ $i++ }}</td>
              <td>{{ $match->field->area->title }}</td>
              <td>{{ $match->field->title }}</td>
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
                <a class="btn btn-primary btn-xs" href="{{ route('admin.matches.edit', $match->id) }}" title="Редактировать"><span class="glyphicon glyphicon-edit"></span></a>
                <form method="POST" action="{{ route('admin.matches.destroy', $match->id) }}" accept-charset="UTF-8" class="btn-delete">
                  <input name="_method" type="hidden" value="DELETE">
                  <input name="_token" type="hidden" value="{{ csrf_token() }}">
                  <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Удалить запись ({{ $match->title }})?')"><span class="glyphicon glyphicon-trash"></span></button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="10">Нет записи</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

@endsection