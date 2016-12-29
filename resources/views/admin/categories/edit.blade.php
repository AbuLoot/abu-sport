@extends('layout')

@section('content')
      @include('partials.admin_menu')
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-8">
              <h3>Редактирование категории</h3>
              <form action="{{ route('admin.categories.update', $category->id) }}" method="post" class="form-horizontal" enctype="multipart/form-data">
                <input name="_method" type="hidden" value="PUT">
                {!! csrf_field() !!}
                <div class="form-group">
                  <div class="col-md-offset-3 col-md-9">
                    @include('partials.alerts')
                  </div>

                  <label for="sort_id" class="col-md-3">Номер</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control" id="sort_id" name="sort_id" maxlength="5" value="{{ (old('sort_id')) ? old('sort_id') : $category->sort_id }}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="section_id" class="col-md-3">Разделы</label>
                  <div class="col-md-9">
                    <select class="form-control" id="section_id" name="section_id">
                      @foreach ($services as $service)
                        <optgroup label="{{ $service->title }}">
                          @foreach ($service->section->sortBy('sort_id') as $item)
                            @if ($item->id == $category->section_id)
                              <option value="{{ $item->id }}" selected>{{ $item->title }}</option>
                            @else
                              <option value="{{ $item->id }}">{{ $item->title }}</option>
                            @endif
                          @endforeach
                        </optgroup>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="title" class="col-md-3">Заголовок категорий</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control" id="title" name="title" minlength="5" maxlength="80" value="{{ (old('title')) ? old('title') : $category->title }}" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="slug" class="col-md-3">Slug</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control" id="slug" name="slug" minlength="5" maxlength="80" value="{{ (old('slug')) ? old('slug') : $category->slug }}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="image" class="col-md-3">Иконка</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control" id="image" name="image" minlength="5" maxlength="80" value="{{ (old('image')) ? old('image') : $category->image }}">
                  </div>
                </div>
                <!-- <div class="form-group">
                  <label for="price" class="col-md-3">Картинка</label>
                  <div class="col-md-9">
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                      <div class="fileinput-new thumbnail" style="width: 185px; height: 120px;">
                        <img src="/img/categories/{{ $category->image }}">
                      </div>
                      <div class="fileinput-preview fileinput-exists thumbnail" data-trigger="fileinput" style="width: 185px; height: 120px;"></div>
                      <div>
                        <span class="btn btn-default btn-sm btn-file">
                          <span class="fileinput-new"><i class="glyphicon glyphicon-folder-open"></i>&nbsp; Изменить</span>
                          <span class="fileinput-exists"><i class="glyphicon glyphicon-folder-open"></i>&nbsp;</span>
                          <input type="file" name="image" accept="image/*">
                        </span>
                        <a href="#" class="btn btn-default btn-sm fileinput-exists" data-dismiss="fileinput"><i class="glyphicon glyphicon-trash"></i> Удалить</a>
                      </div>
                    </div>
                  </div>
                </div> -->
                <div class="form-group">
                  <label for="title_description" class="col-md-3">Мета название</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control" id="title_description" name="title_description" maxlength="255" value="{{ (old('title_description')) ? old('title_description') : $category->title_description }}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="meta_description" class="col-md-3">Мета описание</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control" id="meta_description" name="meta_description" maxlength="255" value="{{ (old('meta_description')) ? old('meta_description') : $category->meta_description }}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="text" class="col-md-3">Текст</label>
                  <div class="col-md-9">
                    <textarea class="form-control" id="text" name="text" rows="3" maxlength="2000">{{ (old('text')) ? old('text') : $category->text }}</textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label for="status" class="col-md-3">Статус</label>
                  <div class="col-md-9">
                    <label>
                      @if ($category->status == 1)
                        <input type="checkbox" id="status" name="status" checked> Активен
                      @else
                        <input type="checkbox" id="status" name="status"> Активен
                      @endif
                    </label>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-md-9 col-md-offset-3">
                    <button type="submit" class="btn btn-primary">Обновить рубрику</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
@endsection

@section('styles')
  <link href="/bower_components/jasny-bootstrap/dist/css/fileinput.min.css" rel="stylesheet">
@endsection

@section('scripts')
  <script src="/bower_components/jasny-bootstrap/js/fileinput.js"></script>
@endsection
