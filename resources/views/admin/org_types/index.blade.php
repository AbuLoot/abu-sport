@extends('admin.layouts')

@section('content')

    @include('partials.alerts')
    <p class="text-right">
      <a href="/admin/org_types/create" class="btn btn-success btn-sm">Добавить</a>
    </p>
    <div class="table-responsive">
      <table class="table-admin table table-striped table-condensed">
        <thead>
          <tr class="active">
            <td>№</td>
            <td>Аббревиатура</td>
            <td>Название</td>
            <td>Номер</td>
            <td class="text-right">Функции</td>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; ?>
          @forelse ($org_types as $org_type)
            <tr>
              <td>{{ $i++ }}</td>
              <td>{{ $org_type->short_title }}</td>
              <td>{{ $org_type->title }}</td>
              <td>{{ $org_type->sort_id }}</td>
              <td class="text-right">
                <a class="btn btn-primary btn-xs" href="{{ route('admin.org_types.edit', $org_type->id) }}" title="Редактировать"><span class="glyphicon glyphicon-edit"></span></a>
                <form method="POST" action="{{ route('admin.org_types.destroy', $org_type->id) }}" accept-charset="UTF-8" class="btn-delete">
                  <input name="_method" type="hidden" value="DELETE">
                  <input name="_token" type="hidden" value="{{ csrf_token() }}">
                  <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Удалить запись ({{ $org_type->title }})?')"><span class="glyphicon glyphicon-trash"></span></button>
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