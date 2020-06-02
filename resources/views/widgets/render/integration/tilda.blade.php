<div class="col-md-3 integration-item">
    <div class="single-cases-card" >
        <div class="card-image"><a data-toggle="modal" data-target="#myModal_sett_27"><img alt="" src="/global_assets/images/integration/tilda.jpg" draggable="false" class="img-responsive"></a>
            <div class="hover-area"> </div>
        </div>
        <!-- .card-image END -->

        <div class="cases-content col-xs-12">

            <span class="col-xs-12 text-center" > {!! $status_checkbox_metrika_modal !!}</span>
        </div>
        <!-- .cases-content END --></div>


</div>


<div id="myModal_sett_27" class="modal fade ClientInfoModal lids-neiros integration___modal WidgetModal">
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
                        <div class="h1-modal pos-left"><img src="/images/tilda-integration.jpg"><span></span></div>

                        <input type="hidden" class="form-control" name="id"
                               value="{{$widget_ga_call->id}}">
                        <input type="hidden" class="form-control" name="form_action"
                               value="integrationgacall">{!! $status_checkbox_metrika !!}
                    </div>
                </div>

                <div class="row">

                    <div class="col-xs-12 block-descr">
                        <div class="col-sm-6"><div class="img-block-left"><img width="100%" src="/global_assets/images/integration/tilda.jpg"></div></div>
                        <div class="col-sm-6">
                            <div class="paragraph">Создайте впечатляющий сайт на Tilda для бизнеса и медиа</div>
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
                                           value=" ">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <fieldset>

                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label">Адрес Webhook:</label>
                                                    <div class="col-md-9">
                                                        <input type="text" value=" https://cloud.neiros.ru/api/webhook/tilda/{{$site->hash}}" class="form-control" style="width: 100%">






                                                    </div>

                                                </div>

















                                            </fieldset>
                                        </div>

                                        <div class="form-group footer-button">
                                           {{-- <div class="col-xs-12">
                                                <button type="button"  class="btn btn-primary  w_safebutton">Сохранить</button>

                                                <button type="button" class="btn btn-default " data-dismiss="modal" aria-hidden="true">Закрыть</button>
                                            </div>--}}

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



