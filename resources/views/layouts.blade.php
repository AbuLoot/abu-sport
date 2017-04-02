<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>@yield('title_description', 'AbuSport')</title>
    <meta name="description" content="@yield('meta_description', 'AbuSport')">

    <link href="/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/bower_components/bootstrap-offcanvas/dist/css/bootstrap.offcanvas.css">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    @yield('styles')

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="">
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">

        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle offcanvas-toggle" data-toggle="offcanvas" data-target="#js-bootstrap-offcanvas">
            <span class="sr-only">Toggle navigation</span>
            <span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </span>
          </button>

          @if (Auth::check())
            <!-- <a href="{{ url('create-match') }}" class="btn btn-success navbar-btn navbar-xs-btn navbar-right hidden-lg hidden-md"><span class="glyphicon glyphicon-plus"></span></a> -->
          @endif

          <a class="navbar-brand" href="/">ABU SPORT</a>
        </div>

        <!-- Account system -->
        <ul class="nav navbar-nav navbar-right hidden-sm hidden-xs">
          @if (Auth::guest())
            <li><a href="{{ url('login') }}"><span class="glyphicon glyphicon-log-in"></span> Войти</a></li>
          @else
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="/my-profile">Мой профиль</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="/my-profile/edit">Изменить</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="{{ url('logout') }}"><span class="glyphicon glyphicon-log-out"></span> Выход</a></li>
              </ul>
            </li>
          @endif
        </ul>

        <!-- Create game -->
        <!-- <button type="submit" class="btn btn-success navbar-btn navbar-right hidden-sm hidden-xs"><span class="glyphicon glyphicon-plus"></span> Создать матч</button> -->

        <!-- Search form -->
        <form action="/search" method="get" class="navbar-form navbar-right hidden-sm hidden-xs">
          <div class="input-group">
            <input type="search" name="text" class="form-control" minlength="2" maxlength="80" placeholder="Поиск..." required>
            <span class="input-group-btn">
              <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
            </span>
          </div>
        </form>
      </div>
    </nav>

    @yield('tabs')

    <main class="container">
      <div class="row">

        <aside class="col-lg-2 col-md-2 navbar-offcanvas navbar-offcanvas-touch" id="js-bootstrap-offcanvas">
          <form action="/search" method="get" class="navbar-offcanvas-form hidden-lg hidden-md">
            <div class="input-group">
              <input type="search" name="text" class="form-control" minlength="2" maxlength="80" placeholder="Поиск..." required>
              <span class="input-group-btn">
                <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
              </span>
            </div>
          </form>

          <ul class="nav nav-pills nav-stacked">
            @if (Auth::check())
              <li><a href="/my-balance">Баланс <small id="balance" class="text-success">{{ Auth::user()->balance }}</small> <small class="text-success">тг</small></a></li>
              <li><a href="/my-profile">Мой профиль</a></li>
              <li><a href="/my-matches">Мои матчи <span class="badge">{{ Auth::user()->matches()->count() }}</span></a></li>
              <li><a href="/friends">Мои друзья <span class="badge">{{ Auth::user()->friends()->count() }}</span></a></li>
              <li><a href="#">Уведомления <span class="badge">0</span></a></li>
              <li><a href="#">Настройки</a></li>
            @else
              <li><a href="{{ url('login') }}">Войти</a></li>
              <li><a href="{{ url('register') }}">Регистрация</a></li>
            @endif
            <li><a href="#">Обратная связь</a></li>
            <li><a href="#">Помощь</a></li>
          </ul>
        </aside>

        @yield('content')

      </div>
    </main><br>

    <footer class="footer">
      <div class="container">
        <ul class="list-inline">
          @foreach ($pages as $page)
            <li><a href="{{ url('p/' . $page->slug) }}">{ { $page->title }}</a></li>
          @endforeach
        </ul>
      </div>
    </footer>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="/bower_components/bootstrap-offcanvas/dist/js/bootstrap.offcanvas.js"></script>
    @yield('scripts')
  </body>
</html>