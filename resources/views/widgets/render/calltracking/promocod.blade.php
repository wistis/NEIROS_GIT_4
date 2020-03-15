


    <div class="col-md-12">
        <fieldset>
            <form   id="caltrackingpromocod"  name="caltrackingpromocod" >
            <div class="form-group">
                <label class="col-lg-3 control-label">Статус промокодов:</label>
                <div class="col-lg-9">
                  {{--  {!! $status_checkbox_metrika !!}--}}
                    <input type="hidden" name="status" value="0">
                    <input type="checkbox" name="status" value="1" @if($widget_prom->status==1) checked @endif>Включено
                </div>
            </div>


            <div class="form-group">
                <label class="col-lg-3 control-label">Цвет текста:</label>
                <div class="col-md-9">
                    <input type="text" class="form-control jscolor" name="color" id="color"  value="{{$widget_promokod->color}}"  required>

                </div>

            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label">Цвет фона:</label>
                <div class="col-md-9">
                    <input type="text" class="form-control jscolor" name="background" id="background"  value="{{$widget_promokod->background}}"  required>

                </div>

            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label">Расположение по горизонтали:</label>
                <div class="col-md-9">
                    <select id="position_x" name="position_x" class="form-control">
                        <option value="left" @if($widget_promokod->position_x=='left') selected @endif >Слева</option>
                        <option value="right" @if($widget_promokod->position_x=='right') selected @endif >Справа</option>

                    </select>


                </div>

            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label">Расположение по вертикали:</label>
                <div class="col-md-9">
                    <select id="position_y" name="position_y" class="form-control">
                        <option value="top" @if($widget_promokod->position_y=='top') selected @endif >Вверху</option>
                        <option value="bottom" @if($widget_promokod->position_y=='bottom') selected @endif >Внизу</option>

                    </select>


                </div>

            </div>
            <input type="hidden" class="form-control" name="id"
                   value="{{$widget_promokod->id}}">
            <input type="hidden" class="form-control" name="form_action"
                   value="caltrackingpromocod">







                <div class="form-group" style="margin-top: 10px">
                    <div class="col-md-9">
                        <button type="button" class="btn btn-primary w_safebutton">Сохранить<i
                                    class="icon-arrow-right14 position-right " ></i></button>
                    </div>

                </div>
            </form>
        </fieldset>
    </div>
