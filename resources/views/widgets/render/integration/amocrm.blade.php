<div class="col-md-3 integration-item">
    <div class="single-cases-card" >
        <div class="card-image amocrm"><a data-toggle="modal" data-target="#myModal_sett_12"><img alt="" src="/global_assets/images/integration/amocrm.jpg" draggable="false" class="img-responsive"></a>
            <div class="hover-area"> </div>
        </div>
        <!-- .card-image END -->

        <div class="cases-content col-xs-12">

            <span class="col-xs-12 text-center"> {!! $status_checkbox_metrika_modal !!}</span>
             </div>
        <!-- .cases-content END --></div>


</div>

<div id="myModal_sett_12" class="modal fade ClientInfoModal lids-neiros integration___modal WidgetModal">
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
           <div class="h1-modal pos-left"><img src="/images/amocrm-integration.jpg"><span></span></div>
           
          <input type="hidden" class="form-control" name="id"
                       value="{{$widgets_bitrix24->id}}">
                <input type="hidden" class="form-control" name="form_action"
                       value="safeamocrm24">
              {!! $status_checkbox_metrika !!}
           </div>
            </div>
            
    <div class="row">
    
    
    
        <form id="safebitrix24" name="safebitrix24">  <div class="col-md-12">

<div class="col-xs-12 block-descr">  
          <div class="col-sm-6"><div class="img-block-left"><img width="100%" src="/global_assets/images/integration/amocrm.jpg"></div></div>
          <div class="col-sm-6">  
          	<div class="paragraph">AmoCRM – это наш собственный SaaS-проект, классический стартап, успешный и востребованный на рынке. amoCRM представляет собой онлайн-систему учета клиентов и сделок для отдела продаж. Более 5000 предприятий используют amoCRM по всему миру; в базе данных системы содержится более 200 млн контактов. В нашей партнерской сети более 200 участников в странах СНГ.</div>
          
          <input type="hidden" class="form-control" name="id"
                       value="{{$widgets_bitrix24->id}}">
                <input type="hidden" class="form-control" name="form_action"
                       value="safeamocrm24">
              {!! $status_checkbox_metrika !!}
                
                </div>
                
            </div>


            </div>
          <div class="show-hidden-integration">   
            <div class="col-xs-12">
                         <div class="form-group">
                        <label class="col-lg-3 control-label">Адрес AmoCrm:</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="server1" id="server1"
                                   value="{{$widgets_bitrix24->server1}}" required>

                        </div>

                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Логин:</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="login" id="login"
                                   value="{{$widgets_bitrix24->login}}" required>

                        </div>

                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Api ключ:</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="password" id="password"
                                   value="{{$widgets_bitrix24->password}}" required>

                        </div>

                    </div>
                    </div>
            
            {{--Дополнительные поля--}}

                <div class=" row col-md-12 statusamocrm" style="background: white">

                </div>
               <div class="form-group footer-button">
            <div class="col-xs-12">
            	<button type="button"  class="btn btn-primary  w_safebutton">Сохранить</button>
       
                <button type="button" class="btn btn-default " data-dismiss="modal" aria-hidden="true">Закрыть</button>
            </div>

        </div>
        
        
          </div>
        </form>


    </div>
                <!-- Футер модального окна -->
            </div>

        </div>
    </div>
</div>
