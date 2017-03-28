@extends('admin.layouts')

@section('content')

    @include('partials.alerts')
    <p class="text-right">
      <a href="/admin/areas/create" class="btn btn-success btn-sm">Добавить</a>
    </p>
    <div class="table-responsive">
      <table class="table-admin table table-striped table-condensed">
        <thead>
          <tr class="active">
            <td>№</td>
            <td>Название</td>
            <td>Номер</td>
            <td>Организация</td>
            <td>Спорт</td>
            <td>Статус</td>
            <td class="text-right">Функции</td>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; ?>
          @forelse ($areas as $area)
            <tr>
              <td>{{ $i++ }}</td>
              <td>{{ $area->title }}</td>
              <td>{{ $area->sort_id }}</td>
              <td>{{ $area->organization->title }}</td>
              <td>{{ $area->sport->title }}</td>
              @if ($area->status == 1)
                <td class="text-success">Активен</td>
              @else
                <td class="text-danger">Неактивен</td>
              @endif
              <td class="text-right">
                <a class="btn btn-primary btn-xs" href="{{ route('admin.areas.edit', $area->id) }}" title="Редактировать"><span class="glyphicon glyphicon-edit"></span></a>
                <form method="POST" action="{{ route('admin.areas.destroy', $area->id) }}" accept-charset="UTF-8" class="btn-delete">
                  <input name="_method" type="hidden" value="DELETE">
                  <input name="_token" type="hidden" value="{{ csrf_token() }}">
                  <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Удалить запись ({{ $area->title }})?')"><span class="glyphicon glyphicon-trash"></span></button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7">Нет записи</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

@endsection