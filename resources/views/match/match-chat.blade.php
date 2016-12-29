@extends('layouts')

@section('title_description', '')

@section('meta_description', '')

@section('tabs')

  <ul class="tabs-panel">
    <li><a href="{{ url('sport/'.$sport->slug.'/'.$match->field->area_id.'/match/'.$match->id) }}">Комната</a></li>
    <li class="active"><a href="#">Чат</a></li>
  </ul>

@endsection

@section('content')

  <div class="col-lg-7 col-md-7 col-sm-12">

    @include('partials.alerts')

    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Чат - Матч {{ $match->id }}</h3>
      </div>

      <div class="panel-body scroll-chat" id="chat">
        @foreach($match->chat as $message)
          @if($message->user_id == Auth::id())
            <div class="media text-right">
              <div class="media-body">
                <h5 class="media-heading"><a href="/user-profile/{{ $message->user_id }}"><b>{{ Auth::user()->surname.' '.Auth::user()->name }}</b></a></h5>
                <p>{{ $message->message }}</p>
              </div>
            </div>
          @else
            <div class="media">
              <div class="media-body">
                <h5 class="media-heading"><a href="/user-profile/{{ $message->user_id }}"><b>{{ $message->user->surname.' '.$message->user->name }}</b></a></h5>
                <p>{{ $message->message }}</p>
              </div>
            </div>
          @endif
        @endforeach
      </div>

      <div class="panel-footer">
        <form action="/chat/message/{{ $match->id }}" method="post">
          {!! csrf_field() !!}
          <div class="input-group">
            <input id="message" name="message" type="text" class="form-control" maxlength="255" placeholder="..." autocomplete="off" required>
            <span class="input-group-btn">
              <button class="btn btn-default" id="send" type="submit"><span class="glyphicon glyphicon-send"></span></button>
            </span>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-3 col-sm-12">
    <ul class="list-group">
      <?php $i = 1; ?>
      <li class="list-group-item">{{ $i++ . ' ' . $match->user->surname . ' ' . $match->user->name }} [Организатор]</li>
      @foreach($match->users as $user)
        <li class="list-group-item">{{ $i++ . ' ' . $user->surname . ' ' . $user->name }}</li>
      @endforeach
    </ul>
  </div>

@endsection

@section('scripts')
  <script src="/js/socket.io-1.4.5.js"></script>
  <script>
    var block = document.getElementById("chat");
    block.scrollTop = block.scrollHeight;

    var socket = io(':6001'),
        user_id = '{{ Auth::id() }}',
        channel = 'chat-{{ $match->id }}';

    socket.on('connect', function() {
      socket.emit('subscribe', channel)
    });

    socket.on('error', function() {
      console.warn('Error', error);
    });

    socket.on('message', function(message) {
      console.log(message);
    });

    socket.on(channel, function(data) {

      if (data.user_id == user_id) {
        appendMessage(data, 'text-right');
      } else {
        appendMessage(data);
      }

      block.scrollTop = block.scrollHeight;
    });

    function appendMessage(data, mediaClass) {
      $('.scroll-chat').append(
        $('<div class="media">').append(
          $('<div class="media-body">').append(
            $('<h5 class="media-heading">').html("<a href='/user-profile/"+data.user_id+"'><b>"+data.fullname+"</b></a>"),
            $('<p>').text(data.message)
          )
        ).addClass(mediaClass)
      );
    }

    $('#send').click(function(e){
      e.preventDefault();

      var token = $('input[name="_token"]').val();
      var msg = $('#message').val();

      $('#message').val('');

      if (msg != '') {
        $.ajax({
          type: "POST",
          url: '{!! URL::to("chat/message-ajax/".$match->id) !!}',
          dataType: "json",
          data: {'_token':token, 'message':msg},
          success: function(data) {
            // Success
          } 
        });
      } else {
        alert("Введите сообщение");
      }
    });
  </script>

@endsection