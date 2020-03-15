@extends('auth.app')

@section('content')

     

     
    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}
        <div class="panel panel-body login-form">
            <div class="text-center">
                <div class="    "><img src="Neiros.png"></div>
                <h5 class="content-group">Вход <small class="display-block"> </small></h5>
            </div>

            <div class="has-feedback has-feedback-left form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <input type="email" class="form-control"  name="email"  placeholder="E-mail"  value="{{ old('email') }}" required autofocus>

                <div class="form-control-feedback">
                    <i class="icon-user text-muted"></i>
                </div>
                @if ($errors->has('email'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} has-feedback has-feedback-left">
                <input id="password" type="password" class="form-control" name="password" placeholder="******" required >
                <div class="form-control-feedback">
                    <i class="icon-lock2 text-muted"></i>
                </div>
                @if ($errors->has('password'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                @endif
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Войти <i class="icon-circle-right2 position-right"></i></button>
            </div>

            <div class="text-center">
                <a  href="{{ route('password.request') }}">
                    Забыли пароль?
                </a>
                | <a  href="{{ route('register') }}">
                    Регистрация
                </a>
            </div>
        </div>
    </form>



@endsection
