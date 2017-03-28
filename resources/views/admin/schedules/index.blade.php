@extends('admin.layouts')

@section('content')

    @include('partials.alerts')
    <p class="text-right">
      <a href="/admin/schedules/create" class="btn btn-success btn-sm">Добавить</a>
    </p>
    <div class="table-responsive">
      <table class="table-admin table table-striped table-condensed">
        <thead>
          <tr class="active">
            <td>№</td>
            <td>Площадка</td>
            <td>Поле</td>
            <td>Начало времени</td>
            <td>Конец времени</td>
            <td>Дата</td>
            <td>День недели</td>
            <td>Цена</td>
            <td>Статус</td>
            <td class="text-right">Функции</td>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; ?>
          @forelse ($schedules as $schedule)
            <tr>
              <td>{{ $i++ }}</td>
              <td>{{ $schedule->field->area->title }}</td>
              <td>{{ $schedule->field->title }}</td>
              <td>{{ $schedule->start_time }}</td>
              <td>{{ $schedule->end_time }}</td>
              <td>{{ $schedule->date }}</td>
              <td>{{ trans('data.week.'.$schedule->week) }}</td>
              <td>{{ $schedule->price }}</td>
              @if ($schedule->status == 1)
                <td class="text-success">Активен</td>
              @else
                <td class="text-danger">Неактивен</td>
              @endif
              <td class="text-right">
                <a class="btn btn-primary btn-xs" href="{{ route('admin.schedules.edit', $schedule->id) }}" title="Редактировать"><span class="glyphicon glyphicon-edit"></span></a>
                <form method="POST" action="{{ route('admin.schedules.destroy', $schedule->id) }}" accept-charset="UTF-8" class="btn-delete">
                  <input name="_method" type="hidden" value="DELETE">
                  <input name="_token" type="hidden" value="{{ csrf_token() }}">
                  <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Удалить запись ({{ $schedule->title }})?')"><span class="glyphicon glyphicon-trash"></span></button>
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