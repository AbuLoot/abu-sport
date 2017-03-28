
                <!-- <div class="form-group {{ $errors->has(['city']) ? ' has-error' : '' }}">
                  <label for="city" class="col-md-4 control-label">Выберите город</label>

                  <div class="col-md-6">
                    <select name="city" id="city" title="Город" class="form-control">
                      @foreach ($cities as $city)
                        @if (old('city') == $city->id)
                          <option value="{{ $city->id }}" selected>{{ $city->title }}</option>
                        @else
                          <option value="{{ $city->id }}">{{ $city->title }}</option>
                        @endif
                      @endforeach
                    </select>
                  </div>
                </div> -->


                
                <div class="form-group {{ $errors->has(['day']) ? ' has-error' : $errors->has(['month']) ? ' has-error' : $errors->has(['year']) ? ' has-error' : '' }}">
                  <label class="col-md-4 control-label">Дата рождения</label>

                  <div class="col-md-6">
                    <table>
                      <tbody>
                        <tr>
                          <td style="width:33%;padding-right:10px;">
                            <select name="day" id="day" title="День" class="form-control" >
                              <option value="">День</option>
                              @for ($d = 1; $d <= 31; $d++)
                                @if (old('day') == $d)
                                  <option value="{{ $d }}" selected>{{ $d }}</option>
                                @else
                                  <option value="{{ $d }}">{{ $d }}</option>
                                @endif
                              @endfor
                            </select>
                          </td>
                          <td style="width:33%;">
                            <select name="month" id="month" title="Месяц" class="form-control">
                              <option value="">Месяц</option>
                              @foreach (trans('data.month') as $num => $month)
                                @if (old('month') == $num)
                                  <option value="{{ $num }}" selected>{{ $month }}</option>
                                @else
                                  <option value="{{ $num }}">{{ $month }}</option>
                                @endif
                              @endforeach
                            </select>
                          </td>
                          <td style="width:33%;padding-left:10px;">
                            <select name="year" id="year" title="Год" class="form-control">
                              <option value="">Год</option>
                              @for ($y = 2012; $y >= 1905; $y--)
                                @if (old('year') == $y)
                                  <option value="{{ $y }}" selected>{{ $y }}</option>
                                @else
                                  <option value="{{ $y }}">{{ $y }}</option>
                                @endif
                              @endfor
                            </select>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
