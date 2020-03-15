@if($for_view)
<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading-6">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-6"
           aria-expanded="false" aria-controls="collapse-6">
            <div class="number-accardion">6</div>
            <div class="h-1">Соц сети</div>
            <div class="descr-text">настройка формы обратной связи</div>
        </a>
    </div>


    <div id="collapse-6" class="panel-collapse collapse" role="tabpane6" aria-labelledby="heading-6">
@endif
@json($widget_vk)
    <form   id="wchat"  name="wchat" >
        <input type="hidden" class="form-control" name="id"
               value="{{$widget_vk->id}}">
        <input type="hidden" class="form-control" name="form_action"
               value="wchat_osn_6">



<div class="panel-body">

    <div class="checkbox checkbox-switchery">
        <label class="row" style="width: 500px">
           <div class="col-md-2">VK</div>

            <div class="col-md-3">
                <input type="hidden" name="social_vk"  value="0">
                <input type="checkbox" class="switchery" id="social_vk" value="1"
                   name="social_vk" @if($widget_vk->social_vk==1) checked="checked" @endif  >
            </div>
            <div class="col-md-7"><input type="text" class="form-control" value="{{$widget_vk->social_vk_url}}" placeholder="URL" name="social_vk_url"></div>
        </label>
    </div>
    <div class="checkbox checkbox-switchery">
        <label class="row" style="width: 500px">
            <div class="col-md-2">Ok</div>

            <div class="col-md-3">
                <input type="hidden" name="social_ok"  value="0">
                <input type="checkbox" class="switchery" id="social_ok" value="1"
                       name="social_ok" @if($widget_vk->social_ok==1) checked="checked" @endif  >
            </div>
            <div class="col-md-7"><input type="text" class="form-control" value="{{$widget_vk->social_ok_url}}" placeholder="URL" name="social_ok_url"></div>
        </label>
    </div>
    <div class="checkbox checkbox-switchery">
        <label class="row" style="width: 500px">
            <div class="col-md-2">FaceBook</div>

            <div class="col-md-3">
                <input type="hidden" name="social_fb"  value="0">
                <input type="checkbox" class="switchery" id="social_fb" value="1"
                       name="social_fb" @if($widget_vk->social_fb==1) checked="checked" @endif  >
            </div>
            <div class="col-md-7"><input type="text" class="form-control" value="{{$widget_vk->social_fb_url}}" placeholder="URL" name="social_fb_url"></div>
        </label>
    </div>
    <div class="checkbox checkbox-switchery">
        <label class="row" style="width: 500px">
            <div class="col-md-2">Viber</div>

            <div class="col-md-3">
                <input type="hidden" name="social_viber"  value="0">
                <input type="checkbox" class="switchery" id="social_viber" value="1"
                       name="social_viber" @if($widget_vk->social_viber==1) checked="checked" @endif  >
            </div>
            <div class="col-md-7"><input type="text" class="form-control" value="{{$widget_vk->social_viber_url}}" placeholder="URL" name="social_viber_url"></div>
        </label>
    </div>
    <div class="checkbox checkbox-switchery">
        <label class="row" style="width: 500px">
            <div class="col-md-2">Telegram</div>

            <div class="col-md-3">
                <input type="hidden" name="social_tele"  value="0">
                <input type="checkbox" class="switchery" id="social_tele" value="1"
                       name="social_tele" @if($widget_vk->social_tele==1) checked="checked" @endif  >
            </div>
            <div class="col-md-7"><input type="text" class="form-control" value="{{$widget_vk->social_tele_url}}" placeholder="URL" name="social_tele_url"></div>
        </label>
    </div>
    <div class="form-group" style="margin-top: 10px">
        <div class="col-md-9">
            <button type="button" class="btn btn-primary w_safebutton ">Сохранить<i
                        class="icon-arrow-right14 position-right " ></i></button>
        </div>

    </div>
</div></form>
@if($for_view)</div>
</div> @endif
