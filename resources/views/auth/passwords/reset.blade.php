@extends('auth.app')

@section('content')

                    <form class="form-horizontal" method="POST" action="{{ route('password.request') }}">
                        <div class="panel panel-body login-form">
                            <div class="text-center">
                                <div class="    "><img src="/Neiros.png"></div>
                                <h5 class="content-group">Восстановление пароля
                                    <small class="display-block"></small>
                                </h5>
                            </div>

                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">



                                <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" placeholder="E-mail" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif

                        </div>

                        <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">

                                <input id="password" type="password" class="form-control" name="password" placeholder="Новый пароль" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif

                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">


                                <input id="password-confirm" type="password" class="form-control" placeholder="Повтор пароля" name="password_confirmation" required>

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif

                        </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" style="width: 100%">
                                    Сохранить
                                </button></div>
                            <div class="text-center">
                                <a  href="{{ route('login') }}">
                                    Вход
                                </a>

                            </div>

                    </div>
                    </form>


@endsection
