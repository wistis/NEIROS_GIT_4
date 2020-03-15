<script src="/vendor/jscolor.js"></script>
<input type="hidden" name="form_action" value="catch_lead_ad_ab">
<input type="hidden" name="widget_id" value="{{$info->widget_id}}">
<input type="hidden" name="shows" value="0">
<input type="hidden" name="leads" value="0">
<input type="hidden" name="widget_catch_lead_id" value="{{$info->widget_catch_lead_id}}">
<input type="hidden" name="my_company_id" value="{{$info->my_company_id}}">

<input type="hidden" id="ab_id"  name="id" value="{{$info->id or '0'}}">

<div class="panel-body">
    <div class="row">
        <div class="col-md-12">
            <fieldset>
                <div class="form-group col-md-12">
                    <label class="col-lg-5 control-label">Текст 1 окна:</label>
                    <div class="col-lg-7">
                        <input type="text" class="form-control" name="position_1_text" value="{{$info->position_1_text or 'Вы нашли, что искали?'}}">
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <label class="col-lg-5 control-label">Текст кнопки ДА:</label>
                    <div class="col-lg-7">
                        <input type="text" class="form-control" name="position_1_yes_text"  value="{{$info->position_1_yes_text or 'ДА'}}"   >
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <label class="col-lg-5 control-label">Цвет кнопки ДА:</label>
                    <div class="col-lg-7">
                        <input type="text" class="form-control jscolor" name="position_1_yes_bcolor"  value="{{$info->position_1_yes_bcolor or '00B9EE'}}"    >
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <label class="col-lg-5 control-label">Цвет текста кнопки ДА:</label>
                    <div class="col-lg-7">
                        <input type="text" class="form-control jscolor" name="position_1_yes_tcolor"   value="{{$info->position_1_yes_tcolor or 'ffffff'}}"   >
                    </div>
                </div>


                <div class="form-group col-md-12">
                    <label class="col-lg-5 control-label">Текст кнопки НЕТ:</label>
                    <div class="col-lg-7">
                        <input type="text" class="form-control" name="position_1_not_text"  value="{{$info->position_1_not_text or 'НЕТ'}}"    >
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <label class="col-lg-5 control-label">Цвет кнопки НЕТ:</label>
                    <div class="col-lg-7">
                        <input type="text" class="jscolor" name="position_1_not_bcolor" value="{{$info->position_1_not_bcolor or '00B9EE'}}"    >
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <label class="col-lg-5 control-label">Цвет текста кнопки НЕТ:</label>
                    <div class="col-lg-7">
                        <input type="text" class="form-control jscolor" name="position_1_not_rcolor"  value="{{$info->position_1_not_rcolor or 'ffffff'}}"     >
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <label class="col-lg-5 control-label">Показывать 1 окно?:</label>
                    <div class="col-lg-7">
                        <input type="hidden" name="first_step_status" value="0">
                        <input type="checkbox" name="first_step_status" value="1"
                               @if((isset($info->first_step_status))&&($info->first_step_status==1))
                               checked @endif
                               @if(!isset($info->first_step_status) )
                               checked @endif
                        >
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <label class="col-lg-5 control-label">Статус АB:</label>
                    <div class="col-lg-7">
                        <input type="hidden" name="status" value="0">
                        <input type="checkbox" name="status" value="1" @if((isset($info->status))&&($info->status==1))
                        checked @endif
                               @if(!isset($info->status) )
                               checked @endif>
                    </div>
                </div>
            </fieldset>
        </div>
        {{--Дополнительные поля--}}

    </div>


</div>