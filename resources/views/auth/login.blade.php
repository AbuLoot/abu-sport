@extends('layouts')

@section('tabs')

  <ul class="tabs-panel">
    <li class="active"><a href="#">Вход</a></li>
    <li><a href="{{ url('/register') }}">Регистрация</a></li>
  </ul>

@endsection

@section('content')

  <div class="col-lg-8 col-md-8 col-sm-12">
    <div class="panel panel-default">
      <div class="panel-heading">Войдите в систему</div>
      <div class="panel-body">

        @include('partials.alerts')

        <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
          {{ csrf_field() }}

          <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
            <label for="phone" class="col-md-4 control-label">Номер Телефона</label>

            <div class="col-md-6">
              <input id="phone" type="tel" class="form-control" name="phone" value="{{ old('phone') }}" minlength="8" maxlength="60" required>

              @if ($errors->has('phone'))
                <span class="help-block">
                  <strong>{{ $errors->first('phone') }}</strong>
                </span>
              @endif
            </div>
          </div>

          <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="password" class="col-md-4 control-label">Пароль</label>

            <div class="col-md-6">
              <input id="password" type="password" class="form-control" name="password" minlength="6" maxlength="60" required>

              @if ($errors->has('password'))
                <span class="help-block">
                  <strong>{{ $errors->first('password') }}</strong>
                </span>
              @endif
            </div>
          </div>

          <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="remember"> Запомнить меня
                </label>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
              <button type="submit" class="btn btn-primary">
                <span class="glyphicon glyphicon-log-in"></span> Войти
              </button>

              <a class="btn btn-link" href="{{ url('/password/reset') }}">Забыли пароль?</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

@endsection
