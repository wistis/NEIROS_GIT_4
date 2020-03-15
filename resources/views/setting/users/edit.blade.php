@extends('app')
@section('title')
    Этапы сделок

@endsection
@section('content')

    <input name="_token" type="hidden" value="{{ csrf_token() }}" />


    <!-- Fieldset legend -->
    <div class="row">

        <!-- /fieldset legend -->


        <!-- 2 columns form -->
        <form class="form-horizontal" action="#" method="post">
            <input name="_token" type="hidden" value="{{ csrf_token() }}" />

            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h5 class="panel-title">Редактирование Пользователя</h5>
                    <input name="taskId" type="hidden"  id="taskId" value="{{$user->id}}" />
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <fieldset>
                                <legend class="text-semibold"><i class="icon-reading position-left"></i> Основная информация</legend>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Имя:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="name" id="name"   required value="{{$user->name}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">E-mail:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="email" id="email"   required value="{{$user->email}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Телефон:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="phone" id="phone"   required value="{{$user->phone}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Пароль:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="password" id="password"   required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Api Key:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="apikey" id="apikey"  value="{{$user->apikey}}" >
                                    </div>
                                </div>




                                <legend class="text-semibold"><i class="icon-reading position-left"></i> Тариф</legend>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Тариф: </label>
                                    <div class="col-lg-9">@php
                                                $tarifs=DB::table('tarifs')->get()
                                                @endphp
                                        <select name="tarif" id="tarif" class="form-control">
                                           @foreach($tarifs as $tar)
                                                <option value="{{$tar->id}}" @if($user->tarif==$tar->id) selected @endif>{{$tar->name}}</option>
                                               @endforeach


                                        </select>
                                    </div>
                                </div>


                            </fieldset>
                        </div>
                        {{--Дополнительные поля--}}
                        <div class="col-md-6">
                            <fieldset>
                                <legend class="text-semibold"><i class="icon-reading position-left"></i> Права доступа</legend>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Роль:</label>
                                    <div class="col-lg-9">
                                        <select name="role" id="role" class="form-control">
                                            <option value="0" @if($user->role==0) selected @endif>Администратор</option>
                                            <option value="1" @if($user->role==1) selected @endif>Пользователь</option>
                                            <option value="2" @if($user->role==2) selected @endif>Оператор</option>

                                        </select>
                                    </div>
                                </div>
                                <legend class="text-semibold"><i class="icon-reading position-left"></i> Доступ к модулям</legend>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Сделки:</label>
                                    <div class="col-lg-9">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"  name="modulsdelki" class="modulsdelki" value="read"   @if($modulsdelki->read==1) checked @endif>Просмотр
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"  name="modulsdelki" class="modulsdelki" value="create"  @if($modulsdelki->create==1) checked @endif >Создание
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"  name="modulsdelki" class="modulsdelki" value="edit"  @if($modulsdelki->edit==1) checked @endif>Редактирование
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"  name="modulsdelki" class="modulsdelki" value="delete"  @if($modulsdelki->delete==1) checked @endif>Удаление
                                            </label>
                                        </div>
                                    </div>

                                </div>
                                {{--
                                --}}
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Задачи:</label>
                                    <div class="col-lg-9">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"  name="modultask" class="modultask" value="read"  @if($modultask->read==1) checked @endif>Просмотр
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"  name="modultask" class="modultask" value="create"   @if($modultask->create==1) checked @endif >Создание
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"  name="modultask" class="modultask" value="edit"   @if($modultask->edit==1) checked @endif>Редактирование
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"  name="modultask" class="modultask" value="delete"   @if($modultask->delete==1) checked @endif>Удаление
                                            </label>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Контакты:</label>
                                    <div class="col-lg-9">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"  name="modulcontact" class="modulcontact" value="read"  @if($modulcontact->read==1) checked @endif>Просмотр
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"  name="modulcontact" class="modulcontact" value="create" @if($modulcontact->ceate==1) checked @endif >Создание
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"  name="modulcontact" class="modulcontact" value="edit" @if($modulcontact->edit==1) checked @endif>Редактирование
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"  name="modulcontact" class="modulcontact" value="delete" @if($modulcontact->delete==1) checked @endif>Удаление
                                            </label>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Компании:</label>
                                    <div class="col-lg-9">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"  name="modulcompany" class="modulcompany" value="read" @if($modulcompany->read==1) checked @endif>Просмотр
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"  name="modulcompany" class="modulcompany" value="create"  @if($modulcompany->create==1) checked @endif>Создание
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"  name="modulcompany" class="modulcompany" value="edit"  @if($modulcompany->edit==1) checked @endif>Редактирование
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"  name="modulcompany" class="modulcompany" value="delete" @if($modulcompany->delete==1) checked @endif>Удаление
                                            </label>
                                        </div>
                                    </div>

                                </div>



                            </fieldset>
                        </div>
                    </div>

                    <div class="text-right">
                        <button type="button" class="btn btn-primary edit_users">Создать<i class="icon-arrow-right14 position-right"></i></button>
                    </div>
                </div>
            </div>
        </form>

@endsection
