<div class="col-md-3 integration-item">
    <div class="single-cases-card" >
        <div class="card-image"><a data-toggle="modal" data-target="#myModal_sett_9"><img alt="" src="/global_assets/images/integration/fb.jpg" draggable="false" class="img-responsive"></a>
            <div class="hover-area"> </div>
        </div>
        <!-- .card-image END -->

        <div class="cases-content col-xs-12">

            <span class="col-xs-12 text-center"> {!! $status_checkbox_metrika_modal !!}</span>
             </div>
        <!-- .cases-content END --></div>


</div>

<div id="myModal_sett_9" class="modal fade ClientInfoModal lids-neiros integration___modal WidgetModal">
    <div class="modal-dialog" >
        <div class="modal-content"   style="height: 100vh">
            <!-- Заголовок модального окна -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
         <?php /*?>       <h4 class="modal-title">FaceBook</h4>
                <div>Подключение месседжера Facebook</div><?php */?>
            </div>
            <!-- Основное содержимое модального окна -->
            <div class="modal-body">
<div class="name-block-fixed name-block-fixed-integration">
           <div class="col-xs-12" >
           <div class="h1-modal pos-left"><img src="/images/facebook-integration.jpg"><span></span></div>
           
                       <input type="hidden" class="form-control" name="id"
                       value="{{$widget_vk->id}}">
                <input type="hidden" class="form-control" name="form_action"
                       value="formintegrationfb">
           {!! $status_checkbox_metrika !!}
           </div>
            </div>
<div class="row">

<div class="col-xs-12 block-descr">  
          <div class="col-sm-6"><div class="img-block-left"><img width="100%" src="/global_assets/images/integration/fb.jpg"></div></div>
          <div class="col-sm-6">  
          	<div class="paragraph">Facebook – крупнейшая социальная сеть в мире[4] и одноименная компания (Facebook Inc.), владеющая ею. Была основана 4 февраля 2004 года Марком Цукербергом и его соседями по комнате во время обучения в Гарвардском университете — Эдуардо Саверином, Дастином Московицем и Крисом Хьюзом.</div>
            <form   id="formintegrationfb"  name="formintegrationfb" >
                <input type="hidden" class="form-control" name="id"
                       value="{{$widget_vk->id}}">
                <input type="hidden" class="form-control" name="form_action"
                       value="formintegrationfb">
           {!! $status_checkbox_metrika !!}
                
                </div>
                
            </div>

      <div class="show-hidden-integration">  
    <div class="col-md-12">







           {{-- <div class="form-group row">
                <label class="col-lg-3 control-label">Verify Token :</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="apikey" id="apikey"  value="{{$widget_vk->apikey}}"  required>

                </div>

            </div>--}}

          {{--  <div class="form-group row">
                <label class="col-lg-3 control-label">WebHook адрес :</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="xxxx" id="xxxx"  value="https://cloud.neiros.ru/api/fbapi/callback_handleEvent/{{$sites->hash}}"  required>

                </div>

            </div>--}}


            <div class="form-group row" style="margin-top: 10px">
                <div class="col-md-9">
                    {!! $fb_url !!}
                </div>

            </div>
                @if(count($fb_pages)>0)
                    <div class="form-group row">
                        <label class="col-lg-3 control-label">Приветственное сообщение:</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="start_message" id="start_message"  value="{{$widget_vk->start_message}}"  required>

                        </div>

                    </div>
                    <div class="row">Выберите страницы для подключения к чат боту</div>
                    @foreach($fb_pages as $item)
                        <div class="form-group row">
                            <input type="checkbox">{{$item->name}}

                        </div>

                    @endforeach
                    <button type="button" class="btn btn-success">Сохранить</button>
                @endif

            </form>







        {{--Дополнительные поля--}}

    </div>
    
    </div>

</div>
    <!-- Футер модального окна -->
</div>

</div>
</div>
</div>




