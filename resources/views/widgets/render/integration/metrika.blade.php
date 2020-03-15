<div class="col-md-3 integration-item">
        <div class="single-cases-card" >
            <div class="card-image"><a data-toggle="modal" data-target="#myModal_sett_1"><img alt="" src="/global_assets/images/integration/metrika.jpg" draggable="false" class="img-responsive" ></a>
                <div class="hover-area"> </div>
            </div>
            <!-- .card-image END -->

            <div class="cases-content col-xs-12">

                <span class="col-xs-12 text-center"> {!! $status_checkbox_metrika_modal !!}</span>
               </div>
            <!-- .cases-content END --></div>


    </div>

    <div id="myModal_sett_1" class="modal fade ClientInfoModal lids-neiros integration___modal WidgetModal">
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
           <div class="h1-modal pos-left"><img src="/images/yandex-metrika.jpg"><span></span></div>
           
      <input type="hidden" class="form-control" name="id"
                       value="{{$metrika_widget->id}}">
                <input type="hidden" class="form-control" name="form_action"
                       value="integrationdirect">{!! $status_checkbox_metrika !!}
                
           </div>
            </div>
                
                
                
                    <div class="row">

            <form   id="integrationmetrika"  name="integrationmetrika" >
            
       <div class="col-xs-12 block-descr">  
          <div class="col-sm-6"><div class="img-block-left"><img width="100%" src="/global_assets/images/integration/metrika.jpg"></div></div>
          <div class="col-sm-6">  
          	<div class="paragraph">Яндекс Метрика — бесплатный интернет-сервис компании Яндекс, предназначенный для оценки посещаемости веб-сайтов, и анализа поведения пользователей. На данный момент Яндекс.Метрика является третьей по размеру системой веб-аналитики в Европе.</div>
          
          
  
                       <input type="hidden" class="form-control" name="id"
                       value="{{$metrika_widget->id}}">
                <input type="hidden" class="form-control" name="form_action"
                       value="integrationdirect">{!! $status_checkbox_metrika !!}
                
                </div>
                
            </div>     
            <div class="show-hidden-integration">               
    <div class="col-xs-12">

                <input type="hidden" class="form-control" name="id"
                       value="{{$metrika_widget->id}}">
                <input type="hidden" class="form-control" name="form_action"
                       value="integrationmetrika">
                <div class="row">
                    <div class="col-md-6">
                        <fieldset>





                            <div class="form-group">
                                <label class="col-lg-3 control-label">token:</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="token" id="token"  value="{{$metrika_widget->token}}"  required>
                                    <a href="/set_token/{{$metrika_widget->id}}">Получить токен
                                    </a>
                                </div>

                            </div>



                        </fieldset>
                    </div>
                    {{--Дополнительные поля--}}
                  <div class="col-md-6">
                         <div class="form-group">
                             <label class="col-lg-3 control-label">Счетчики метрики:</label>
                             <div class="col-lg-9">
                                  @foreach($metrika_counters as $counter)

                                     <div><input type="radio"    name="radiocounter" @if($metrika_widget->counter==$counter->counter) checked="checked" @endif value="{{$counter->counter}}"  > {{$counter->site}} ({{$counter->counter}})</div>
@endforeach

                             </div>

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
    </div>
         </form>

    
    
    
    {{--Дополнительные поля--}}

       </div>

                </div>
            </div>
        </div>
        </div>


