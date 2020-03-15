@if($for_view)
<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading-4">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-4"
           aria-expanded="false" aria-controls="collapse-4">
            <div class="number-accardion">4</div>
            <div class="h-1">Форма обратной связи</div>
            <div class="descr-text">настройка формы обратной связи</div>
        </a>
    </div>


    <div id="collapse-4" class="panel-collapse collapse" role="tabpane4" aria-labelledby="heading-4">
@endif
    <form   id="wchat"  name="wchat" >
        <input type="hidden" class="form-control" name="id"
               value="{{$widget_vk->id}}">
        <input type="hidden" class="form-control" name="form_action"
               value="wchat_osn_4">



<div class="panel-body">

    <div class="col-md-6 mt-30">
        <label class="col-lg-3 control-label">E-mail для уведомлений:</label>
        <div class="col-md-9">
            <input type="text" class="form-control" name="formback_email" id="formback_email"
                   value="{{$widget_vk->formback_email}}">

        </div>

    </div>
    <div class="col-md-6 mt-30">
        <label class="col-lg-3 control-label">Темы обращений через запятую:</label>
        <div class="col-md-9">
            <input type="text" class="form-control" name="formback_tema" id="formback_tema"
                   value="{{$widget_vk->formback_tema}}">

        </div>

    </div>
    <div class="col-md-12 mt-30 row mb-20">
        <label class="col-lg-3 control-label">Текст после отправки формы:</label>
        <div class="col-md-9">

            <input type="text" class="form-control" name="callback_end_text" id="callback_end_text"
                   value="{{$widget_vk->callback_end_text}}">

        </div>

    </div>
    <hr><h4>Настройка видимости полей формы</h4>
    <div class="form-group col-md-6">
        <label class="col-lg-3 control-label">Видимость поля Имени :</label>
        <div class="col-lg-9">
            <div class="checkbox checkbox-switchery">
                <label>
                    <input type="hidden" name="formback_pole_name" value="0">
                    <input type="checkbox" class="switchery" id="formback_pole_name"
                           name="formback_pole_name" value="1"
                           @if($widget_vk->formback_pole_name==1) checked="checked"
                           @endif  data-id="{{$widget->id}}">

                </label>
            </div>
        </div>
    </div>
    <div class="form-group col-md-6">
        <label class="col-lg-3 control-label">Обязательное поля Имени :</label>
        <div class="col-lg-9">
            <div class="checkbox checkbox-switchery">
                <label>
                    <input type="hidden" name="formback_name_rec" value="0">
                    <input type="checkbox" class="switchery" id="formback_name_rec"
                           name="formback_name_rec" value="1"
                           @if($widget_vk->formback_name_rec==1) checked="checked"
                           @endif  data-id="{{$widget->id}}">

                </label>
            </div>
        </div>
    </div>
{{--Поле емаил--}}
    <div class="form-group col-md-6">
        <label class="col-lg-3 control-label">Видимость поля E-mail :</label>
        <div class="col-lg-9">
            <div class="checkbox checkbox-switchery">
                <label>
                    <input type="hidden" name="formback_pole_email" value="0">
                    <input type="checkbox" class="switchery" id="formback_pole_email"
                           name="formback_pole_email" value="1"
                           @if($widget_vk->formback_pole_email==1) checked="checked"
                           @endif  data-id="{{$widget->id}}">

                </label>
            </div>
        </div>
    </div>
    <div class="form-group col-md-6">
        <label class="col-lg-3 control-label">Обязательное поля E-mail :</label>
        <div class="col-lg-9">
            <div class="checkbox checkbox-switchery">
                <label>
                    <input type="hidden" name="formback_email_rec" value="0">
                    <input type="checkbox" class="switchery" id="formback_email_rec"
                           name="formback_email_rec" value="1"
                           @if($widget_vk->formback_email_rec==1) checked="checked"
                           @endif  data-id="{{$widget->id}}">

                </label>
            </div>
        </div>
    </div>

{{--Поле темы--}}
    <div class="form-group col-md-6">
        <label class="col-lg-3 control-label">Видимость поля Темы :</label>
        <div class="col-lg-9">
            <div class="checkbox checkbox-switchery">
                <label>
                    <input type="hidden" name="formback_pole_tema" value="0">
                    <input type="checkbox" class="switchery" id="formback_pole_tema"
                           name="formback_pole_tema" value="1"
                           @if($widget_vk->formback_pole_tema==1) checked="checked"
                           @endif  data-id="{{$widget->id}}">

                </label>
            </div>
        </div>
    </div>
    <div class="form-group col-md-6">
        <label class="col-lg-3 control-label">Обязательное поля Темы :</label>
        <div class="col-lg-9">
            <div class="checkbox checkbox-switchery">
                <label>
                    <input type="hidden" name="formback_tema_rec" value="0">
                    <input type="checkbox" class="switchery" id="formback_tema_rec"
                           name="formback_tema_rec" value="1"
                           @if($widget_vk->formback_tema_rec==1) checked="checked"
                           @endif  data-id="{{$widget->id}}">

                </label>
            </div>
        </div>
    </div>


    {{-- `formback_pole_name`, `formback_pole_email`, `formback_pole_tema`, `formback_name_rec`, `formback_email_rec`, `formback_tema_rec--}}
    <div class="form-group" style="margin-top: 10px">
        <div class="col-md-9">
            <button type="button" class="btn btn-primary w_safebutton ">Сохранить<i
                        class="icon-arrow-right14 position-right " ></i></button>
        </div>

    </div>
    </div>
        </form>
@if($for_view) </div>
    </div> @endif