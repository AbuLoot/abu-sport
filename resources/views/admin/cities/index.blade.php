@extends('admin.layouts')

@section('content')

    @include('partials.alerts')
    <p class="text-right">
      <a href="/admin/cities/create" class="btn btn-success btn-sm">Добавить</a>
    </p>
    <div class="table-responsive">
      <table class="table-admin table table-striped table-condensed">
        <thead>
          <tr class="active">
            <td>№</td>
            <td>Страна</td>
            <td>Название</td>
            <td>Номер</td>
            <td>Статус</td>
            <td class="text-right">Функции</td>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; ?>
          @forelse ($cities as $city)
            <tr>
              <td>{{ $i++ }}</td>
              <td>{{ $city->country->title }}</td>
              <td>{{ $city->title }}</td>
              <td>{{ $city->sort_id }}</td>
              @if ($city->status == 1)
                <td class="text-success">Активен</td>
              @else
                <td class="text-danger">Неактивен</td>
              @endif
              <td class="text-right">
                <a class="btn btn-primary btn-xs" href="{{ route('admin.cities.edit', $city->id) }}" title="Редактировать"><span class="glyphicon glyphicon-edit"></span></a>
                <form method="POST" action="{{ route('admin.cities.destroy', $city->id) }}" accept-charset="UTF-8" class="btn-delete">
                  <input name="_method" type="hidden" value="DELETE">
                  <input name="_token" type="hidden" value="{{ csrf_token() }}">
                  <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Удалить запись ({{ $city->title }})?')"><span class="glyphicon glyphicon-trash"></span></button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6">Нет записи</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

@endsection