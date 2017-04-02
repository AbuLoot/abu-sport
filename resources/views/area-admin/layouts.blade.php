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
    <link href="/css/admin.css" rel="stylesheet">

    @yield('styles')

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="">
    <nav class="navbar navbar-default navbar-fixed-top">
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

          <a class="navbar-brand" href="/panel">AbuSport</a>
        </div>

        <!-- Account system -->
        <ul class="nav navbar-nav navbar-right hidden-sm hidden-xs">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="/my-profile">Мой профиль</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="/my-profile/edit">Изменить</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="{{ url('/logout') }}"><span class="glyphicon glyphicon-log-out"></span> Выход</a></li>
            </ul>
          </li>
        </ul>

        <!-- Search form -->
        <form class="navbar-form navbar-right hidden-sm hidden-xs">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Search for...">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
            </span>
          </div>
        </form>
      </div>
    </nav>

    <main class="container">
      <div class="panel panel-default panel-admin">
        <div class="panel-body">
          <ul class="nav nav-pills nav-justified">
            <li @if (Request::is('panel/admin-matches', 'panel/admin-matches/*')) class="active" @endif><a href="/panel/admin-matches">Матчи</a></li>
            <li @if (Request::is('panel/admin-organization', 'panel/admin-organization/*')) class="active" @endif><a href="/panel/admin-organization">Организации</a></li>
            <li @if (Request::is('panel/admin-areas', 'panel/admin-areas/*')) class="active" @endif><a href="/panel/admin-areas">Площадки</a></li>
            <li @if (Request::is('panel/admin-fields', 'panel/admin-fields/*')) class="active" @endif><a href="/panel/admin-fields">Поля</a></li>
            <li @if (Request::is('panel/admin-schedules', 'panel/admin-schedules/*')) class="active" @endif><a href="/panel/admin-schedules">Расписания</a></li>
          </ul>
        </div>
      </div>

      <div class="col-md-12">
        @yield('content')
      </div>
    </main>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    @yield('scripts')
  </body>
</html>