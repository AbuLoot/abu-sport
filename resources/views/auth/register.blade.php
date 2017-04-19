@extends('layouts')

@section('tabs')

  <ul class="tabs-panel">
    <li><a href="/login">Вход</a></li>
    <li class="active"><a href="#">Регистрация</a></li>
  </ul>

@endsection

@section('content')

  <div class="col-lg-8 col-md-8 col-sm-12">
    <div class="panel panel-default">
      <div class="panel-heading">Зарегистрируйтесь в систему</div>
      <div class="panel-body">

        @include('partials.alerts')

        <form class="form-horizontal" role="form" method="POST" action="/register">
          {{ csrf_field() }}

          <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name" class="col-md-4 control-label">Фамилия и Имя</label>

            <div class="col-md-6">
              <table>
                <tbody>
                  <tr>
                    <td style="padding-right: 5px;">
                      <input id="surname" type="text" class="form-control" name="surname" value="{{ old('surname') }}" minlength="2" maxlength="40" placeholder="Фамилия" required>
                    </td>
                    <td style="padding-left: 5px;">
                      <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" minlength="2" maxlength="40" placeholder="Имя" required>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="form-group {{ $errors->has('sex') ? ' has-error' : '' }}">
            <label class="col-md-4 control-label">Ваш пол</label>

            <div class="col-md-6">
              <label class="radio-inline">
                <input type="radio" name="sex" id="woman" value="woman" @if (old('sex') == 'woman') checked @endif> Женский
              </label>
              <label class="radio-inline">
                <input type="radio" name="sex" id="man" value="man" @if (old('sex') == 'man') checked @endif> Мужской
              </label>
            </div>
          </div>

          <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
            <label for="phone" class="col-md-4 control-label">Номер Телефона</label>

            <div class="col-md-6">
              <input id="phone" type="tel" class="form-control" name="phone" value="{{ old('phone') ? old('phone') : '7 ' }}" data-toggle="tooltip" data-placement="bottom" title="Пример: 7&nbsp;789&nbsp;0000" minlength="11" maxlength="40" required>

              @if ($errors->has('phone'))
                <span class="help-block">
                  <strong>{{ $errors->first('phone') }}</strong>
                </span>
              @endif
            </div>
          </div>

          <!-- <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email" class="col-md-4 control-label">E-Mail</label>

            <div class="col-md-6">
              <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" minlength="8" maxlength="60" required>

              @if ($errors->has('email'))
                <span class="help-block">
                  <strong>{{ $errors->first('email') }}</strong>
                </span>
              @endif
            </div>
          </div> -->

          <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="password" class="col-md-4 control-label">Пароль</label>

            <div class="col-md-6">
              <input id="password" type="password" class="form-control" name="password" value="{{ old('password') }}" minlength="6" maxlength="60" required>

              @if ($errors->has('password'))
                <span class="help-block">
                  <strong>{{ $errors->first('password') }}</strong>
                </span>
              @endif
            </div>
          </div>

          <div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
            <label for="password-confirm" class="col-md-4 control-label">Потдвердите пароль</label>

            <div class="col-md-6">
              <input id="password-confirm" type="password" class="form-control" name="password_confirmation" minlength="6" maxlength="60" required>

              @if ($errors->has('password_confirmation'))
                <span class="help-block">
                  <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
              @endif
            </div>
          </div>

          <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="rules" class="col-md-4 control-label"></label>

            <div class="col-md-6">
              <div @if ($errors->has('rules')) class="has-error" @endif>
                <div class="checkbox">
                  <label>
                    <input id="rules" type="checkbox" name="rules" @if (old('rules')) checked @endif> Я согласен с <a href="#">правилами сайта</a>
                  </label>
                  @if ($errors->has('rules'))
                    <span class="help-block">
                      <strong>{{ $errors->first('rules') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
              <button type="submit" class="btn btn-primary">
                <span class="glyphicon glyphicon-user"></span> Зарегистрироваться
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

@endsection

@section('scripts')

  <script>
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })
  </script>

  <script>
    window.onload = function () {
      document.getElementById("password").onchange = validatePassword;
      document.getElementById("password-confirm").onchange = validatePassword;
    }
    function validatePassword() {
      var pass1 = document.getElementById("password").value;
      var pass2 = document.getElementById("password-confirm").value;
      if (pass1 != pass2) {
        document.getElementById("password-confirm").setCustomValidity("Пароли не совпадают");
      } else {
        document.getElementById("password-confirm").setCustomValidity('');
        //empty string means no validation error
      }
    }
  </script>

@endsection