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



            <div class="form-group row" style="margin-top: 10px">
                <div class="col-md-9">
                    {!! $fb_url !!}
                </div>

            </div>
            @if(count($fb_pages)>0)

                <div class="row">Выберите страницы для подключения к чат боту</div>
                @foreach($fb_pages as $item)
                    <div class="form-group row">
                        <input type="checkbox" name="pages[]" value="{{$item->vk_id}}" @if($item->status==1) checked @endif>{{$item->name}} @if($item->token!='')<i class="fa fa-check"></i>@endif

                    </div>

                @endforeach
                <div id="vk_but_now"></div>
            @endif




            <div class="form-group footer-button">
            <div class="col-xs-12">
            	<button type="button"  class="btn btn-primary  w_safebutton_vk">Сохранить</button>
       
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
