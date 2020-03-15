<div class="col-md-3 integration-item">
    <div class="single-cases-card" >
        <div class="card-image"><a data-toggle="modal" data-target="#myModal_sett_10"><img alt="" src="/global_assets/images/integration/telegram.jpg" draggable="false" class="img-responsive" ></a>
            <div class="hover-area"> </div>
        </div>
        <!-- .card-image END -->

        <div class="cases-content col-xs-12">

            <span class="col-xs-12 text-center"> {!! $status_checkbox_metrika_modal !!}</span>
            </div>
        <!-- .cases-content END --></div>


</div>

<div id="myModal_sett_10" class="modal fade ClientInfoModal lids-neiros integration___modal WidgetModal">
    <div class="modal-dialog" >
        <div class="modal-content"   style="height: 100vh">
            <!-- Заголовок модального окна -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                
            </div>
            <!-- Основное содержимое модального окна -->
            <div class="modal-body">
            <div class="name-block-fixed name-block-fixed-integration">
           <div class="col-xs-12" >
           <div class="h1-modal pos-left"><img src="/images/telegram-integration.jpg"><span></span></div>
           
                <input type="hidden" class="form-control" name="id"
                       value="{{$widget_vk->id}}">
                <input type="hidden" class="form-control" name="form_action"
                       value="formintegrationtelegram">

            {!! $status_checkbox_metrika !!}
           </div>
            </div>
            
        <fieldset>
            <form   id="formintegrationtelegram"  name="formintegrationtelegram" >

	<div class="col-xs-12 block-descr">  
          <div class="col-sm-6"><div class="img-block-left"><img width="100%" src="/global_assets/images/integration/telegram.jpg"></div></div>
          <div class="col-sm-6">  
          	<div class="paragraph">Telegram — кроссплатформенный мессенджер, позволяющий обмениваться сообщениями и медиафайлами многих форматов. Используются проприетарная серверная часть c закрытым кодом, работающая на мощностях нескольких компаний США и Германии, финансируемых Павлом Дуровым в объёме порядка 13 млн долларов США ежегодно, и несколько клиентов с открытым исходным кодом, в том числе под лицензией GNU GPL.</div>
          
                <input type="hidden" class="form-control" name="id"
                       value="{{$widget_vk->id}}">
                <input type="hidden" class="form-control" name="form_action"
                       value="formintegrationtelegram">

            {!! $status_checkbox_metrika !!}
                </div>
                
            </div>
      <div class="show-hidden-integration">  
    <div class="col-xs-12">








            <div class="form-group row">
                <label class="col-lg-3 control-label">Приветственное сообщение:</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="start_message" id="start_message"  value="{{$widget_vk->start_message}}"  required>

                </div>

            </div>


            <div class="form-group row">
                <label class="col-lg-3 control-label">Api Key:</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="apikey" id="apikey"  value="{{$widget_vk->apikey}}"  required>

                </div>

            </div>





                    <div class="form-group footer-button">
            <div class="col-xs-12">
            	<button type="button"  class="btn btn-primary  w_safebutton">Сохранить</button>
       
                <button type="button" class="btn btn-default " data-dismiss="modal" aria-hidden="true">Закрыть</button>
            </div>

        </div>


        {{--Дополнительные поля--}}

    </div>
</div>
</form>

        </fieldset>
                <!-- Футер модального окна -->
            </div>

        </div>
    </div>
</div>

