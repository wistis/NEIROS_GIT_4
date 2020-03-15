<div class="col-md-3 integration-item">
    <div class="single-cases-card" >
        <div class="card-image"><a data-toggle="modal" data-target="#myModal_sett_22"><img alt="" src="/images/google-analytics.jpg" draggable="false" class="img-responsive"></a>
            <div class="hover-area"> </div>
        </div>
        <!-- .card-image END -->

        <div class="cases-content col-xs-12">

            <span class="col-xs-12 text-center" > {!! $status_checkbox_metrika_modal !!}</span>
        </div>
        <!-- .cases-content END --></div>


</div>


<div id="myModal_sett_22" class="modal fade ClientInfoModal lids-neiros integration___modal WidgetModal">
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
           <div class="h1-modal pos-left"><img src="/images/ga-integration.jpg"><span></span></div>
           
               <input type="hidden" class="form-control" name="id"
                                   value="{{$widget_ga_call->id}}">
                            <input type="hidden" class="form-control" name="form_action"
                                   value="integrationgacall">{!! $status_checkbox_metrika !!}
           </div>
            </div>
            
                <div class="row">

                    <div class="col-xs-12 block-descr">
                        <div class="col-sm-6"><div class="img-block-left"><img width="100%" src="/images/google-analytics.jpg"></div></div>
                        <div class="col-sm-6">
                            <div class="paragraph">Бесплатный сервис, предоставляемый Google для создания детальной статистики посетителей веб-сайтов. Статистика собирается на сервере Google, пользователь только размещает JS-код на страницах своего сайта. Код отслеживания срабатывает, когда пользователь открывает страницу в своем веб-браузере (при условии разрешенного выполнения Javascript в браузере).</div>
                            <input type="hidden" class="form-control" name="id"
                                   value="{{$widget_ga_call->id}}">
                            <input type="hidden" class="form-control" name="form_action"
                                   value="integrationgacall">{!! $status_checkbox_metrika !!}


                        </div>

                    </div>






                    <div class="show-hidden-integration">
                        <div class="col-md-12">
                            <fieldset>
                                <form   id="integrationroistat"  name="integrationroistat" >
                                    <input type="hidden" class="form-control" name="id"
                                           value="{{$widget_ga_call->id}}">
                                    <input type="hidden" class="form-control" name="form_action"
                                           value="integrationgacall">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <fieldset>

                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label">Счетчик GA:</label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" name="element" id="element"  value="{{$widget_ga_call->element}}"  required>


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



