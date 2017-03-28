@extends('admin.layouts')

@section('content')
      <div class="panel panel-default">
        <div class="panel-body">
          <h3>Создание</h3>

          @include('partials.alerts')

          <form action="{{ route('admin.fields.store') }}" method="post">
            {!! csrf_field() !!}
            <div class="form-group">
              <label for="title">Название</label>
              <input type="text" class="form-control" id="title" name="title" minlength="5" maxlength="80" value="{{ (old('title')) ? old('title') : '' }}" required>
            </div>
            <div class="form-group">
              <label for="sort_id">Номер</label>
              <input type="text" class="form-control" id="sort_id" name="sort_id" maxlength="5" value="{{ (old('sort_id')) ? old('sort_id') : NULL }}">
            </div>
            <div class="form-group">
              <label for="area_id">Площадки</label>
              <select id="area_id" name="area_id" class="form-control" required>
                <option value=""></option>
                @foreach($areas as $area)
                  <option value="{{ $area->id }}">{{ $area->title }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="options_id">Опции</label>
              <select id="options_id" name="options_id[]" class="form-control" multiple>
                <option value=""></option>
                @foreach($options as $option)
                  <option value="{{ $option->id }}">{{ $option->title }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="size">Размер</label>
              <input type="text" class="form-control" id="size" name="size" maxlength="5" value="{{ (old('size')) ? old('size') : '' }}">
            </div>
            <div class="form-group">
              <label for="status">Статус:</label>
              <label>
                <input type="checkbox" id="status" name="status" checked> Активен
              </label>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary">Создать</button>
            </div>
          </form>
        </div>
      </div>
@endsection
