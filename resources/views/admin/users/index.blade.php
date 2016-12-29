@extends('admin.layouts')

@section('content')
    @include('partials.alerts')
    <div class="table-responsive">
      <table class="table table-striped table-condensed">
        <thead>
          <tr class="active">
            <td>№</td>
            <td>Номер</td>
            <td>Фамилия</td>
            <td>Имя</td>
            <td>Email</td>
            <td>Город</td>
            <td>Пол</td>
            <td>Статус</td>
            <td class="text-right">Функции</td>
          </tr>
          <form action="/admin/users">
            <tr>
              <th> </th>
              <th> </th>
              <th>
                <input type="text" class="form-control input-sm" name="surname" placeholder="Фамилия">
              </th>
              <th>
                <input type="text" class="form-control input-sm" name="name" placeholder="Имя">
              </th>
              <th>
                <input type="text" class="form-control input-sm" name="email" placeholder="Email">
              </th>
              <th>
                <select class="form-control input-sm" name="city_id">
                  <option value="null">Выберите</option>
                  @foreach($cities as $city)
                    <option value="{{ $city->id }}">{{ $city->title }}</option>
                  @endforeach
                </select>
              </th>
              <th>
                <select class="form-control input-sm" name="sex">
                  <option value="">Выберите</option>
                  <option value="woman">Женщина</option>
                  <option value="man">Мужчина</option>
                </select>
              </th>
              <th>
                <select class="form-control input-sm" name="status">
                  <option value="null">Выберите</option>
                  <option value="1">Активен</option>
                  <option value="0">Неактивен</option>
                </select>
              </th>
              <th class="text-right">
                <input type="submit" class="btn btn-success btn-sm" value="Показать">
              </th>
            </tr>
          </form>
        </thead>
        <tbody>
          <?php $i = 1; ?>
          @forelse ($users as $user)
            <tr>
              <td>{{ $i++ }}</td>
              <td>{{ $user->sort_id }}</td>
              <td>{{ $user->surname }}</td>
              <td>{{ $user->name }}</td>
              <td>{{ $user->email }}</td>
              <td class="text-nowrap">{{ ($user->profile->city_id == 0) ? 'Не указан' : $user->profile->city->title }}</td>
              <td>{{ $user->profile->sex }}</td>
              @if ( $user->status == 1)
                <td class="text-success">Активен</td>
              @else
                <td class="text-danger">Неактивен</td>
              @endif
              <td class="text-right text-nowrap">
                <a class="btn btn-primary btn-xs" href="{{ route('admin.users.show', $user->id) }}" title="Просмотр профиля"><span class="glyphicon glyphicon-file"></span></a>
                <a class="btn btn-primary btn-xs" href="{{ route('admin.users.edit', $user->id) }}" title="Редактировать"><span class="glyphicon glyphicon-edit"></span></a>
                <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" accept-charset="UTF-8" class="btn-delete" title="Удалить">
                  <input name="_method" type="hidden" value="DELETE">
                  <input name="_token" type="hidden" value="{{ csrf_token() }}">
                  <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Удалить запись?')"><span class="glyphicon glyphicon-trash"></span></button>
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
