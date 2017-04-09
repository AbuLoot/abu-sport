@extends('area-admin.layouts')

@section('content')
      <div class="panel panel-default">
        <div class="panel-body">
          <h3>Редактирование</h3>

          @include('partials.alerts')

          <form action="{{ route('admin.fields.update', $field->id) }}" method="post">
            <input type="hidden" name="_method" value="PUT">
            {!! csrf_field() !!}

            <div class="form-group">
              <label for="title">Название</label>
              <input type="text" class="form-control" id="title" name="title" minlength="5" maxlength="80" value="{{ (old('title')) ? old('title') : $field->title }}" required>
            </div>
            <div class="form-group">
              <label for="sort_id">Номер</label>
              <input type="text" class="form-control" id="sort_id" name="sort_id" maxlength="5" value="{{ (old('sort_id')) ? old('sort_id') : $field->sort_id }}">
            </div>
            <div class="form-group">
              <label for="area_id">Площадки</label>
              <select id="area_id" name="area_id" class="form-control" required>
                <option value=""></option>
                @foreach($areas as $area)
                  @if ($area->id == $field->area_id)
                    <option value="{{ $area->id }}" selected>{{ $area->title }}</option>
                  @else
                    <option value="{{ $area->id }}">{{ $area->title }}</option>
                  @endif
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="options_id">Опции</label>
              <select id="options_id" name="options_id[]" class="form-control" multiple>
                <option value=""></option>
                @foreach($options as $option)
                  @if (in_array($option->id, $field->options->lists('id')->toArray()))
                    <option value="{{ $option->id }}" selected>{{ $option->title }}</option>
                  @else
                    <option value="{{ $option->id }}">{{ $option->title }}</option>
                  @endif
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="size">Размер</label>
              <input type="text" class="form-control" id="size" name="size" maxlength="5" value="{{ (old('size')) ? old('size') : $field->size }}">
            </div>
            <div class="form-group">
              <label for="images">Галерея</label><br>
              <?php $images = unserialize($field->images); ?>
              @for ($i = 0; $i < 4; $i++)
                @if (isset($images[$i]))
                  <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-new thumbnail" style="width:300px;height:200px;">
                      <img src="/img/organizations/{{ $field->org_id.'/'.$images[$i]['mini_image'] }}">
                    </div>
                    <div class="fileinput-preview fileinput-exists thumbnail" style="width:300px;height:200px;" data-trigger="fileinput"></div>
                    <div>
                      <span class="btn btn-default btn-sm btn-file">
                        <span class="fileinput-new"><i class="glyphicon glyphicon-folder-open"></i>&nbsp; Изменить</span>
                        <span class="fileinput-exists"><i class="glyphicon glyphicon-folder-open"></i>&nbsp;</span>
                        <input type="file" name="images[]" accept="image/*">
                      </span>
                      <a href="#" class="btn btn-default btn-sm fileinput-exists" data-dismiss="fileinput"><i class="glyphicon glyphicon-trash"></i> Удалить</a>
                    </div>
                  </div>
                @else
                  <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-preview thumbnail" style="width:300px;height:200px;" data-trigger="fileinput"></div>
                    <div>
                      <span class="btn btn-default btn-sm btn-file">
                        <span class="fileinput-new"><i class="glyphicon glyphicon-folder-open"></i>&nbsp; Выбрать</span>
                        <span class="fileinput-exists"><i class="glyphicon glyphicon-folder-open"></i>&nbsp;</span>
                        <input type="file" name="images[]" accept="image/*">
                      </span>
                      <a href="#" class="btn btn-default btn-sm fileinput-exists" data-dismiss="fileinput"><i class="glyphicon glyphicon-trash"></i> Удалить</a>
                    </div>
                  </div>
                @endif
              @endfor
            </div>
            <div class="form-group">
              <label for="status">Статус:</label>
              <label>
                <input type="checkbox" id="status" name="status" @if ($field->status == 1) checked @endif> Активен
              </label>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary">Изменить</button>
            </div>
          </form>
        </div>
      </div>
@endsection

@section('styles')
  <link href="/css/jasny-bootstrap.min.css" rel="stylesheet">
@endsection

@section('scripts')
  <script src="/js/jasny-bootstrap.js"></script>
@endsection