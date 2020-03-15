@if($for_view)<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading-255">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-255"
           aria-expanded="false" aria-controls="collapse-255">
            <div class="number-accardion">2</div>
            <div class="h-1">Чат</div>
            <div class="descr-text">Основные настройки чата</div>
        </a>
    </div>


    <div id="collapse-255" class="panel-collapse collapse" role="tabpane2" aria-labelledby="heading-255">
        @endif
        @include('modal.add_operator')
        <form id="wchat" name="wchat">
            <input type="hidden" class="form-control" name="id"
                   value="{{$widget_vk->id}}" id="rtutu">
            <input type="hidden" class="form-control" name="form_action"
                   value="wchat_osn_2">
            <div class="form-group">
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
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-lg-3 control-label">Телефон :</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="phone" id="phone"
                               value="{{$widget_vk->phone}}">

                    </div>

                </div>
            </div>
            <div class="col-md-12 ">
                <div class="form-group row">
                    <label class="col-lg-3 control-label">E-mail для уведомлений:</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="email" id="email"
                               value="{{$widget_vk->email}}" required>

                    </div>

                </div>










                <div class="form-group row" style="margin-top: 20px">
                    <div class="col-md-9">
                        <button type="button" class="btn btn-primary w_safebutton ">Сохранить<i
                                    class="icon-arrow-right14 position-right "></i></button>
                    </div>

                </div>

            </div>

            <div class="row">
                 </div>
        </form>
        @if($for_view)
    </div>
</div>@endif


{{--Дополнительные поля--}}
