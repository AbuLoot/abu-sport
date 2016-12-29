@extends('area-admin.layouts')

@section('content')

    @include('partials.alerts')
    <p class="text-right">
      <a href="/panel/admin-schedules/create" class="btn btn-success btn-sm">Добавить</a>
    </p>
    <div class="table-responsive">
      <table class="table table-striped table-condensed">
        <thead>
          <tr class="active">
            <td>День недели</td>
            <td>Начало и конец времени</td>
            <td>Цена</td>
            <td>Дата</td>
            <td>Статус</td>
            <td class="text-right">Функции</td>
          </tr>
        </thead>
        <tbody>
          @forelse ($fields as $field)
            <tr>
              <th colspan="6">{{ $field->title }}</th>
            </tr>
            @forelse ($field->schedules as $schedule)
              <tr>
                <td>{{ trans('data.week.'.$schedule->week) }}</td>
                <td>{{ $schedule->start_time.' - '.$schedule->end_time }}</td>
                <td>{{ $schedule->price }}</td>
                <td>{{ $schedule->date }}</td>
                @if ($schedule->status == 1)
                  <td class="text-success">Активен</td>
                @else
                  <td class="text-danger">Неактивен</td>
                @endif
                <td class="text-right">
                  <a class="btn btn-primary btn-xs" href="{{ route('panel.admin-schedules.edit', $schedule->id) }}" title="Редактировать"><span class="glyphicon glyphicon-edit"></span></a>
                  <form method="POST" action="{{ route('panel.admin-schedules.destroy', $schedule->id) }}" accept-charset="UTF-8" class="btn-delete">
                    <input name="_method" type="hidden" value="DELETE">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                    <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Удалить запись ({{ $schedule->title }})?')"><span class="glyphicon glyphicon-trash"></span></button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6">Нет записи</td>
              </tr>
            @endforelse
          @empty
            <tr>
              <td colspan="6">Нет записи</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

@endsection