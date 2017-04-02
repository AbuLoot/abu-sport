@extends('layouts')

@section('tabs')

  <ul class="tabs-panel">
    <li class="active"><a href="#">Обратная связь</a></li>
  </ul>

@endsection

@section('content')

  <div class="col-lg-8 col-md-8 col-sm-12">
    <div class="panel panel-default">
      <div class="panel-heading">Оставьте свои замечания или идеи для проекта</div>
      <div class="panel-body">

        @include('partials.alerts')

        <form action="/feedback" method="post">
          {!! csrf_field() !!}
          <div class="form-group">
            <label for="text">Текст:</label>
            <textarea class="form-control" id="text" name="text" rows="5" minlength="5" maxlength="1000" required></textarea>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary">Отправить</button>
          </div>
        </form>
      </div>
    </div>
  </div>

@endsection
