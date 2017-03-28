@extends('admin.layouts')

@section('content')
      <div class="panel panel-default">
        <div class="panel-body">
          <h3>Редактирование</h3>

          @include('partials.alerts')

          <form action="{{ route('admin.roles.update', $role->id) }}" method="post">
            <input type="hidden" name="_method" value="PUT">
            {!! csrf_field() !!}

            <div class="form-group">
              <label for="name">Название</label>
              <input type="text" class="form-control" id="name" name="name" maxlength="80" value="{{ (old('name')) ? old('name') : $role->name }}" required>
            </div>
            <div class="form-group">
              <label for="label">Метка</label>
              <input type="text" class="form-control" id="label" name="label" maxlength="80" value="{{ (old('label')) ? old('label') : $role->label }}">
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary">Изменить</button>
            </div>
          </form>
        </div>
      </div>
@endsection
