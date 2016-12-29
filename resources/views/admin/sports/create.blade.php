@extends('admin.layouts')

@section('content')
      <div class="panel panel-default">
        <div class="panel-body">
          <h3>Создание</h3>

          @include('partials.alerts')

          <form action="{{ route('admin.sports.store') }}" method="post" enctype="multipart/form-data">
            {!! csrf_field() !!}
            <div class="form-group">
              <label for="title">Название</label>
              <input type="text" class="form-control" id="title" name="title" minlength="5" maxlength="80" value="{{ (old('title')) ? old('title') : '' }}" required>
            </div>
            <div class="form-group">
              <label for="slug">Slug</label>
              <input type="text" class="form-control" id="slug" name="slug" minlength="2" maxlength="80" value="{{ (old('slug')) ? old('slug') : '' }}">
            </div>
            <div class="form-group">
              <label for="sort_id">Номер</label>
              <input type="text" class="form-control" id="sort_id" name="sort_id" maxlength="5" value="{{ (old('sort_id')) ? old('sort_id') : NULL }}">
            </div>
            <div class="form-group">
              <label for="image">Картинка:</label><br>
              <div class="fileinput fileinput-new" data-provides="fileinput">
                <div class="fileinput-new thumbnail" style="width:300px;height:200px;"></div>
                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width:300px;max-height:200px;"></div>
                <div>
                  <span class="btn btn-default btn-sm btn-file">
                    <span class="fileinput-new"><i class="glyphicon glyphicon-folder-open"></i>&nbsp; Выбрать</span>
                    <span class="fileinput-exists"><i class="glyphicon glyphicon-folder-open"></i>&nbsp;</span>
                    <input type="file" name="image" accept="image/*" required>
                  </span>
                  <a href="#" class="btn btn-default btn-sm fileinput-exists" data-dismiss="fileinput"><i class="glyphicon glyphicon-trash"></i> Удалить</a>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="title_description">Мета название</label>
              <input type="text" class="form-control" id="title_description" name="title_description" maxlength="255" value="{{ (old('title_description')) ? old('title_description') : '' }}">
            </div>
            <div class="form-group">
              <label for="meta_description">Мета описание</label>
              <input type="text" class="form-control" id="meta_description" name="meta_description" maxlength="255" value="{{ (old('meta_description')) ? old('meta_description') : '' }}">
            </div>
            <div class="form-group">
              <label for="content">Текст</label>
              <textarea class="form-control" id="content" name="content" rows="5">{{ (old('content')) ? old('content') : '' }}</textarea>
            </div>
            <div class="form-group">
              <label for="rules">Правила</label>
              <textarea class="form-control" id="rules" name="rules" rows="5">{{ (old('rules')) ? old('rules') : '' }}</textarea>
            </div>
            <div class="form-group">
              <label for="lang">Язык</label>
              <input type="text" class="form-control" id="lang" name="lang" maxlength="255" value="{{ (old('lang')) ? old('lang') : '' }}">
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

@section('styles')
  <link href="/css/jasny-bootstrap.min.css" rel="stylesheet">
@endsection

@section('scripts')
  <script src="/js/jasny-bootstrap.js"></script>
@endsection
