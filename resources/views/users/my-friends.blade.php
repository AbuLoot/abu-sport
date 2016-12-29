@extends('layouts')

@section('tabs')

  <ul class="tabs-panel">
    <li class="active"><a href="#">Все друзья</a></li>
    <li><a href="/all-users">Другие пользователи</a></li>
  </ul>

@endsection

@section('content')

  <div class="col-lg-8 col-md-8 col-sm-12">
    <div class="panel panel-default">
      <div class="panel-heading">Мои друзья</div>
      <div class="panel-body">

        @include('partials.alerts')

        @if($user->friends()->count())
          @foreach($user->friends() as $user)
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
                <p>{{ $user->profile->city->title }}</p>
                <p>{{ $user->profile->birthday }}</p>
              </div>
            </div>
            <hr>
          @endforeach
        @else
          <div class="row">
            <div class="form-group">
              <div class="col-lg-12 col-md-12">
                <p>У вас пока нет друзей</p>
              </div>
            </div>
          </div>
        @endif
      </div>
    </div>
  </div>

@endsection

@section('styles')
  <link href="/bower_components/jasny-bootstrap/dist/css/fileinput.min.css" rel="stylesheet">
  <link href="/css/jasny-bootstrap.min.css" rel="stylesheet">
@endsection

@section('scripts')
  <script src="/js/jasny-bootstrap.js"></script>
  <script src="/bower_components/jasny-bootstrap/js/fileinput.js"></script>
@endsection