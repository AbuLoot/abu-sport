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

          <a class="navbar-brand" href="/admin">AbuSport</a>
        </div>

        <!-- Account system -->
        <ul class="nav navbar-nav navbar-right hidden-sm hidden-xs">
          <li><a href="#"><span class="glyphicon glyphicon-plus"></span> Создать матч</a></li>
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
            <input type="search" class="form-control" placeholder="Search for...">
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
            <li @if (Request::is('admin/pages', 'admin/pages/*')) class="active" @endif><a href="/admin/pages">Страницы</a></li>
            <li class="dropdown @if (Request::is('admin/users', 'admin/users/*', 'admin/organizations', 'admin/organizations/*', 'admin/org_types', 'admin/org_types/*', 'admin/roles', 'admin/roles/*', 'admin/permissions', 'admin/permissions/*')) active @endif">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">База<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li @if (Request::is('admin/users', 'admin/users/*')) class="active" @endif><a href="/admin/users">Пользователи</a></li>
                <li @if (Request::is('admin/organizations', 'admin/organizations/*')) class="active" @endif><a href="/admin/organizations">Организации</a></li>
                <li @if (Request::is('admin/org_types', 'admin/org_types/*')) class="active" @endif><a href="/admin/org_types">Типы организации</a></li>
                <li @if (Request::is('admin/roles', 'admin/roles/*')) class="active" @endif><a href="/admin/roles">Роли</a></li>
                <li @if (Request::is('admin/permissions', 'admin/permissions/*')) class="active" @endif><a href="/admin/permissions">Права доступа</a></li>
              </ul>
            </li>
            <li class="dropdown @if (Request::is('admin/countries', 'admin/countries/*', 'admin/cities', 'admin/cities/*', 'admin/districts', 'admin/districts/*')) active @endif">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Регионы<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li @if (Request::is('admin/countries', 'admin/countries/*')) class="active" @endif><a href="/admin/countries">Страны</a></li>
                <li @if (Request::is('admin/cities', 'admin/cities/*')) class="active" @endif><a href="/admin/cities">Города</a></li>
                <li @if (Request::is('admin/districts', 'admin/districts/*')) class="active" @endif><a href="/admin/districts">Районы</a></li>
              </ul>
            </li>
            <li @if (Request::is('admin/sports', 'admin/sports/*')) class="active" @endif><a href="/admin/sports">Спорт</a></li>
            <li @if (Request::is('admin/areas', 'admin/areas/*')) class="active" @endif><a href="/admin/areas">Площадки</a></li>
            <li @if (Request::is('admin/fields', 'admin/fields/*')) class="active" @endif><a href="/admin/fields">Поля</a></li>
            <li @if (Request::is('admin/schedules', 'admin/schedules/*')) class="active" @endif><a href="/admin/schedules">Расписания</a></li>
            <li @if (Request::is('admin/options', 'admin/options/*')) class="active" @endif><a href="/admin/options">Опции</a></li>
            <li @if (Request::is('admin/matches', 'admin/matches/*')) class="active" @endif><a href="/admin/matches">Матчи</a></li>
            <li @if (Request::is('admin/lang', 'admin/lang/*')) class="active" @endif><a href="#/admin/lang">Языки</a></li>
            <li @if (Request::is('admin/settings', 'admin/settings/*')) class="active" @endif><a href="#/admin/settings">Настройки</a></li>
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