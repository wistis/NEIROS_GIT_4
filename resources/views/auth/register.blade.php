@extends('auth.app')

@section('content')
     {!! ReCaptcha::htmlScriptTagJsApi(/* $formId - INVISIBLE version only */) !!}
     <script src="/cdn/v1/catch_lead/js/jquery.inputmask.js"></script>                <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}
                        <div class="panel panel-body login-form">
                            <div class="text-center">
                                <div class="    "><img src="/Neiros.png"></div>
                                <h5 class="content-group">Регистрация
                                    <small class="display-block"></small>
                                </h5>
                            </div>
                            <input id="company" type="hidden" class="form-control" name="company" value=" " placeholder="Компания"  >

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
<input type="hidden" name="partner_id" value="{{request()->cookie('_ref')}}" autocomplete="off">


                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Имя" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif

                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">


                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="E-Mail" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        @if($errors->first('email')=='unique')
                                        <strong> Пользователь с таким e-mail уже зарегистрирован</strong>
                                         @else
                                        <strong>{{ $errors->first('email') }}</strong>@endif
                                    </span>
                                @endif

                        </div>
                            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">


                                <input id="phone" type="phone" class="form-control form-control-text-number-mask" name="phone" value="{{old('phone')}}" placeholder="+7 (___) ___ __ __" required>

                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                              @if($errors->first('phone')=='unique')
                                            <strong>Пользователь с таким номером уже зарегистрирован</strong>
                                        @else
                                            <strong>{{ $errors->first('phone') }}</strong>@endif
                                    </span>
                                @endif

                            </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">


                                <input id="password" type="password" class="form-control" name="password" placeholder="Пароль" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif

                        </div>

                        <div class="form-group">

                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Повтор пароля" required>

                        </div>
                            <div class="form-group">
                                @if ($errors->has('g-recaptcha-response'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                    </span>
                                @endif

                                {!! htmlFormSnippet() !!} </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" style="width: 100%">
                                    Регистрация
                                </button></div>
                            <div class="text-center">
                                <a  href="{{ route('login') }}">
                                    Вход
                                </a>

                            </div>
                        </div>
                    </form>
    <script> $(".form-control-text-number-mask").inputmask("+7 (999) 999-99-99", {"placeholder": "+7 (___) ___-__-__"});</script>
@endsection
