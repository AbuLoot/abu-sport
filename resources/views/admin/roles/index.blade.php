@extends('admin.layouts')

@section('content')

    @include('partials.alerts')
    <p class="text-right">
      <a href="/admin/roles/create" class="btn btn-success btn-sm">Добавить</a>
    </p>
    <div class="table-responsive">
      <table class="table-admin table table-striped table-condensed">
        <thead>
          <tr class="active">
            <td>№</td>
            <td>Название</td>
            <td>Метка</td>
            <td class="text-right">Функции</td>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; ?>
          @forelse ($roles as $role)
            <tr>
              <td>{{ $i++ }}</td>
              <td>{{ $role->name }}</td>
              <td>{{ $role->label }}</td>
              <td class="text-right">
                <a class="btn btn-primary btn-xs" href="{{ route('admin.roles.edit', $role->id) }}" title="Редактировать"><span class="glyphicon glyphicon-edit"></span></a>
                <form method="POST" action="{{ route('admin.roles.destroy', $role->id) }}" accept-charset="UTF-8" class="btn-delete">
                  <input name="_method" type="hidden" value="DELETE">
                  <input name="_token" type="hidden" value="{{ csrf_token() }}">
                  <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Удалить запись ({{ $role->title }})?')"><span class="glyphicon glyphicon-trash"></span></button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4">Нет записи</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

@endsection