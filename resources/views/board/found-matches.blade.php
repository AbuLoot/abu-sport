@extends('layouts')

@section('title_description', '')

@section('meta_description', '')

@section('tabs')

  <ul class="tabs-panel">
    <li><a href="{{ url('/') }}">Спорт</a></li>
    <li class="active"><a href="#">Матчи</a></li>
  </ul>

@endsection

@section('content')

  <div class="col-lg-8 col-md-8 col-sm-12">

    @include('partials.alerts')

    @forelse ($matches as $match)
      <div class="list-group">
        <a href="{{ url('sport/'.$match->field->area->sport->slug.'/'.$match->field->area->id.'/match/'.$match->id) }}" class="list-group-item active">
          <h3 class="list-group-item-heading">
            Матч {{ $match->id }}
            @if ($match->match_type == 'open')
              <span class="pull-right label label-success">Открытая игра</span>
            @else
              <span class="pull-right label label-default">Закрытая игра</span>
            @endif
          </h3>
          <p></p>
          <h4 class="list-group-item-heading">{{ $match->field->area->title }}</h4>
          <p class="list-group-item-heading">
            <b>Адрес:</b> {{ $match->field->area->city->title . ', ' . $match->field->area->address }}<br>
            <b>Начало игры:</b> {{ $match->matchDate }}. <b>Время</b> {{$match->timeFromTo }}<br>
            <b>Игроков:</b> {{ $match->usersCount.'/'.$match->number_of_players }}
          </p>
        </a>
      </div>
    @empty
      <p>Ничего не найдено</p>
    @endforelse

    {{ $matches->render() }}
  </div>
@endsection
