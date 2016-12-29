@extends('layout')

@section('content')
      @include('partials.admin_menu')
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-12">
              @include('partials.alerts')
              <p class="text-right">
                <a href="/admin/categories/create" class="btn btn-success btn-sm">Добавить</a>
              </p>
              <div class="table-responsive">
                <table class="table-admin table table-striped table-condensed">
                  <thead>
                    <tr class="active">
                      <td>№</td>
                      <td>Название</td>
                      <td>Номер</td>
                      <td>Статус</td>
                      <td class="text-right">Функции</td>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i = 1; ?>
                    @forelse ($services as $service)
                      <tr>
                        <th colspan="5" class="active">{{ $service->title }}</th>
                      </tr>
                      @forelse ($service->section as $section)
                        <tr>
                          <th></th>
                          <th colspan="4">{{ $section->title }}</th>
                        </tr>
                        @forelse ($section->categories as $category)
                          <tr>
                            <td>{{ $i++ }}</td>
                            <td><a href="{{ url($category->section->service->slug.'/'.$category->slug.'/'.$category->id) }}" target="_blank">{{ $category->title }}</a></td>
                            <td>{{ $category->sort_id }}</td>
                            @if ($category->status == 1)
                              <td class="text-success">Активен</td>
                            @else
                              <td class="text-danger">Неактивен</td>
                            @endif
                            <td class="text-right">
                              <a class="btn btn-primary btn-xs" href="{{ url($category->section->service->slug.'/'.$category->slug) }}" title="Просмотр страницы" target="_blank"><span class="glyphicon glyphicon-file"></span></a>
                              <a class="btn btn-primary btn-xs" href="{{ route('admin.categories.edit', $category->id) }}" title="Редактировать"><span class="glyphicon glyphicon-edit"></span></a>
                              <form method="POST" action="{{ route('admin.categories.destroy', $category->id) }}" accept-charset="UTF-8" class="btn-delete">
                                <input name="_method" type="hidden" value="DELETE">
                                <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Удалить запись ({{ $category->title }})?')"><span class="glyphicon glyphicon-trash"></span></button>
                              </form>
                            </td>
                          </tr>
                        @empty
                          <tr>
                            <td></td>
                            <td colspan="4">Нет категориев</td>
                          </tr>
                        @endforelse
                      @empty
                        <tr>
                          <td></td>
                          <td colspan="4">Нет категориев</td>
                        </tr>
                      @endforelse
                    @empty
                      <tr>
                        <td></td>
                        <td colspan="4">Нет категориев</td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection