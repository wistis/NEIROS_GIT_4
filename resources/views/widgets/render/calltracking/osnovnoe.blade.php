<div class="row tab-pane " id="basic-tab1">

    <div class="col-md-6">
        <fieldset>
<form   id="caltrackingosnovnoe"  name="caltrackingosnovnoe" >

            <div class="form-group">
                <label class="col-lg-3 control-label">Class или ID:</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="element"
                           value="{{$widget->element}}">
                    <input type="hidden" class="form-control" name="id"
                           value="{{$widget_call_track->id}}">
                    <input type="hidden" class="form-control" name="form_action"
                           value="caltrackingosnovnoe">

                    <input type="hidden" value="0" name="phone_status_dinamic">
                    <input type="checkbox" value="1" name="phone_status_dinamic">Использовать динамику с меткой neiros



                </div>

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
