@extends('admin.layouts')

@section('content')

    @include('partials.alerts')
    <p class="text-right">
      <a href="/admin/countries/create" class="btn btn-success btn-sm">Добавить</a>
    </p>
    <div class="table-responsive">
      <table class="table-admin table table-striped table-condensed">
        <thead>
          <tr class="active">
            <td>№</td>
            <td>Название</td>
            <td>Номер</td>
            <td>Статус</td>
            <td class="text-right">Функции</td>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; ?>
          @forelse ($countries as $country)
            <tr>
              <td>{{ $i++ }}</td>
              <td>{{ $country->title }}</td>
              <td>{{ $country->sort_id }}</td>
              @if ($country->status == 1)
                <td class="text-success">Активен</td>
              @else
                <td class="text-danger">Неактивен</td>
              @endif
              <td class="text-right">
                <a class="btn btn-primary btn-xs" href="{{ route('admin.countries.edit', $country->id) }}" title="Редактировать"><span class="glyphicon glyphicon-edit"></span></a>
                <form method="POST" action="{{ route('admin.countries.destroy', $country->id) }}" accept-charset="UTF-8" class="btn-delete">
                  <input name="_method" type="hidden" value="DELETE">
                  <input name="_token" type="hidden" value="{{ csrf_token() }}">
                  <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Удалить запись ({{ $country->title }})?')"><span class="glyphicon glyphicon-trash"></span></button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5">Нет записи</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

@endsection