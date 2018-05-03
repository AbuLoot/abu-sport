@extends('layouts')

@section('tabs')

  <ul class="tabs-panel">
    <li class="active"><a href="#">Статус</a></li>
  </ul>

@endsection

@section('content')

  <div class="col-lg-8 col-md-8 col-sm-12">
    <div class="panel panel-default">
      <div class="panel-heading">Статус</div>
      <div class="panel-body">

        @include('partials.alerts')

        <h2>Баланс пополнен!</h2>
      </div>
    </div>
  </div>

@endsection
