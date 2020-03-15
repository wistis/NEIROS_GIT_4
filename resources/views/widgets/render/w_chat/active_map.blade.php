@if($for_view)
<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading-5">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-5"
           aria-expanded="false" aria-controls="collapse-5">
            <div class="number-accardion">5</div>
            <div class="h-1">Схема проезда</div>
            <div class="descr-text">настройка формы обратной связи</div>
        </a>
    </div>


    <div id="collapse-5" class="panel-collapse collapse" role="tabpane5" aria-labelledby="heading-5">
@endif

    <form   id="wchat"  name="wchat" >
        <input type="hidden" class="form-control" name="id"
               value="{{$widget_vk->id}}">
        <input type="hidden" class="form-control" name="form_action"
               value="wchat_osn_5">
<div class="panel-body">

    <div class="col-md-6 mt-30">
        <label class="col-lg-3 control-label">Код для карты:</label>
        <div class="col-md-9">
            <textarea  class="form-control" name="map_html" id="map_html">
{{$widget_vk->map_html}}
            </textarea>

         

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
</div> @endif
