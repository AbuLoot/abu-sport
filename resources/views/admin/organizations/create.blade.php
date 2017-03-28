@extends('admin.layouts')

@section('content')
      <div class="panel panel-default">
        <div class="panel-body">
          <h3>Создание</h3>

          @include('partials.alerts')

          <form action="{{ route('admin.organizations.store') }}" method="post" enctype="multipart/form-data">
            {!! csrf_field() !!}
            <div class="form-group">
              <label for="title">Название</label>
              <input type="text" class="form-control" id="title" name="title" minlength="5" maxlength="80" value="{{ (old('title')) ? old('title') : '' }}" required>
            </div>
            <div class="form-group">
              <label for="slug">Slug</label>
              <input type="text" class="form-control" id="slug" name="slug" minlength="5" maxlength="80" value="{{ (old('slug')) ? old('slug') : '' }}">
            </div>
            <div class="form-group">
              <label for="org_type_id">Тип организации</label>
              <select id="org_type_id" name="org_type_id" class="form-control" required>
                <option value=""></option>
                @foreach($org_types as $org_type)
                  <option value="{{ $org_type->id }}">{{ $org_type->title.' - '.$org_type->short_title }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="sort_id">Номер</label>
              <input type="text" class="form-control" id="sort_id" name="sort_id" value="{{ (old('sort_id')) ? old('sort_id') : NULL }}">
            </div>
            <div class="form-group">
              <label for="phones">Номера телефонов</label>
              <input type="text" class="form-control" id="phones" name="phones" value="{{ (old('phones')) ? old('phones') : NULL }}">
            </div>
            <div class="form-group">
              <label for="website">Website</label>
              <input type="text" class="form-control" id="website" name="website" value="{{ (old('website')) ? old('website') : NULL }}">
            </div>
            <div class="form-group">
              <label for="emails">Emails</label>
              <input type="text" class="form-control" id="emails" name="emails" value="{{ (old('emails')) ? old('emails') : NULL }}">
            </div>
            <div class="row">
              <div class="col-md-6 col-xs-12">
                <div class="form-group">
                  <label for="country_id">Страны</label>
                  <select id="country_id" name="country_id" class="form-control" required>
                    <option value=""></option>
                    @foreach($countries as $country)
                      <option value="{{ $country->id }}">{{ $country->title }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="city_id">Города</label>
                  <select id="city_id" name="city_id" class="form-control" required>
                    <option value=""></option>
                    @foreach($cities as $city)
                      <option value="{{ $city->id }}">{{ $city->title }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="district_id">Районы</label>
                  <select id="district_id" name="district_id" class="form-control">
                    <option value=""></option>
                    @foreach($districts as $district)
                      <option value="{{ $district->id }}">{{ $district->title }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="address">Адрес</label>
                  <input type="hidden" name="latitude" id="latitude">
                  <input type="hidden" name="longitude" id="longitude">
                  <textarea class="form-control" rows="5" name="address" id="address"></textarea>
                  <span class="help-block">Например: Абая 32</span>
                </div>
              </div>
              <div class="col-md-6 col-xs-12">
                <div id="yaMap" style="width: 100%; height: 350px;"></div>
              </div>
            </div>

            <div class="form-group">
              <label for="image">Картинка:</label><br>
              <div class="fileinput fileinput-new" data-provides="fileinput">
                <div class="fileinput-new thumbnail" style="width:300px;height:200px;"></div>
                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width:300px;max-height:200px;"></div>
                <div>
                  <span class="btn btn-default btn-sm btn-file">
                    <span class="fileinput-new"><i class="glyphicon glyphicon-folder-open"></i>&nbsp; Выбрать</span>
                    <span class="fileinput-exists"><i class="glyphicon glyphicon-folder-open"></i>&nbsp;</span>
                    <input type="file" name="image" accept="image/*" required>
                  </span>
                  <a href="#" class="btn btn-default btn-sm fileinput-exists" data-dismiss="fileinput"><i class="glyphicon glyphicon-trash"></i> Удалить</a>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="lang">Язык</label>
              <input type="text" class="form-control" id="lang" name="lang" value="{{ (old('lang')) ? old('lang') : '' }}">
            </div>
            <div class="form-group">
              <label for="status">Статус:</label>
              <label>
                <input type="checkbox" id="status" name="status" checked> Активен
              </label>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary">Создать</button>
            </div>
          </form>
        </div>
      </div>
@endsection

@section('styles')
  <link href="/css/jasny-bootstrap.min.css" rel="stylesheet">
@endsection

@section('scripts')
  <script src="/js/jasny-bootstrap.js"></script>
  <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>

  <script>
    ymaps.ready(init);
    var myMap,
      myPlacemark;

    function init() {
      myMap = new ymaps.Map("yaMap", {
        center: [48.136, 67.153],
        zoom: 1
      });

      $("#country_id").on('change', function () {
        $country = $("#country_id option[value='" +  $("#country_id").val() + "']").html();
        var myGeocoder = ymaps.geocode($.trim($country));

        myGeocoder.then(
          function (res) {
            var coords = res.geoObjects.get(0).geometry.getCoordinates();
            myGeocoder.then(
              function (res) {
                myMap.setCenter(coords, 4);
                document.getElementById("latitude").value = coords[0];
                document.getElementById("longitude").value = coords[1];
              }
            );
          });
      });

      $("#city_id").on('change', function () {
        $city = $("#city_id option[value='" +  $("#city_id").val() + "']").html();

        var myGeocoder = ymaps.geocode($.trim($country)+','+$city);

        myGeocoder.then(
          function (res) {
            var coords = res.geoObjects.get(0).geometry.getCoordinates();
            myGeocoder.then(
              function (res) {
                myMap.setCenter(coords, 10);
                document.getElementById("latitude").value = coords[0];
                document.getElementById("longitude").value = coords[1];
              }
            );
          }
        );
      });

      $("#address").bind('keyup', function () {
        $city = $("#city_id option[value='" +  $("#city_id").val() + "']").html();
        $address = $("#address").val();

        var myGeocoder = ymaps.geocode($.trim($country)+','+$city+','+$address);

        myGeocoder.then(
          function (res) {
            var coords = res.geoObjects.get(0).geometry.getCoordinates();
            myGeocoder.then(
              function (res) {
                myMap.geoObjects.removeAll();
                var placemark = new ymaps.Placemark(coords, {}, {
                  draggable: true
                });
                myMap.geoObjects.add(placemark);
                myMap.setCenter(coords, 16);

                placemark.events.add("drag", function (event) {
                  coords = placemark.geometry.getCoordinates();
                  document.getElementById("latitude").value = coords[0];
                  document.getElementById("longitude").value = coords[1];
                });
                document.getElementById("latitude").value = coords[0];
                document.getElementById("longitude").value = coords[1];
              }
            );
          });
      });

    }
    /**
     *  Global Ajax Settings
     */
    $.ajaxSetup({
      headers: { 'X-CSRF-TOKEN': $('input[name="_token"]').val() }
    });

  </script>

@endsection
