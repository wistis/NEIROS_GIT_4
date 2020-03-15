
    <form class="form-horizontal" action="" method="post">
        <input name="_token" type="hidden" value="{{ csrf_token() }}" />
        <input type="hidden" class="form-control" name="form_action" value="calltrack_setting_ajax">

                            <div class="form-group">
                                <label class="col-lg-3 control-label">Резерв номера (мин):</label>
                                <div class="col-lg-9">
                                    <input type="text" name="phone_rezerv_time" id="phone_rezerv_time"
                                           value="{{$min}}">
                                </div>
                            </div>

      		<div class="form-group footer-button" style="    left: 2%;">
            <div class="col-xs-12">
            	<button type="button"  class="btn btn-primary  safe_setting_analitics w_safebutton" data-dismiss="modal" aria-hidden="true">Сохранить</button>
       
                <button type="button" class="btn btn-default " data-dismiss="modal" aria-hidden="true">Закрыть</button>
            </div>

        </div>  
        
        
    </form>



