@extends('auth.app')

@section('content')

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
    min-height: 309px;
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
}
</style>
	

     
     
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
    <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
<div class="col-xs-12 heder-logo-block">
                <div class="logo-login"><img src="/images/logo_neiros.svg"></div>
                <h5 class="content-group">Сбросить пароль
                    <small class="display-block"></small>
                </h5>
</div>

 
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                {{ csrf_field() }}

                <div class="col-xs-12 cont-form {{ $errors->has('email') ? ' has-error' : '' }}">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"
                 placeholder=" "          required>
                                  <label for="email">E-mail</label>

                 
                </div>
                
                @if ($errors->has('email'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                @endif
                
                
                
            <div class="cont-form col-xs-12 ">
    
                        <button type="submit" class="btn btn-primary " >
                            Сбросить
                        </button>        <a class="a-enter"  href="{{ route('login') }}">
                    Вход
                </a>
            </div>
       
     
    </form>
    
    
 </div>
         </div>

    </div> 
  </div>      
    <style>.a-enter{    display: block;
    float: right;
    margin-right: 19px;
    font-size: 14px;
    margin-top: 6px;}</style> 


@endsection
