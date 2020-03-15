<div class="col-md-3 integration-item">
    <div class="single-cases-card" >
        <div class="card-image"><a data-toggle="modal" data-target="#myModal_sett_6"><img alt="" src="/global_assets/images/integration/vk.jpg" draggable="false" class="img-responsive" ></a>
            <div class="hover-area"> </div>
        </div>
        <!-- .card-image END -->

        <div class="cases-content col-xs-12">

            <span class="col-xs-12 text-center" > {!! $status_checkbox_metrika_modal !!}</span>
            </div>
        <!-- .cases-content END --></div>


</div>


<div id="myModal_sett_6" class="modal fade ClientInfoModal lids-neiros integration___modal WidgetModal">
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
           <div class="h1-modal pos-left"><img src="/images/vk-integration.jpg"><span></span></div>
           
                 <input type="hidden" class="form-control" name="id"
                           value="{{$widget_vk->id}}">
                    <input type="hidden" class="form-control" name="form_action"
                           value="formintegrationvk">

                {!! $status_checkbox_metrika !!}
           </div>
            </div>
 
            
                   <fieldset>
                <form   id="formintegrationvk"  name="formintegrationvk" >     
            
         <div class="col-xs-12 block-descr">  
          <div class="col-sm-6"><div class="img-block-left"><img width="100%" src="/global_assets/images/integration/vk.jpg"></div></div>
          <div class="col-sm-6">  
          	<div class="paragraph">ВКонта́кте — российская социальная сеть со штаб-квартирой в Санкт-Петербурге. Сайт доступен на более чем 90 языках; особенно популярен среди русскоязычных пользователей. «ВКонтакте» позволяет пользователям отправлять друг другу сообщения, создавать собственные страницы и сообщества, обмениваться изображениями, тегами, аудио- и видеозаписями, играть в браузерные игры.</div>
          

                    <input type="hidden" class="form-control" name="id"
                           value="{{$widget_vk->id}}">
                    <input type="hidden" class="form-control" name="form_action"
                           value="formintegrationvk">

                {!! $status_checkbox_metrika !!}
                
                </div>
                
            </div>   
              <div class="show-hidden-integration">      
        <div class="col-xs-12">


                <div class="form-group row">
                    <label class="col-lg-3 control-label">ID группы:</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="groupid" id="groupid"  value="{{$widget_vk->groupid}}"  required>

                    </div>

                </div>
                <div class="form-group row">
                    <label class="col-lg-3 control-label">Код подтверждения:</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="confirmation" id="confirmation"  value="{{$widget_vk->confirmation}}"  required>

                    </div>

                </div>


                <div class="form-group row">
                    <label class="col-lg-3 control-label">Api Key:</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="apikey" id="apikey"  value="{{$widget_vk->apikey}}"  required>

                    </div>

                </div>
                <div class="form-group row">
                    <label class="col-lg-3 control-label">URL для Vk:</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="urllll" id=" "  value="https://cloud.neiros.ru/api/vkapi/callback_handleEvent/{{$sites->hash}}"  required>

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
