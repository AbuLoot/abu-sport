@extends('admin.layouts')

@section('content')
      <div class="panel panel-default">
        <div class="panel-body">
          <h3>Создание</h3>

          @include('partials.alerts')

          <form action="{{ route('admin.roles.store') }}" method="post">
            {!! csrf_field() !!}
            <div class="form-group">
              <label for="name">Название</label>
              <input type="text" class="form-control" id="name" name="name" maxlength="80" value="{{ (old('name')) ? old('name') : '' }}" required>
            </div>
            <div class="form-group">
              <label for="label">Метка</label>
              <input type="text" class="form-control" id="label" name="label" maxlength="80" value="{{ (old('label')) ? old('label') : '' }}">
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary">Создать</button>
            </div>
          </form>
        </div>
      </div>
@endsection
