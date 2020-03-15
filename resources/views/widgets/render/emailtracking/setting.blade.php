<div class="row tab-pane " id="basic-tab2">

    <div class="col-md-12">
        <fieldset>
            <form   id="emailtrackingsetting"  name="emailtrackingsetting" >
                <input type="hidden" class="form-control" name="id"
                       value="{{$widget_vk->id}}">
                <input type="hidden" class="form-control" name="form_action"
                       value="emailtrackingsetting">
                <div class="row tab-pane  "   id="basic-tab1">
                     <div class="col-md-6">
                        <fieldset>




                            <div class="form-group">
                                <label class="col-lg-3 control-label">E-mail:</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="email" id="email"  value="{{$widget_vk->email}}"  required>

                                </div>

                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Заменять ссылкой(mailto:):</label>
                                <div class="col-lg-9">
                                    <div class="checkbox checkbox-switchery">
                                        <label>
                                            <input type="hidden" name="url" value="0">
                                            <input type="checkbox" class="switchery"  value="1" id="url" name="url" @if($widget_vk->url==1) checked="checked" @endif  data-id="{{$widget->id}}">

                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Class или ID:</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="element" id="element"  value="{{$widget_vk->element}}"  required>

                                </div>

                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Сервер:</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="server" id="server"  value="{{$widget_vk->server}}"  required>

                                </div>

                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Логин:</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="login" id="login"  value="{{$widget_vk->login}}"  required>

                                </div>

                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Пароль:</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="password" id="password"  value="{{$widget_vk->password}}"  required>

                                </div>

                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" id="connect_email"></label>
                                <div class="col-md-9">
                                    <button onclick="test_email();return false" class="btn btn-info">Проверить соединение</button>

                                </div>

                            </div>










                        </fieldset>
                    </div>
                    {{--Дополнительные поля--}}

                </div>


                <div class="form-group" style="margin-top: 10px">
                    <div class="col-md-9">
                        <button type="button" class="btn btn-primary w_safebutton ">Сохранить<i
                                    class="icon-arrow-right14 position-right " ></i></button>
                    </div>

                </div>
            </form>
        </fieldset>
    </div>
    {{--Дополнительные поля--}}

</div>
