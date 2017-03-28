@extends('admin.layouts')

@section('content')

    @include('partials.alerts')
    <p class="text-right">
      <a href="/admin/options/create" class="btn btn-success btn-sm">Добавить</a>
    </p>
    <div class="table-responsive">
      <table class="table-admin table table-striped table-condensed">
        <thead>
          <tr class="active">
            <td>№</td>
            <td>URI</td>
            <td>Название</td>
            <td>Номер</td>
            <td class="text-right">Функции</td>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; ?>
          @forelse ($options as $option)
            <tr>
              <td>{{ $i++ }}</td>
              <td>{{ $option->slug }}</td>
              <td>{{ $option->title }}</td>
              <td>{{ $option->sort_id }}</td>
              <td class="text-right">
                <a class="btn btn-primary btn-xs" href="{{ route('admin.options.edit', $option->id) }}" title="Редактировать"><span class="glyphicon glyphicon-edit"></span></a>
                <form method="POST" action="{{ route('admin.options.destroy', $option->id) }}" accept-charset="UTF-8" class="btn-delete">
                  <input name="_method" type="hidden" value="DELETE">
                  <input name="_token" type="hidden" value="{{ csrf_token() }}">
                  <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Удалить запись ({{ $option->title }})?')"><span class="glyphicon glyphicon-trash"></span></button>
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