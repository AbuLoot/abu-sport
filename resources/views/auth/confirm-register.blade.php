@extends('layouts')

@section('tabs')

  <ul class="tabs-panel">
    <li><a href="{{ url('/login') }}">Вход</a></li>
    <li><a href="{{ url('/register') }}">Регистрация</a></li>
  </ul>

@endsection

@section('content')

  <div class="col-lg-8 col-md-8 col-sm-12">
    <div class="panel panel-info">
      <div class="panel-heading">Подтверждение регистрации</div>
      <div class="panel-body">

        @include('partials.alerts')

        <form class="form-horizontal" role="form" method="POST" action="{{ url('/confirm-register') }}">
          {{ csrf_field() }}

          <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
            <label for="phone" class="col-md-4 control-label">Номер Телефона</label>

            <div class="col-md-6">
              <input id="phone" type="tel" class="form-control" name="phone" value="{{ old('phone') ? old('phone') : '7 ' }}"  data-toggle="tooltip" data-placement="right" title="Пример: +7&nbsp;789&nbsp;0000000" minlength="11" maxlength="40" required>

              @if ($errors->has('phone'))
                <span class="help-block">
                  <strong>{{ $errors->first('phone') }}</strong>
                </span>
              @endif
            </div>
          </div>

          <div class="form-group {{ $errors->has('code') ? 'has-error' : '' }}">
            <label for="code" class="col-md-4 control-label">SMS Код</label>

            <div class="col-md-3">
              <input id="code" type="tel" class="form-control" name="code" value="{{ old('code') ? old('code') : '' }}"  data-toggle="tooltip" data-placement="right" title="Пример: 12345" minlength="5" maxlength="5" required>

              @if ($errors->has('code'))
                <span class="help-block">
                  <strong>{{ $errors->first('code') }}</strong>
                </span>
              @endif
            </div>

            <div class="col-md-3">
              <!-- <a class="btn btn-link" href="{{ url('') }}"><span class="glyphicon glyphicon-refresh"></span> Переотправить код</a> -->
            </div>
          </div>

          <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
              <button type="submit" class="btn btn-primary">
                <span class="glyphicon glyphicon-ok"></span> Подтвердить регистрацию
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

@endsection