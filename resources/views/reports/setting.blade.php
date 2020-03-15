<style>
.switchery.switchery-small>small{
	display:block !important;}
</style>
        <form class="form-horizontal" action="" method="post">
            <input name="_token" type="hidden" value="{{ csrf_token() }}" />
            <input type="hidden" class="form-control" name="form_action"
                   value="allreports_setting">
   
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Статус:</label>
                       
                                          <span class="switchery-xs-new"><input type="checkbox" name="status" class="js-switch" id="status"
                                               @if($widget_js->status==1) checked @endif  value="1"></span>
                                  
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Создавать сделку:</label>
                                
 <span class="switchery-xs-new"><input type="checkbox" class="js-switch" name="create_lead" id="create_lead"
             @if($widget_js->params['create_lead']==1) checked @endif  value="1"></span>
                                
                                </div>

              <?php /*?>                  <div class="form-group">
                                    <label class="col-lg-3 control-label">Резерв номера (мин):</label>
                                    <div class="col-lg-9">
                                        <input type="text" name="phone_rezerv_time" id="phone_rezerv_time"
                                                  value="{{$min}}">
                                    </div>
                                </div><?php */?>


                                <input type="hidden" class="form-control" name="id" value="{{$widget_js->id}}" id="id"   >










                            </fieldset>
        

                    		<div class="form-group footer-button" style="    left: 2%;">
            <div class="col-xs-12">
            	<button type="button"  class="btn btn-primary  safe_setting_analitics w_safebutton" data-dismiss="modal" aria-hidden="true">Сохранить</button>
       
                <button type="button" class="btn btn-default " data-dismiss="modal" aria-hidden="true">Закрыть</button>
            </div>

        </div>  
        </form>


<script>
			  var elems = document.querySelectorAll('.js-switch');

for (var i = 0; i < elems.length; i++) {
  var switchery = new Switchery(elems[i], { size: 'small' , color: '#00B9EE'});
}
</script>
