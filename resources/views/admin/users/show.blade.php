@extends('layout')

@section('content')
      @include('partials.admin_menu')

      <div class="row">
        <div class="col-md-3">
          <div class="panel panel-default">
            <div class="panel-body">
              @if (empty($profile->avatar))
                <img src="/img/no-avatar.png" class="img-responsive">
              @else
                <img src="/img/users/{{ $profile->user->id . '/' . $profile->avatar }}" class="center-block img-responsive">
              @endif
              <h5 class="text-center">{{ $profile->user->name }}</h5>
            </div>
          </div>
        </div>
        <div class="col-md-9">
          <div class="row-left">            
            <div class="panel panel-default">
              <div class="panel-body">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#info" data-toggle="tab"><i class="fa fa-info-circle"></i> Информация</a></li>
                  <li><a href="#posts" data-toggle="tab"><i class="fa fa-th-list"></i> Объявления</a></li>
                  <li><a href="#reviews" data-toggle="tab"><i class="fa fa-comments"></i> Отзывы</a></li>
                </ul>
                <br>
                <div id="myTabContent" class="tab-content">
                  <div class="tab-pane fade active in" id="info">
                    <div class="table-responsive">
                      <table class="table table-striped table-hover">
                        <tbody>
                          <tr>
                            <td style="width:170px">ФИО</td>
                            <td>{{ $profile->user->name }}</td>
                          </tr>
                          <tr>
                            <td>Email</td>
                            <td>{{ $profile->user->email }}</td>
                          </tr>
                          <tr>
                            <td>Cфера работы</td>
                            <th>{{ ($profile->section_id == 0) ? 'Не указан' : $profile->section->title }}</th>
                          </tr>
                          <tr>
                            <td>Город</td>
                            <td>{{ ($profile->city_id == 0) ? 'Не указан' : $profile->city->title }}</td>
                          </tr>
                          <tr>
                            <td>Адрес работы</td>
                            <td>{{ $profile->address }}</td>
                          </tr>
                          <tr>
                            <td>Навыки</td>
                            <td>{{ $profile->skills }}</td>
                          </tr>
                          <tr>
                            <td>Телефон 1</td>
                            <td>
                              {{ $contacts->phone }}
                              @if ($contacts->telegram == 'on') Telegram, @endif
                              @if ($contacts->whatsapp == 'on') WhatsApp, @endif
                              @if ($contacts->viber == 'on') Viber @endif
                            </td>
                          </tr>
                          <tr>
                            <td>Телефон 2</td>
                            <td>
                              {{ $contacts->phone2 }}
                              @if ($contacts->telegram2 == 'on') Telegram, @endif
                              @if ($contacts->whatsapp2 == 'on') WhatsApp, @endif
                              @if ($contacts->viber2 == 'on') Viber @endif
                            </td>
                          </tr>
                          <tr>
                            <td>Веб-сайт</td>
                            <td>{{ $profile->website }}</td>
                          </tr>
                          <tr>
                            <td>Рейтинг</td>
                            <td>
                              @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $profile->stars)
                                  <i class="glyphicon glyphicon-star text-success"></i>
                                @else
                                  <i class="glyphicon glyphicon-star text-muted"></i>
                                @endif
                              @endfor
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="posts">
                    @forelse ($posts as $post)
                      <section class="media">
                        <div class="media-left">
                          <a href="{{ url($post->category->section->service_id.'/'.$post->slug.'/'.$post->id) }}">
                            @if ( ! empty($post->image))
                              <img class="media-object" src="/img/posts/{{ $post->user_id.'/'.$post->image }}" alt="{{ $post->title }}" style="width:200px">
                            @else
                              <img class="media-object" src="/img/no-main-image.png" alt="{{ $post->title }}" style="width:200px">
                            @endif
                          </a>
                        </div>
                        <div class="media-body">
                          <div class="h4 media-heading">
                            <a href="{{ url($post->category->section->service_id.'/'.$post->slug.'/'.$post->id) }}">{{ $post->title }}</a>
                          </div>
                          <span class="text-success"><b>{{ $post->price }} тг</b></span>
                          @if ($post->deal == 'on')<span class="text-deal"> - торг возможен</span>@endif
                          <br>
                          <span class="text-post"><b>{{ $post->category->section->title }}</b> > {{ $post->category->title }}</span><br>
                          <span class="text-post"><b>{{ $post->city->title }}</b> - {{ $post->created_at }}. Просмотров {{ $post->views }}</span><br>
                        </div>
                      </section><hr>
                    @empty
                      <h4>Нет объявлений.</h4>
                    @endforelse
                  </div>
                  <div class="tab-pane fade" id="reviews">
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <i class="fa fa-comments"></i> Отзывов: {{ $profile->comments->count() }}
                      </div>
                      <div class="table-responsive">
                        <table class="table">
                          <tbody>
                            @foreach ($profile->comments as $comment)
                              <tr>
                                <th style="width:110px">{{ $comment->name }}</th>
                                <td>
                                  {{ $comment->comment }}<br>
                                  Оценка:
                                  <span>
                                    @for ($i = 1; $i <= 5; $i++)
                                      @if ($i <= $comment->stars)
                                        <i class="glyphicon glyphicon-star text-success"></i>
                                      @else
                                        <i class="glyphicon glyphicon-star text-muted"></i>
                                      @endif
                                    @endfor
                                  </span><br>
                                  <small class="text-muted">{{ $comment->created_at }}</small>
                                </td>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    </div>
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
@endsection

@section('scripts')
  <script src="/bower_components/jasny-bootstrap/js/fileinput.js"></script>
@endsection
