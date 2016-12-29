@extends('admin.layouts')

@section('content')
      <div class="panel panel-default">
        <div class="panel-body">
          <h3>Создание</h3>

          @include('partials.alerts')

          <form action="{{ route('admin.schedules.store') }}" method="post">
            {!! csrf_field() !!}
            <div class="form-group">
              <label for="sort_id">Номер</label>
              <input type="text" class="form-control" id="sort_id" name="sort_id" maxlength="5" value="{{ (old('sort_id')) ? old('sort_id') : NULL }}">
            </div>
            <div class="form-group">
              <label for="field_id">Поля Площадок</label>
              <select id="field_id" name="field_id" class="form-control">
                <option value=""></option>
                @foreach($areas as $area)
                  <optgroup label="{{ $area->title }}">
                    @foreach($area->fields as $field)
                      @if (old('field_id') == $field->id)
                        <option value="{{ $field->id }}" selected>{{ $field->title }}</option>
                      @else
                        <option value="{{ $field->id }}">{{ $field->title }}</option>
                      @endif
                    @endforeach
                  </optgroup>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="start_time">Начало времени</label>
              <select id="start_time" name="start_time" class="form-control">
                @foreach(trans('data.hours') as $hour)
                  @if (old('start_time') === $hour)
                    <option value="{{ $hour }}" selected>{{ $hour }}</option>
                  @else
                    <option value="{{ $hour }}">{{ $hour }}</option>
                  @endif
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="end_time">Конец времени</label>
              <select id="end_time" name="end_time" class="form-control">
                @foreach(trans('data.hours') as $hour)
                  @if (old('start_time') === $hour)
                    <option value="{{ $hour }}" selected>{{ $hour }}</option>
                  @else
                    <option value="{{ $hour }}">{{ $hour }}</option>
                  @endif
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="date">Дата</label>
              <input type="date" class="form-control" id="date" name="date" maxlength="5" value="{{ (old('date')) ? old('date') : '' }}">
            </div>
            <div class="form-group">
              <label for="week">День недели</label>
              <select id="week" name="week" class="form-control">
                @foreach(trans('data.week') as $key => $day)
                  @if (old('week') == $key)
                    <option value="{{ $key }}" selected>{{ $day }}</option>
                  @else
                    <option value="{{ $key }}">{{ $day }}</option>
                  @endif
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="price">Цена</label>
              <input type="text" class="form-control" id="price" name="price" maxlength="80" value="{{ (old('price')) ? old('price') : '' }}" required>
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
