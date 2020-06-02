@extends('auth.app')

@section('content')
    {!! ReCaptcha::htmlScriptTagJsApi(/* $formId - INVISIBLE version only */) !!}
 <link href="/css/login.css" rel="stylesheet" type="text/css"> 
 <style>

@media (max-width: 768px){
 .login-box-left{
	     min-height: auto;
   border-radius: 30px 30px 0px 0px;
    width: 100%;
	display:none;
	 }
.login-box-right {
border-radius: 20px 20px 20px 20px;
    background: #FFFFFF;
    min-height: 577px;
    width: 100%;
    padding: 20px;
}
.logo-login {
    margin-left: -4px;
    float: none;
    text-align: center;
}
h5.content-group {
    float: none;
    font-size: 24px;
    margin-top: 0px;
    text-align: center;
} 
.login-box{    margin-top: 20px;}
.login-container.login-container-night {
    background: url(/images/balloon-night.jpg) no-repeat 48% fixed;
}
.g-recaptcha {
    float: left;
    margin-top: -20px;
    margin-bottom: 16px;
}
}
</style>
     <script src="/cdn/v1/catch_lead/js/jquery.inputmask.js"></script>
         <div class="container">
    	<div class="row">
        
        <div class="col-xs-12 login-box">
                <div class="col-sm-6 login-box-left">
        <div class="text-h1">Скажите "да" эффективной <br>
рекламе</div>
        <div class="text-h2">Используйте ваши учетные данные для входа.<br>
Если Вы не являетесь участником, пожалуйста, <a href="{{ route('register') }}">зарегистрируйтесь</a>.
</div>
        
        </div>
              <div class="col-sm-6 login-box-right">  
     <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}
                    <div class="col-xs-12 heder-logo-block">
                                <div class="logo-login"><img src="/images/logo_neiros.svg"></div>
                                <h5 class="content-group">Регистрация
                                    <small class="display-block"></small>
                                </h5>
                     </div> 
                            <input id="company" type="hidden" class="form-control" name="company" value=" " placeholder="Компания"  >
<input type="hidden" name="partner_id" value="{{request()->cookie('_ref')}}" autocomplete="off">
                            <div class="col-xs-12 cont-form {{ $errors->has('name') ? ' has-error' : '' }}">



                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder=" " required autofocus><label for="name">Имя</label>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif

                        </div>

                        <div class="col-xs-12 cont-form {{ $errors->has('email') ? ' has-error' : '' }}">


                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder=" " required><label for="email">E-mail</label>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        @if($errors->first('email')=='unique')
                                        <strong> Пользователь с таким e-mail уже зарегистрирован</strong>
                                         @else
                                        <strong>{{ $errors->first('email') }}</strong>@endif
                                    </span>
                                @endif

                        </div>
                           <div class="col-xs-12 cont-form {{ $errors->has('phone') ? ' has-error' : '' }}">


                                <input id="phone" type="phone" class="form-control form-control-text-number-mask" name="phone" value="{{old('phone')}}" placeholder="+7 (___) ___ __ __" required>
<label for="phone">Телефон</label>


                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                              @if($errors->first('phone')=='unique')
                                            <strong>Пользователь с таким номером уже зарегистрирован</strong>
                                        @else
                                            <strong>{{ $errors->first('phone') }}</strong>@endif
                                    </span>
                                @endif

                            </div>
                        <div class="cont-form col-xs-12 {{ $errors->has('password') ? ' has-error' : '' }}">


                                <input id="password" type="password" class="form-control" name="password" placeholder="******" required>
<label for="password">Пароль</label>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif

                        </div>

                      {{--  <div class="cont-form col-xs-12 ">

                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="******" required>
<label for="password-confirm">Повтор пароля</label>
                        </div>--}}
                      
                            <div class="cont-form col-xs-12" style="padding-top: 20px;">
                             @if ($errors->has('g-recaptcha-response'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                    </span>
                                @endif

                                {!! htmlFormSnippet() !!}
                              <button type="submit" class="btn btn-primary" >
                                    Зарегистрироваться
                                </button>
                                    
                                <a class="a-enter"  href="{{ route('login') }}">
                                    Вход
                                </a>

                         
                              </div>
                    
                
                    </form>
            </div>          
                    
                 </div>

    </div> 
  </div>            
   <style>
   .g-recaptcha{
    float: left;
    margin-top: -20px;	   }
   .login-box{
	   margin-top:0px;}
   .login-box-left{
	    height: 607.6px;}
   .a-enter{    display: block;
    float: right;
    margin-right: 19px;
    font-size: 14px;
    margin-top: 6px;}
	.cont-form button {
    width: 180px;}
	
	
	
   </style>                 
                    
                    
    <script> 
	$("#phone").inputmask("+7 (999) 999-99-99", {"placeholder": "+7 (___) ___-__-__"});</script>
@endsection
