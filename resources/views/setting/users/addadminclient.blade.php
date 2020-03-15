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
                    <h5 class="panel-title">Создание Пользователя</h5>
                    <input name="projectId" type="hidden"  id="taskId" value="0" />
                    <input name="projectId" type="hidden"  id="adminadd" value="1" />
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <fieldset>
                                <legend class="text-semibold"><i class="icon-reading position-left"></i> Основная информация</legend>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Название компании:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="company" id="company"   required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Имя:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="name" id="name"   required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">E-mail:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="email" id="email"   required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Пароль:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="password" id="password"   required>
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
                                            <option value="0">Администратор</option>
                                            <option value="1">Пользователь</option>

                                        </select>
                                    </div>
                                </div>
                                <legend class="text-semibold"><i class="icon-reading position-left"></i> Доступ к модулям</legend>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Сделки:</label>
                                    <div class="col-lg-9">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"  name="modulsdelki" class="modulsdelki" value="read" >Просмотр
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"  name="modulsdelki" class="modulsdelki" value="create" >Создание
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"  name="modulsdelki" class="modulsdelki" value="edit" data-tip=" ">Редактирование
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"  name="modulsdelki" class="modulsdelki" value="delete" data-tip=" ">Удаление
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
                                                <input type="checkbox"  name="modultask" class="modultask" value="read" >Просмотр
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"  name="modultask" class="modultask" value="create" >Создание
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"  name="modultask" class="modultask" value="edit" data-tip=" ">Редактирование
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"  name="modultask" class="modultask" value="delete" data-tip=" ">Удаление
                                            </label>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Контакты:</label>
                                    <div class="col-lg-9">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"  name="modulcontact" class="modulcontact" value="read" >Просмотр
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"  name="modulcontact" class="modulcontact" value="create" >Создание
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"  name="modulcontact" class="modulcontact" value="edit" data-tip=" ">Редактирование
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"  name="modulcontact" class="modulcontact" value="delete" data-tip=" ">Удаление
                                            </label>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Компании:</label>
                                    <div class="col-lg-9">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"  name="modulcompany" class="modulcompany" value="read" >Просмотр
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"  name="modulcompany" class="modulcompany" value="create" >Создание
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"  name="modulcompany" class="modulcompany" value="edit" data-tip=" ">Редактирование
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"  name="modulcompany" class="modulcompany" value="delete" data-tip=" ">Удаление
                                            </label>
                                        </div>
                                    </div>

                                </div>



                            </fieldset>
                        </div>
                    </div>

                    <div class="text-right">
                        <button type="button" class="btn btn-primary edit_usersadmin">Создать<i class="icon-arrow-right14 position-right"></i></button>
                    </div>
                </div>
            </div>
        </form>

@endsection
