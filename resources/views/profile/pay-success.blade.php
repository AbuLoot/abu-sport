@extends('layouts')

@section('tabs')

  <ul class="tabs-panel">
    <li class="active"><a href="#">Мой баланс</a></li>
  </ul>

@endsection

@section('content')

  <div class="col-lg-8 col-md-8 col-sm-12">
    <div class="panel panel-default">
      <div class="panel-heading">Мой баланс</div>
      <div class="panel-body">

        @include('partials.alerts')

        <dl>
          <dt>Текущий баланс:</dt>
          <dd>{{ $user->balance }} 〒</dd>
        </dl>

        <h2>Пополнение баланса</h2>
        <form action="/top-up-balance" method="post">
          {!! csrf_field() !!}
          <div class="form-group">
            <h4>Способ пополнение:</h4>
            @foreach($operations as $key => $operation)
              <div class="radio">
                <label>
                  <input type="radio" name="operation_id" value="{{ $operation->id }}" @if ($key == 0) checked @endif required>
                  {{ $operation->name }} - {{ $operation->rules }}
                </label>
              </div>
            @endforeach
          </div>
          <div class="form-group">
            <label for="balance">Сумма пополнение:</label>
            <input type="number" name="balance" minlength="3" class="form-control" id="balance" required>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-success">Пополнить баланс</button>
          </div>
        </form>
      </div>
    </div>
  </div>

@endsection
