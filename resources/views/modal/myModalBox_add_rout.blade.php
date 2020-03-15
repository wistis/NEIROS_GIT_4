<div id="myModalBox_add_rout" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Заголовок модального окна -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Сценарии</h4>
            </div>
            <!-- Основное содержимое модального окна -->

            <div class="panel-group" id="accordion">
                <!-- 1 панель -->
                <div class="panel panel-default">
                    <!-- Заголовок 1 панели -->
                    <div class="panel-heading">
                        <h5 class="panel-title">
                            <b>1. Название сценария:</b>
                        </h5>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in">
                        <!-- Содержимое 1 панели -->
                        <div class="panel-body">
                            <div class="form-group">

                                <div class="col-lg-12">
                                    <div class=" ">
                                        <input type="hidden" value="0" id="ar_id" class="form-control"
                                               placeholder="">
                                        <input type="text" value="" id="ar_name" class="form-control"
                                               placeholder="Введите названи сценария">
                                        <input type="text" value="" id="ar_class_replace" class="form-control"
                                               placeholder="Class или ID:">
                                        <input type="text" value="" id="ar_phone_replace" class="form-control"
                                               placeholder="Телефон замены:">
                                        <input type="checkbox"  name="is_default" id="is_default" value="1" autocomplete="off">Основной сценарий

                                    </div>
                                    <div class="row mt-10">
                                        <div class="col-md-10">
                                        </div>
                                        <div class="col-md-2"><input type="button" class="btn btn-success btn1"
                                                                     value="Далее"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- 2 панель -->
                    <div class="panel panel-default">
                        <!-- Заголовок 2 панели -->
                        <div class="panel-heading">
                            <h5 class="panel-title">
                                <b>2. Выберите номера</b>

                            </h5>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse">
                            <!-- Содержимое 2 панели -->
                            <div class="panel-body">
                                <div class="form-group">

                                    <div class="col-lg-9">
                                        <div class=" ">
                                            <label id="fee_numbers_list">

                                            </label>
                                        </div>
                                    </div>

                                    <div class="row mt-10">
                                        <div class="col-md-8">
                                        </div>
                                        <div class="col-md-2"><input type="button" class="btn btn-danger btn-1"
                                                                     value="Назад">
                                        </div>
                                        <div class="col-md-2"><input type="button" class="btn btn-success btn2"
                                                                     value="Далее"></div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- 3 панель -->
                    <div class="panel panel-default">
                        <!-- Заголовок 3 панели -->
                        <div class="panel-heading">
                            <h5 class="panel-title">
                                <b>3. Переадресация</b>
                            </h5>
                        </div>
                        <div id="collapseThree" class="panel-collapse collapse">
                            <!-- Содержимое 3 панели -->
                            <div class="panel-body">
                                <div class="col-md-6">
                                    <p>Тип переадресации</p>
                                    <div><input type="radio" name="ar_reditrect" class="ar_reditrect" value="0" checked
                                                onclick="select_tip_redirect(0)"> Телефонный номер
                                    </div>
                                    <div><input type="radio" name="ar_reditrect" class="ar_reditrect" value="1"
                                                onclick="select_tip_redirect(1)"> Учетная запись SIP
                                    </div>
                                    <div><input type="radio" name="ar_reditrect" class="ar_reditrect" value="2"
                                                onclick="select_tip_redirect(2)"> Наша сип
                                    </div>
@if($roistat==1)
                                        <div><input type="radio" name="ar_reditrect" class="ar_reditrect" value="3"
                                                    onclick="select_tip_redirect(3)"> Roistat
                                        </div>

@endif

                                </div>
                                <div class="col-md-6">
                                    <p>Номер</p>
                                    <div id="block_0"><p>Номер телефона</p><input type="text" value="" id="ar_phone_redirect0"
                                                                class="form-control" placeholder="74993435366"></div>
                                    <div id="block_1" style="display: none">
                                        <div>Звонки по SIP бесплатны.</div>
                                        <input type="text" value="" id="ar_phone_redirect1" class="form-control"
                                               placeholder="office@mydomain.ru"></div>
                                    <div id="block_2" style="display: none"><p>Оплата за минуты не взимается.
                                            По указанным ниже параметрам можно подключить soft phone или вашу АТС.
                                            Звонки
                                            будут переводиться на подключенное устройство.</p>
                                        <div>Адрес: IP ADRES<br>
                                            Пользователь: 5{{$user->my_company_id}}{{$widget->id}}</div>

                                        <input type="text" value="" id="ar_phone_redirect2" class="form-control"
                                               placeholder="Придумайте пароль"></div>

                                </div>
                                <div class="row mt-10">
                                    <div class="col-md-8">
                                    </div>
                                    <div class="col-md-2"><input type="button" class="btn btn-danger btn-2"
                                                                 value="Назад">
                                    </div>
                                    <div class="col-md-2"><input type="button" class="btn btn-success btn3"
                                                                 value="Далее"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <!-- Заголовок 4 панели -->
                        <div class="panel-heading">
                            <h5 class="panel-title">
                                <b  >4. Тип
                                    колтрекинга</b>
                            </h5>
                        </div>
                        <div id="collapseFour" class="panel-collapse collapse">
                            <!-- Содержимое 4 панели -->
                            <div class="panel-body">
                                <div class="col-md-6">
                                    <p>Тип переадресации</p>
                                    <div><input type="radio" name="ar_tip_calltrack" class="ar_tip_calltrack" value="1"
                                                selected  onclick="selecttipcall(1)"  >Динамический
                                    </div>
                                    <div><input type="radio" name="ar_tip_calltrack" class="ar_tip_calltrack" value="2"  onclick="selecttipcall(2)">Статический
                                    </div>

                                </div>
                                <div class="col-md-6 mymetki_dinamic" style="">

                                    <select id="ar_canals_dinamic" multiple>

                                        @foreach($witget_canals as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                    {{--<p>UTM-Метки</p>
                                    <div>
                                        <input type="text" placeholder="utm_campaign" name="utm_campaign"  id="utm_campaign" >
                                    </div>
                                    <div>
                                        <input type="text" placeholder="utm_content" name="utm_content"  id="utm_content"  >
                                    </div>
                                    <div>
                                        <input type="text" placeholder="utm_medium" name="utm_medium"  id="utm_medium"  >
                                    </div>
                                    <div>
                                        <input type="text" placeholder="utm_source" name="utm_source"  id="utm_source"  >
                                    </div>
                                    <div>
                                        <input type="text" placeholder="utm_term" name="utm_term"  id="utm_term"  >
                                    </div>
                                    <div>
                                        <input type="text" placeholder="URL" name="static_url"  id="static_url"  >
                                    </div>
--}}

                                </div>
                                <div class="col-md-6 mymetki" style="display:none;">

<select id="ar_canals">
    <option value="0">Выберите канал</option>

                                    @foreach($witget_canals as $item)
        <option value="{{$item->id}}">{{$item->name}}</option>
@endforeach
</select>
                                    {{--<p>UTM-Метки</p>
                                    <div>
                                        <input type="text" placeholder="utm_campaign" name="utm_campaign"  id="utm_campaign" >
                                    </div>
                                    <div>
                                        <input type="text" placeholder="utm_content" name="utm_content"  id="utm_content"  >
                                    </div>
                                    <div>
                                        <input type="text" placeholder="utm_medium" name="utm_medium"  id="utm_medium"  >
                                    </div>
                                    <div>
                                        <input type="text" placeholder="utm_source" name="utm_source"  id="utm_source"  >
                                    </div>
                                    <div>
                                        <input type="text" placeholder="utm_term" name="utm_term"  id="utm_term"  >
                                    </div>
                                    <div>
                                        <input type="text" placeholder="URL" name="static_url"  id="static_url"  >
                                    </div>
--}}

                                </div>
                                <div class="row mt-10">
                                    <div class="col-md-8">
                                    </div>
                                    <div class="col-md-2"><input type="button" class="btn btn-danger btn-3"
                                                                 value="Назад">
                                    </div>
                                    <div class="col-md-2"> <button type="button" class="btn btn-primary" onclick="myModalBox_add_rout_safe()">Создать
                                        </button></div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

{{--
?cmp: "utm_campaign"
​​
cnt: "utm_content"
​​
mdm: "utm_medium"
​​
src: "utm_source"
​​
trm: "utm_term"--}}
                <!-- Основное содержимое модального окна -->


                <!-- Футер модального окна -->
                <div class="modal-footer">


                </div>
            </div>
        </div>
    </div>
    </div>

<script>
    $("#ar_phone_redirect0").inputmask("+7 (999) 999-99-99", {"placeholder": "+7 (___) ___-__-__"});
</script>
 