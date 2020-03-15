<div class="col-md-3 integration-item">
    <div class="single-cases-card" >
        <div class="card-image"><a data-toggle="modal" data-target="#myModal_sett_18"><img alt="" src="/global_assets/images/integration/roistat.jpg" draggable="false" class="img-responsive"></a>
            <div class="hover-area"> </div>
        </div>
        <!-- .card-image END -->

        <div class="cases-content col-xs-12">

            <span class="col-xs-12 text-center" > {!! $status_checkbox_metrika_modal !!}</span>
        </div>
        <!-- .cases-content END --></div>


</div>


<div id="myModal_sett_18" class="modal fade ClientInfoModal lids-neiros integration___modal WidgetModal">
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
           <div class="h1-modal pos-left"><img src="/images/roistat-integration.jpg"><span></span></div>
           
                  <input type="hidden" class="form-control" name="id"
                       value="{{$widgets_item->id}}">
                <input type="hidden" class="form-control" name="form_action"
                       value="integrationdirect">{!! $status_checkbox_metrika !!}
           </div>
            </div>
                <div class="row">

                    <div class="col-xs-12 block-descr">  
          <div class="col-sm-6"><div class="img-block-left"><img width="100%" src="/global_assets/images/integration/roistat.jpg"></div></div>
          <div class="col-sm-6">  
          	<div class="paragraph"> Roistat — это не просто аналитика, а целая система направленная на повышение продаж. Вы сможете принимать решения на основе прибыли, а не конверсии. Он предоставляет все необходимое для анализа и отслеживания клиентов: аналитика, отчеты, коллтрекинг, ловец лидов, емейлтрекинг, интеграция с CRM/CMS и многое другое.</div>
                    <input type="hidden" class="form-control" name="id"
                       value="{{$widgets_item->id}}">
                <input type="hidden" class="form-control" name="form_action"
                       value="integrationdirect">{!! $status_checkbox_metrika !!}

                
                </div>
                
            </div>






      <div class="show-hidden-integration">  
                    <div class="col-md-12">
                        <fieldset>
                            <form   id="integrationroistat"  name="integrationroistat" >
                                <input type="hidden" class="form-control" name="id"
                                       value="{{$widgets_item->id}}">
                                <input type="hidden" class="form-control" name="form_action"
                                       value="integrationriostat">
                                <div class="row">
                                    <div class="col-md-6">
                                        <fieldset>

                                            <div class="form-group">
                                                <label class="col-lg-3 control-label">token:</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" name="server1" id="server1"  value="{{$widgets_item->server1}}"  required>


                                                </div>

                                            </div>

















                                        </fieldset>
                                    </div>

                                    <div class="form-group footer-button">
                                        <div class="col-xs-12">
                                            <button type="button"  class="btn btn-primary  w_safebutton">Сохранить</button>

                                            <button type="button" class="btn btn-default " data-dismiss="modal" aria-hidden="true">Закрыть</button>
                                        </div>

                                    </div>

                                </div>







                            </form>
                        </fieldset>
                    </div>
           

</div>
                </div>

            </div>
        </div>
    </div>
</div>



