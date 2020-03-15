@extends('auth.app')

@section('content')


    <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">

        <div class="panel panel-body login-form">
            <div class="text-center">
                <div class="    "><img src="/Neiros.png"></div>
                <h5 class="content-group">Сбросить пароль
                    <small class="display-block"></small>
                </h5>
            </div>


            <div class="panel-body">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                {{ csrf_field() }}

                <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"
                 placeholder="E-mail"          required>
                    <div class="form-control-feedback">
                        <i class="icon-mail5 text-muted"></i>
                    </div>
                </div>
                @if ($errors->has('email'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                @endif
            </div> <div class="form-group">
                        <button type="submit" class="btn btn-primary " style="width: 100%">
                            Сбросить пароль
                        </button>
            </div>
            <div class="text-center">
                <a  href="{{ route('login') }}">
                    Вход
                </a>

            </div>
        </div>
    </form>

@endsection
