@if($for_view)<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading-3">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-3"
           aria-expanded="false" aria-controls="collapse-3">
            <div class="number-accardion">3</div>
            <div class="h-1">Колбек</div>
            <div class="descr-text">Основные настройки чата</div>
        </a>
    </div>


    <div id="collapse-3" class="panel-collapse collapse" role="tabpane3" aria-labelledby="heading-3">
@endif
    <form   id="wchat"  name="wchat" >
        <input type="hidden" class="form-control" name="id"
               value="{{$widget_vk->id}}">
        <input type="hidden" class="form-control" name="form_action"
               value="wchat_osn_3">
<div class="panel-body">
    <div class="row">
        <div class="col-md-6">
            <p>Тип переадресации</p>
            <div><input type="radio" name="callback_tip" class="callback_tip" value="0" @if ($widget_vk->callback_tip==0) checked @endif

       
                        onclick="select_tip_redirect(0)"> Телефонный номер
            </div>
            <div><input type="radio" name="callback_tip" class="callback_tip" value="1"
                        onclick="select_tip_redirect(1)"  @if ($widget_vk->callback_tip==1) checked @endif> Учетная запись SIP
            </div>
            <div><input type="radio" name="callback_tip" class="callback_tip" value="2"
                        onclick="select_tip_redirect(2)"  @if ($widget_vk->callback_tip==2) checked @endif> Наша сип
            </div>

        </div>
        <div class="col-md-6">
            <p>Номер</p>
            <div id="block_0"><p>Номер должен начинаться с цифры 7, не содержать пробелов и
                    других
                    символов.Номер должен начинаться с цифры 7, не содержать пробелов и других
                    символов.</p><input type="text" value="{{$widget_vk->callback_phone0}}" id="callback_phone0" name="callback_phone0"
                                        class="form-control" placeholder="74993435366"></div>
            <div id="block_1" style="display: none">
                <div>Звонки по SIP бесплатны.</div>
                <input type="text" value="{{$widget_vk->callback_phone1}}" id="callback_phone1" name="callback_phone1" class="form-control"
                       placeholder="office@mydomain.ru"></div>
            <div id="block_2" style="display: none"><p>Оплата за минуты не взимается.
                    По указанным ниже параметрам можно подключить soft phone или вашу АТС.
                    Звонки
                    будут переводиться на подключенное устройство.</p>
                <div>Адрес: 82.146.43.227:25060<br>
                    Пользователь: 5{{Auth::user()->my_company_id}}{{$widget_vk->id}}{{$widget->id}}</div>
                <input type="hidden" name="callback_phone2" id="callback_phone2" class="form-control"
                       value="5{{Auth::user()->my_company_id}}{{$widget_vk->id}}{{$widget->id}}">
                <input type="text" value="{{$widget_vk->callback_phonepassword}}" id="callback_phonepassword" name="callback_phonepassword" class="form-control"
                       placeholder="Придумайте пароль"></div>

        </div>
    </div>
    <div class="col-md-6 mt-30">
        <label class="col-lg-3 control-label">Время отсчета в секундах:</label>
        <div class="col-md-9">
            <input type="text" class="form-control" name="callback_timer" id="callback_timer"
                   value="{{$widget_vk->callback_timer}}">

        </div>

    </div>
    <div class="col-md-12 mt-30 row mb-20">
        <label class="col-lg-3 control-label">Текст перед вводом номера:</label>
        <div class="col-md-9">
            Для вставки времени в текст используйте |time|
            <input type="text" class="form-control" name="callback_start_text" id="callback_start_text"
                   value="{{$widget_vk->callback_start_text}}">

        </div>

    </div>


    <div class="form-group" style="margin-top: 10px">
        <div class="col-md-9">
            <button type="button" class="btn btn-primary w_safebutton ">Сохранить<i
                        class="icon-arrow-right14 position-right " ></i></button>
        </div>

    </div>
</div>
</form>
        @if($for_view)
</div>
</div>
@endif