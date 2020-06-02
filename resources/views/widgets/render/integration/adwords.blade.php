<style>.ClientInfoModal.modal.fade:not(.in) .modal-dialog {
        -webkit-transform: translate3d(25%, 0, 0);
        transform: translate3d(25%, 0, 0);

    }</style>


<div class="col-md-3 integration-item">
    <div class="single-cases-card">
        <div class="card-image"><a data-toggle="modal" data-target="#myModal_sett_20">
                <img alt="" src="/global_assets/images/integration/aws.jpg" draggable="false" class="img-responsive" ></a>
            <div class="hover-area"> </div>
        </div>
        <!-- .card-image END -->

        <div class="cases-content col-xs-12">

            <span class="col-xs-12 text-center"> {!! $status_checkbox_metrika_modal !!}</span>

            <!-- .cases-content END --></div>


    </div>
</div>

<div id="myModal_sett_20" class="modal fade ClientInfoModal lids-neiros integration___modal WidgetModal">
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
           <div class="h1-modal pos-left"><img src="/images/aws-integration.jpg"><span></span></div>
           
            <input type="hidden" class="form-control" name="id" value="{{$widget_ad->id}}">
                            <input type="hidden" class="form-control" name="form_action"
                                   value="integrationadwords">
                            <fieldset> {!! $status_checkbox_metrika !!}
           </div>
            </div>
            
            
                <div class="row">
                    <form id="integrationdirect" name="integrationdirect">
                    
                    <div class="col-xs-12 block-descr">  
          <div class="col-sm-6"><div class="img-block-left"><img width="100%" src="/global_assets/images/integration/aws.jpg"></div></div>
          <div class="col-sm-6">  
          	<div class="paragraph"> Ads (ранее известный как AdWords)  - сервис контекстной, в основном, поисковой рекламы от компании Google, предоставляющий удобный интерфейс и множество инструментов для создания эффективных рекламных сообщений. Ads — флагманский рекламный проект Google и основной источник доходов компании. 24 июля 2018 года бренд AdWords изменил название на Google Ads, а также получил новый логотип. В России название сервиса AdWords изменилось на «Google Реклама». Новый бренд символизирует весь доступный спектр рекламных кампаний, включая поисковые, медийные и видеокампании.</div>
          
              <input type="hidden" class="form-control" name="id"
                                   value="{{$widget_ad->id}}">
                            <input type="hidden" class="form-control" name="form_action"
                                   value="integrationadwords">
                            <fieldset> {!! $status_checkbox_metrika !!}
                
                </div>
                
            </div>
                    <div class="show-hidden-integration"> 
                        <div class="col-xs-12">

              


                                <div class="form-group col-md-12">
                                
                                    <label class="col-lg-5 control-label"> 1. <a href="/set_token_adwords/{{$widget_ad->id}}" target="_blank" class="btn btn-info btn-sm">Получить токен
                                        </a></label>
                                    <div class="col-md-7">



                                    </div>

                                </div>
                                <div class="form-group col-md-12"  >
                                    <label class="col-lg-5 control-label">2. Введите полученый токен:</label>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control" name="token" id="token"
                                               value="{{$widget_ad->token}}" required autocomplete="off">


                                    </div>

                                </div>
                                <div class="form-group col-md-12">
                                    <label class="col-lg-5 control-label">3.Введите ваш Adwords ID :</label>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control" name="clientAdId" id="clientAdId"  value="{{$widget_ad->clientAdId}}" required>


                                    </div>

                                </div>

                                <div class="form-group" style="margin-top: 10px">
                                    <div class="col-md-9">
                                        <button type="button" class="btn btn-primary w_safebutton ">Подключить Adwords<i
                                                    class="icon-arrow-right14 position-right "></i></button>
                                    </div>

                                </div>


                            </fieldset>
                        </div>
                        {{--Дополнительные поля--}}
                        <div class="col-xs-12" style="margin-top:25px;">
                            <div class="form-group">
                                <label class="col-xs-12 control-label">Рекламные компании:</label>
                                <div class="col-xs-12"><div class="col-xs-12">
                    
                                
                                <label class="add-number-new-checkbox label-dir">Отметить все
                                                  <input type="checkbox" name="mft" id="mft"   value="1">
                                                            <span class="checkmark"></span>
                                                        </label>
                                
                                    </div>
                                    @foreach($counters_ad as $counter)

                                        <div class="col-xs-12">
                                        
                                        <label class="add-number-new-checkbox label-dir">    {{$counter->company}} ({{$counter->name}})
                                                           <input type="checkbox" name="radiocounter[]"  class="dircheck" @if($counter->status==1) checked="checked"
                                                    @endif value="{{$counter->company}}"  >
                                                            <span class="checkmark"></span>
                                                        </label>
                                     
                                        </div>
                                    @endforeach

                                </div>

                            </div>


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
            </div>
            <!-- Футер модального окна -->

        </div>
    </div>
</div>
<script>
    $("#mft").click( function() {
        if($("#mft").prop('checked')){
            $('.dircheck').prop('checked', true);
        } else {
            $('.dircheck').prop('checked', false);
        }
    });
</script>