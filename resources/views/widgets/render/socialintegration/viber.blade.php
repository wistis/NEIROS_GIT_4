<div class="col-md-3 integration-item">
    <div class="single-cases-card" >
        <div class="card-image"><a data-toggle="modal" data-target="#myModal_sett_7"><img alt="" src="/global_assets/images/integration/viber.jpg" draggable="false" class="img-responsive"></a>
            <div class="hover-area"> </div>
        </div>
        <!-- .card-image END -->

        <div class="cases-content col-xs-12">

            <span class="col-xs-12 text-center"> {!! $status_checkbox_metrika_modal !!}</span>
             </div>
        <!-- .cases-content END --></div>


</div>

<div id="myModal_sett_7" class="modal fade ClientInfoModal lids-neiros integration___modal WidgetModal">
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
           <div class="h1-modal pos-left"><img src="/images/viber-integration.jpg"><span></span></div>
           
                  <input type="hidden" class="form-control" name="id"
                       value="{{$widget_vk->id}}">
                <input type="hidden" class="form-control" name="form_action"
                       value="formintegrationviber">

            {!! $status_checkbox_metrika !!}
           </div>
            </div>

            
        <fieldset>
            <form   id="formintegrationviber"  name="formintegrationviber" >
<div class="col-xs-12 block-descr">  
          <div class="col-sm-6"><div class="img-block-left"><img width="100%" src="/global_assets/images/integration/viber.jpg"></div></div>
          <div class="col-sm-6">  
          	<div class="paragraph">Viber — мессенджер с функцией VOIP (интернет-телефонии) для мобильных устройств и компьютеров. Запущен 2 декабря 2010 года израильтянами Тальмоном Марко и Игорем Магазинником. Первая версия программы работала только на iPhone и имела ограничения в 50 тыс. пользователей. В январе 2014 Viber куплена японской компанией Rakuten за 900 млн долларов.</div>
          
                <input type="hidden" class="form-control" name="id"
                       value="{{$widget_vk->id}}">
                <input type="hidden" class="form-control" name="form_action"
                       value="formintegrationviber">

            {!! $status_checkbox_metrika !!}
                
                </div>
                
            </div>
      <div class="show-hidden-integration">  
    <div class="col-md-12">



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
