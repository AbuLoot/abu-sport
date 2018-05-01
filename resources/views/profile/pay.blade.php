@extends('layouts')

@section('tabs')

  <ul class="tabs-panel">
    <li class="active"><a href="#">Мой баланс</a></li>
  </ul>

@endsection

@section('content')

  <div class="col-lg-8 col-md-8 col-sm-12">

    <div class="panel panel-default">
      <div class="panel-heading">Счет</div>
      <div class="panel-body">
        <form class="form-horizontal" name="SendOrder" method="post" action="https://epay.kkb.kz/jsp/process/logon.jsp">
          <input type="hidden" name="Signed_Order_B64" value="{{ $content }}">
          <input type="hidden" name="Language" value="rus"> <!-- язык формы оплаты rus/eng -->
          <input type="hidden" name="BackLink" value="http://abusport.kz/payment">
          <input type="hidden" name="PostLink" value="http://abusport.kz/postlink">

          <div class="col-md-offset-2 col-md-8">
            <h4>Данные:</h4>
            <table class="table">
              <tbody>
                <tr>
                  <td>Телефон:</td>
                  <td>{{ Auth::user()->phone }}</td>
                </tr>
                <tr>
                  <td>E-mail:</td>
                  <td><input type="text" name="email" class="form-control" maxlength="50" value="{{ Auth::user()->email }}"></td>
                </tr>
                <tr>
                  <td>Итоговая цена:</td>
                  <td>{{ $payment->amount }} тг.</td>
                </tr>
                <tr>
                  <td></td>
                  <td>
                    <label><input type="checkbox" required> Со счетом согласен (-а)</label>
                  </td>
                </tr>
              </tbody>
            </table>

            <p class="text-right">
              <input type="submit" name="GotoPay" class="btn btn-primary"  value="Да, перейти к оплате" >&nbsp;
            </p>
          </div>    
        </form>    
      </div>
    </div>
  </div>

@endsection
