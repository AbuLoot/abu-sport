@extends('admin.layouts')

@section('content')
      <div class="panel panel-default">
        <div class="panel-body">
          <h3>Создание</h3>

          @include('partials.alerts')

          <form action="{{ route('admin.permissions.store') }}" method="post">
            {!! csrf_field() !!}
            <div class="form-group">
              <label for="title">Название</label>
              <input type="text" class="form-control" id="title" name="title" maxlength="80" value="{{ (old('title')) ? old('title') : '' }}" required>
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
