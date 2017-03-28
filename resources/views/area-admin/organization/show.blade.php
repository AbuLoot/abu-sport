@extends('area-admin.layouts')

@section('content')

    @include('partials.alerts')

    <div class="table-responsive">
      <table class="table table-striped table-condensed">
        <thead>
          <tr class="active">
            <td>Название компании</td>
            <td>Аватар</td>
            <td>Страна</td>
            <td>Город</td>
            <td>Район</td>
            <td>Тип организации</td>
            <td>Emails</td>
            <td>Номера телефонов</td>
            <td>Веб-сайт</td>
            <td>Адрес</td>
            <td>Баланс</td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ $organization->title }}</td>
            <td>
              <div style="width: 200px; height: auto;">
                @if(empty($organization->avatar))
                  <img class="img-responsive" src="/img/organizations/{{ $organization->logo }}">
                @endif
              </div>
            </td>
            <td>{{ $organization->country->title }}</td>
            <td>{{ $organization->city->title }}</td>
            <td>{{ (isset($organization->district->title)) ? $organization->district->title : '' }}</td>
            <td>{{ $organization->org_type->title.' ('.$organization->org_type->short_title.')' }}</td>
            <td>{{ $organization->emails }}</td>
            <td>{{ $organization->phones }}</td>
            <td>{{ $organization->websites }}</td>
            <td>{{ $organization->address }}</td>
            <td>{{ $organization->balance }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <p class="text-right">
      <a href="/panel/admin-organization/{{ $organization->id }}/edit" class="btn btn-primary btn-sm">Изменить</a>
    </p><br>

@endsection