@extends('area-admin.layouts')

@section('content')

    @include('partials.alerts')

    <div class="table-responsive">
      <table class="table table-striped table-condensed">
        <thead>
          <tr class="active">
            <td>Название</td>
            <td>Номер</td>
            <td>Компания</td>
            <td>Спорт</td>
            <td>Город</td>
            <td>Номера телефонов</td>
            <td>Emails</td>
            <td>Адрес</td>
            <td>Описание</td>
            <td>Время работы</td>
            <td colspan="2">Статус</td>
          </tr>
        </thead>
        <tbody>
          @foreach ($areas as $area)
            <tr>
              <td>{{ $area->title }}</td>
              <td>{{ $area->sort_id }}</td>
              <td>{{ $area->organization->title }}</td>
              <td>{{ $area->sport->title }}</td>
              <td>{{ $area->city->title }}</td>
              <td>{{ $area->phones }}</td>
              <td>{{ $area->emails }}</td>
              <td>{{ $area->address }}</td>
              <td>{{ $area->description }}</td>
              <td>{{ $area->start_time.' - '.$area->end_time }}</td>
              @if ($area->status == 1)
                <td class="success">Активен</td>
              @else
                <td class="danger">Неактивен</td>
              @endif
              <td><a href="/panel/admin-areas/{{ $area->id }}/edit" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit"></span></a></td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

@endsection