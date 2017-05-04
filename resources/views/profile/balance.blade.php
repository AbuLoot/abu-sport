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
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
          <div class="panel panel-info">
            <div class="panel-heading" role="tab" id="headingOne">
              <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">VISA/MasterCard</a>
              </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">
                <form>
                  {!! csrf_field() !!}
                  <div class="form-group">
                    <label for="number">Number of card</label>
                    <input type="number" class="form-control" id="number" placeholder="Number">
                  </div>
                  <div class="form-group">
                    <label for="code">Code</label>
                    <input type="number" class="form-control" id="code" placeholder="Code">
                  </div>
                  <button type="submit" class="btn btn-default">Submit</button>
                </form>
              </div>
            </div>
          </div>
          <div class="panel panel-info">
            <div class="panel-heading" role="tab" id="headingTwo">
              <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Баланс</a>
              </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
              <div class="panel-body">
                <form action="/top-up-balance" method="post">
                  {!! csrf_field() !!}
                  <div class="form-group">
                    <label for="balance">Баланс</label>
                    <input type="number" name="balance" minlength="3" class="form-control" id="balance" required>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-success">Пополнить баланс</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
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