<div class="col-md-3 integration-item">
    <div class="single-cases-card" >
        <div class="card-image"><a data-toggle="modal" data-target="#myModal_sett_11"><img alt="" src="/global_assets/images/integration/bitrix24.jpg" draggable="false" class="img-responsive" ></a>
            <div class="hover-area"> </div>
        </div>
        <!-- .card-image END -->

        <div class="cases-content col-xs-12">

            <span class="col-xs-12 text-center" > {!! $status_checkbox_metrika_modal !!}</span>
             </div>
        <!-- .cases-content END --></div>


</div>

<div id="myModal_sett_11" class="modal fade ClientInfoModal lids-neiros integration___modal WidgetModal">
    <div class="modal-dialog">
        <div class="modal-content"   style="height: 100vh">
            <!-- Заголовок модального окна -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
               
            </div>
            <!-- Основное содержимое модального окна -->
            <div class="modal-body">
            <div class="name-block-fixed name-block-fixed-integration">
           <div class="col-xs-12" >
           <div class="h1-modal pos-left"><img src="/images/bitrix24-integration.jpg"><span></span></div>
           
         <input type="hidden" class="form-control" name="id"
                       value="{{$widgets_bitrix24->id}}">
                <input type="hidden" class="form-control" name="form_action"
                       value="safebitrix24">
                    {!! $status_checkbox_metrika !!}   
           </div>
            </div>
            
            
            
    <div class="row">
        @if(isset($_GET['tip']))

            @if( $_GET['tip']=='b24')


                @if( $_GET['status']==0)
                    <span style="color: red">{{$_GET['mess']}}</span>

                @endif
                @if( $_GET['status']==1)
                        <span style="color: green">{{$_GET['mess']}}</span>
                @endif
            @endif
        @endif
        <form id="safebitrix24" name="safebitrix24">  
        <div class="col-xs-12 block-descr">  
          <div class="col-sm-6"><div class="img-block-left"><img width="100%" src="/global_assets/images/integration/bitrix24.jpg"></div></div>
          <div class="col-sm-6">  
          	<div class="paragraph">Битрикс24 –  это приложение, помогающее организовать коллективную работу в компании. Говоря проще, это сайт на котором собраны все необходимые данные о сотрудниках и клиентах компании. С помощью него вы можете выставлять и выполнять задачи, планировать рабочее время и общаться с коллегами так же легко, как вы это делаете в социальной сети.</div>
          
         <input type="hidden" class="form-control" name="id"
                       value="{{$widgets_bitrix24->id}}">
                <input type="hidden" class="form-control" name="form_action"
                       value="safebitrix24">
                    {!! $status_checkbox_metrika !!}   
                
                </div>
                
            </div>	
            
            
      <div class="show-hidden-integration">       
        <div class="col-xs-12">

        
                       
         



                    <div class="form-group">
                        <label class="col-lg-3 control-label">Адрес bitrix24:</label>
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
                        <label class="col-lg-3 control-label">Пароль:</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="password" id="password"
                                   value="{{$widgets_bitrix24->password}}" required>

                        </div>

                    </div>
                     <div class="form-group">
                        <label class="col-lg-3 control-label">Код приложения:</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="APP_ID" id="APP_ID"
                                   value="{{$widgets_bitrix24->APP_ID}}" required>

                        </div>

                    </div>


                    <div class="form-group">
                        <label class="col-lg-3 control-label">Ключ приложения:</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="APP_SECRET_CODE" id="APP_SECRET_CODE"
                                   value="{{$widgets_bitrix24->APP_SECRET_CODE}}" required>

                        </div>

                    </div>

             
            </div>
            <div class="  col-xs-12 statusb24" style="background: white;margin-bottom: 50px;overflow-y: auto;height: 250px;">






            </div>
            {{--Дополнительные поля--}}

        <div class="form-group footer-button">
            <div class="col-xs-12">
            	<button type="button"  class="btn btn-primary  bsafe">Сохранить</button>
       
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
<script>
    $('.bsafe').click(function () {
        var form = $(this).closest('form');
        var formdata = $(form).serialize();


        $.ajax({
            type: "POST",
            url: '/widget/safe',
            data: formdata,
            success: function (html1) {

                $url = 'https://' +$('#server1').val()+ '/oauth/authorize/?client_id='+$('#APP_ID').val();
                window.location.href=$url;

            }
        })

    });
    get_data_to_amo( );
    function get_data_to_amo( ) {


        $.ajax({
            type: "POST",
            url: '/widget/get_b24_data',
            data: "",
            success: function (html1) {

                $('.statusb24').html(html1);
            }
        })
    }
</script>
