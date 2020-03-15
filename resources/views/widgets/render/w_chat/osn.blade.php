@if($for_view)<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading-1">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-1" aria-expanded="false" aria-controls="collapse-1">
            <div class="number-accardion">1</div>
            <div class="h-1">Основное</div>
            <div class="descr-text">Основные настройки чата</div>
        </a>
    </div>
    <div id="collapse-1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-1">

     @endif   <div class="panel-body">
            <form   id="wchat"  name="wchat" >
                <input type="hidden" class="form-control" name="id"
                       value="{{$widget_vk->id}}">
                <input type="hidden" class="form-control" name="form_action"
                       value="wchat_osn_1">


                <div class="col-md-6">
                    <fieldset>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Статус виджета:</label>
                            <div class="col-lg-9">
                                <div class="checkbox checkbox-switchery">
                                    <label>
                                        <input type="hidden" name="status" value="0">
                                        <input type="checkbox" class="switchery" id="status" value="1"
                                               name="status" @if($widget->status==1)   checked="checked"
                                               @endif  data-id="{{$widget->id}}">

                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Модули виджета:</label>
                            <div class="col-lg-9">
                                @if($for_view) <div class="checkbox checkbox-switchery">
                                    <label>
                                        <input type="hidden" name="active_chat" value="0">
                                        <input type="checkbox" class="switchery" id="active_chat" onclick="show_tab('active_chat')" value="1"
                                               name="active_chat" @if($widget_vk->active_chat==1) checked="checked"
                                               @endif  data-id="{{$widget->id}}">Чат

                                    </label>
                                </div>@endif
                                <div class="checkbox checkbox-switchery">
                                    <label>
                                        <input type="hidden" name="active_callback" value="0">
                                        <input type="checkbox" class="switchery" id="active_callback"  onclick="show_tab('active_callback')" value="1"
                                               name="active_callback" @if($widget_vk->active_callback==1) checked="checked"
                                               @endif  data-id="{{$widget->id}}">Обратный звонок

                                    </label>
                                </div>
                                @if($for_view)
                                <div class="checkbox checkbox-switchery">
                                    <label>
                                        <input type="hidden" name="active_formback" value="0">
                                        <input type="checkbox" class="switchery" id="active_formback" onclick="show_tab('active_formback')"  value="1"
                                               name="active_formback" @if($widget_vk->active_formback==1) checked="checked"
                                               @endif  data-id="{{$widget->id}}">Написать нам

                                    </label>
                                </div>
                                <div class="checkbox checkbox-switchery">
                                    <label><input type="hidden" name="active_map" value="0">
                                        <input type="checkbox" class="switchery" id="active_map" onclick="show_tab('active_map')"  value="1"
                                               name="active_map" @if($widget_vk->active_map==1) checked="checked"
                                               @endif  data-id="{{$widget->id}}">Карта

                                    </label>
                                </div>
                              <div class="checkbox checkbox-switchery">
                                    <label><input type="hidden" name="active_social" value="0">
                                        <input type="checkbox" class="switchery" id="active_social" onclick="show_tab('active_social')" value="1"
                                               name="active_social" @if($widget_vk->active_map==1) checked="checked"
                                               @endif  data-id="{{$widget->id}}">Соц сети

                                    </label>
                                </div>
@endif
                            </div>
                        </div>



                       {{-- @if($for_view)  <div class="form-group">
                            <label class="col-lg-3 control-label">Создавать сделку :</label>
                            <div class="col-lg-9">
                                <div class="checkbox checkbox-switchery">
                                    <label>
                                        <input type="hidden" name="create_project" value="0">
                                        <input type="checkbox" class="switchery" id="create_project"
                                               name="create_project" value="1"
                                               @if($widget_vk->create_project==1) checked="checked"
                                               @endif  data-id="{{$widget->id}}">

                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Включить уведомление в браузере:</label>
                            <div class="col-lg-9">
                                <div class="checkbox checkbox-switchery">
                                    <label>

                                        <input type="checkbox" class="switchery" id="rr"  onclick="subscribe();return false;"
                                               name="rr" value="1"
                                               @if($prov_google_token==1) checked="checked"
                                                @endif   >

                                    </label>
                                </div>
                            </div>
                        </div>
@endif
--}}
                    </fieldset>
                </div>
                {{--@if($for_view)   <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Телефон :</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="phone" id="phone"
                                   value="{{$widget_vk->phone}}">

                        </div>

                    </div>
                </div>@endif--}}
                <div class="form-group" style="margin-top: 10px">
                    <div class="col-md-9">
                        <button type="button" class="btn btn-primary w_safebutton ">Сохранить<i
                                    class="icon-arrow-right14 position-right " ></i></button>
                    </div>

                </div>
            </form>
            <div class="col-xs-12 block-save-btn ">
                <button type="button" class="btn btn-primary widget-save-btn" data-id="">Сохранить</button>
            </div>
        </div>
        @if($for_view)
    </div>
</div>@endif


