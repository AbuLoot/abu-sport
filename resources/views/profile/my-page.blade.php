@extends('layouts')

@section('tabs')

  <ul class="tabs-panel">
    <li class="active"><a href="#">Мой профиль</a></li>
  </ul>

@endsection

@section('content')

  <div class="col-lg-8 col-md-8 col-sm-12">
    <div class="panel panel-default">
      <div class="panel-heading">Информация</div>
      <div class="panel-body">

        @include('partials.alerts')

        <dl class="dl-horizontal">
          <dt>Фамилия и Имя:</dt>
          <dd>{{ $user->surname.' '.$user->name }}</dd>
        </dl>
        <dl class="dl-horizontal">
          <dt>Аватар</dt>
          <dd>
            <div style="width: 200px; height: 200px;">
              @if(empty($user->profile->avatar))
                <img src="/img/user-default.jpg" class="img-responsive">
              @else
                <img src="/img/users/{{ $user->profile->id . '/' . $user->profile->avatar }}">
              @endif
            </div>
          </dd>
        </dl>
        <dl class="dl-horizontal">
          <dt>Email:</dt>
          <dd>{{ $user->email }}</dd>
        </dl>
        <dl class="dl-horizontal">
          <dt>Город:</dt>
          <dd>{{ $user->profile->city->title }}</dd>
        </dl>
        <dl class="dl-horizontal">
          <dt>Телефон</dt>
          <dd>{{ $user->phone }}</dd>
        </dl>
        <dl class="dl-horizontal">
          <dt>Рост:</dt>
          <dd>{{ $user->profile->growth }} см.</dd>
        </dl>
        <dl class="dl-horizontal">
          <dt>Вес:</dt>
          <dd>{{ $user->profile->weight }} кг.</dd>
        </dl>
        <dl class="dl-horizontal">
          <dt>Дата рождения:</dt>
          <dd>{{ $user->profile->birthday }}</dd>
        </dl>
        <dl class="dl-horizontal">
          <dt>Пол:</dt>
          <dd>{{ ($user->profile->sex == "woman") ? 'Женщина' : 'Мужчина' }}</dd>
        </dl>

        <div class="text-right">
          <a class="btn btn-primary" href="/my-profile/edit">Изменить</a>
        </div>
      </div>
    </div>
  </div>

@endsection
