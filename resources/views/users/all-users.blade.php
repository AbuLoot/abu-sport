
@extends('layouts')

@section('tabs')

@section('tabs')

  <ul class="tabs-panel">
    <li><a href="/friends">Мои друзья</a></li>
    <li class="active"><a href="/all-users">Другие пользователи</a></li>
  </ul>

@endsection

@section('content')

  <div class="col-lg-8 col-md-8 col-sm-12">
    <div class="panel panel-default">
      <div class="panel-heading">Пользователи</div>
      <div class="panel-body">

        @include('partials.alerts')

        @foreach($users as $user)
          <div class="row">
            <div class="col-lg-3 col-md-3">
              @if(!empty($user->profile->avatar))
                <img src="/img/users/{{ $user->profile->id . '/' . $user->profile->avatar }}" style="width: 150px; height: 150px;">
              @else
                <img src="/img/user-default.jpg" style="width: 150px; height: 150px;">
              @endif
            </div>
            <div class="col-lg-6 col-md-6">
              <p><a href="/user-profile/{{ $user->id }}">{{ $user->surname }} {{  $user->name }}</a></p>

              <p>{{ $user->profile->birthday }}</p>
            </div>
            <div class="col-lg-3 col-md-3">
              @if(Auth::user()->hasFriendRequestPending($user))
                <p class="alert alert-info">Запрос отправлен</p>
              @elseif(Auth::user()->hasFriendRequestReceived($user))
                <a href="/accept/{{$user->id}}" class="btn btn-success">Принять запрос</a>
              @elseif(Auth::user()->isFriendWith($user))
                <p class="alert alert-success">{{ $user->name }} в друзьях</p>
              @else
                <a href="/add-to-friends/{{$user->id}}" class="btn btn-primary">Добавить в друзья</a>
              @endif
            </div>
          </div><hr>
        @endforeach
      </div>
    </div>
  </div>

@endsection
