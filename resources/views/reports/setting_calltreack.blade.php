
    <form class="form-horizontal" action="" method="post">
        <input name="_token" type="hidden" value="{{ csrf_token() }}" />
        <input type="hidden" class="form-control" name="form_action" value="calltrack_setting_ajax">

                            <div class="form-group">
                            <div class="col-lg-3">
                                <label class=" control-label" style="width:100%">Резерв номера (мин):</label>
                                </div>
                                <div class="col-lg-2" style="    margin-top: -5px;">
                                    <input type="text" name="phone_rezerv_time" id="phone_rezerv_time"
                                           value="{{$min}}">
                                </div>
                            </div>
        <div class="form-group" style="margin-left:0px;">
            <div class="navigation-header" style="padding-bottom: 30px;"><div style="float: left;margin-bottom: 10px;padding-right: 10px;"><label class="control-label" style="width: 100%;">Подмена номера на сайте</label></div> <? if(isset($status_checkbox)){?> <div class="switchery-xs switchery-xs2" style="margin-top: 4px;">{!! $status_checkbox !!}</div> <? } ?></div>



      		<div class="form-group footer-button" style="    left: 2%;">
            <div class="col-xs-12">
            	<button type="button"  class="btn btn-primary  safe_setting_analitics w_safebutton" data-dismiss="modal" aria-hidden="true">Сохранить</button>
       
                <button type="button" class="btn btn-default " data-dismiss="modal" aria-hidden="true">Закрыть</button>
            </div>

        </div>  
        
        
    </form>
<style>

.ClientInfoModal .switchery-xs2 .switchery>small{
	display:block !important;}
    
.checkbox.checkbox-switchery{margin-top: -4px;}    
    
    </style>

<script>var elems = document.querySelectorAll('.switchery');

for (var i = 0; i < elems.length; i++) {
  var switchery = new Switchery(elems[i], { size: 'small' , color: '#00B9EE'});
}</script>
