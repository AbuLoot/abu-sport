@extends('layouts')

@section('tabs')

  <ul class="tabs-panel">

  </ul>

@endsection

@section('content')

  <div class="panel panel-default">
    <div class="panel-heading">Пополнить счет</div>
    <div class="panel-body">
      <form class="form-horizontal" name="SendOrder" method="post" action="https://testpay.kkb.kz/jsp/process/logon.jsp">
        <input type="hidden" name="Signed_Order_B64" value="{{ $content }}">
        <input type="hidden" name="Language" value="rus"> <!-- язык формы оплаты rus/eng -->
        <input type="hidden" name="BackLink" value="http://abusport.kz/payment">
        <input type="hidden" name="PostLink" value="http://abusport.kz/postlink">
        <div class="form-group">
          <label for="phone" class="col-md-4 control-label">E-mail:</label>
          <div class="col-md-6">
            <input type="text" name="email" class="form-control"  size=50 maxlength=50  value="{{ $user->email }}">
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-6 col-md-offset-4">
            <div class="checkbox">
              <label>Со счетом согласен (-а)</label>
            </div>
          </div>
        </div>
        <div class="text-right">
          <input type="submit" name="GotoPay" class="btn btn-primary"  value="Да, перейти к оплате" >&nbsp;
        </div>       
      </form>    
    </div>
  </div>

@endsection
