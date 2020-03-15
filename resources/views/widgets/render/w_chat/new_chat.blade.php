<div class="panel panel-default new-panel-default">


    <div class="panel-heading" role="tab" id="heading__1">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse__1" aria-expanded="false" aria-controls="collapse__1">
            <div class="number-accardion"><img src="/global_assets/images/icon/settings.svg"></div>
            <div class="h-1">Правила показа операторов</div>
            <div class="descr-text">Какое-то краткое краткое описание</div>
        </a>
    </div>


    <div id="collapse__1" class="panel-collapse collapse" role="tabpane1" aria-labelledby="heading__1" aria-expanded="false" style="height: 0px;">




        <div class="panel-body" style="padding-top:0px">
            <form name="chat_form_operator_url"  >
                <input type="hidden" name="form_action" value="chat_form_operator_url">
                <input type="hidden" name="widget" value="{{$widget->id}}">
                <input type="hidden" name="my_company_id" value="{{$widget->my_company_id}}">
            <div class="cont-btn-content col-xs-12" style="padding-top: 0px;">
                <div class="tab-content-block active">
                    <div class="col-xs-12 block__esli">
                        <div class="block__esli_1"><span>Если</span></div>
                        <div class="block__esli_text">клиент посещает страницу, адрес которой не имеет правила</div>
                    </div>

                    <div class="col-xs-12 block__esli">
                        <div class="block__esli_1"><span>То</span></div>
                        <div class="block__esli_text">маршрутизация чатов для всех операторов</div>


                    </div>

                    <div class="show-chat-operator-all">
                       @foreach($operator_urls as $operator_url)

                        <div class="show-chat-operator col-xs-12">
                            <div class=" operator-select-block">
                                <div class="dropdown operator-select add-user-new add-number-new select-panel-blok-input">
                                    <button  class="btn btn-success" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Выберите оператора</button>
                                    <ul class="dropdown-menu"  aria-labelledby="dLabel">
                                       @foreach($operators as $operator)

                                            <li  @if($operator_url->operator_id==$operator->id) class="active" @endif><label class="add-number-new-checkbox">{{$operator->name}}<input   type="checkbox" name="operator[{{$operator_url->id}}]" value="{{$operator->id}}" @if($operator_url->operator_id==$operator->id) checked @endif><span class="checkmark"></span></label></li>@endforeach



                                    </ul>
                                </div>
                            </div>

                            <div class=" operator-select-block">
                                <div class="dropdown operator-select add-user-new add-number-new select-panel-blok-input">
                                    <button  class="btn btn-success" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Выберите условие</button>
                                    <ul class="dropdown-menu"  aria-labelledby="dLabel">
                                        <li  @if($operator_url->condition=='%LIKE%') class="active" @endif><label class="add-number-new-checkbox">содержит строку<input type="checkbox" name="condition[{{$operator_url->id}}]" value="%LIKE%" @if($operator_url->condition=='%LIKE%') checked @endif><span class="checkmark"></span></label></li>
                                        <li @if($operator_url->condition=='NOT%LIKE%')  class="active" @endif ><label class="add-number-new-checkbox">не содержит строку<input   type="checkbox"  name="condition[{{$operator_url->id}}]"  value="NOT%LIKE%" @if($operator_url->condition=='NOT%LIKE%') checked @endif><span class="checkmark"></span></label></li>
                                        <li @if($operator_url->condition=='==') class="active" @endif ><label class="add-number-new-checkbox">это точно<input  type="checkbox"  name="condition[{{$operator_url->id}}]"  value="==" @if($operator_url->condition=='==') checked @endif><span class="checkmark"></span></label></li>
                                        <li @if($operator_url->condition=='!=') class="active" @endif><label class="add-number-new-checkbox">не являеться<input value="!=" @if($operator_url->condition=='!=') checked @endif type="checkbox" name="condition[{{$operator_url->id}}]" ><span class="checkmark"></span></label></li>

                                    </ul>
                                </div>
                            </div>


                            <div class="form__block " >

                                <input type="text" class="form-control form-control-text" placeholder="" name="str[{{$operator_url->id}}]" value="{{$operator_url->str}}">
                            </div>

                            <div class="delete_pravilo2"><img src="/global_assets/images/icon/user/trash.svg"></div>

                        </div>

                        @endforeach
                    </div>

                    <div class="col-xs-12 add_sourse_block">
                        <div class="add_sourse add_time_call" id="add_pravilo_operator" >
                            <div class="cont__left">+</div>
                            <div class="cont_right">Добавить правило</div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="banel-body-footer">
                <button type="button" class="btn btn-primary save-setings  w_safebutton ">Сохранить</button>
            </div>

            </form>
        </div>
    </div>

</div>
<div class="panel panel-default new-panel-default">


    <div class="panel-heading" role="tab" id="heading-2">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-2" aria-expanded="false" aria-controls="collapse-2">
            <div class="number-accardion"><img src="/global_assets/images/icon/talk.svg"></div>
            <div class="h-1">Приветственное сообщение</div>
            <div class="descr-text">Какое-то краткое краткое описание</div>
        </a>
    </div>


    <div id="collapse-2" class="panel-collapse collapse" role="tabpane1" aria-labelledby="heading-2" aria-expanded="false" style="height: 0px;">


        <div class="panel-body" style="padding-top:0px">

            <div class="cont-btn-content col-xs-12" style="padding-top: 0px;">
                <div class="tab-content-block active">


                    <div class="all_time_block">
                    </div>
                    <div id="sortable-panel-otobragenie">
                       @foreach($mess_rules as $mess_rule)

                        <div class="panel-otobragenie col-xs-12">
                            <form name="chat_form_operator_url"  >
                                <input type="hidden" name="form_action" value="chat_mess_rules">
                                <input type="hidden" name="widget" value="{{$widget->id}}">
                                <input type="hidden" name="my_company_id" value="{{$widget->my_company_id}}">


                                <div class="panel-header">
                                    <div class="block-header block-header-1"><img src="/global_assets/images/icon_chat/menu_gray.svg"></div>
                                    <div class="block-header block-header-2"><img src="/images/icon/chat/2.png"> <span class="text__header">Правила отображения</span><span class="switchery-xs-new"><input  type="checkbox" class="js-switch" data-id="" value="1" name="status[{{$mess_rule->id}}]" @if($mess_rule->status==1) checked @endif></span></div>
                                    <div class="block-header block-header-3 active"><img src="/images/icon/chat/3.png"></div>
                                    <div class="block-header block-header-4"><img src="/global_assets/images/icon_chat/file_gray.svg"></div>
                                    <div class="block-header block-header-5 no-delete"><img src="/global_assets/images/icon/user/trash.svg"></div>


                                </div>

                                <div class="panel-body-panel col-xs-12" style="display: block;">
                                    <div class="text-panel-blok">
                                        <label>Текст сообщения</label>
                                        <textarea class="" name="message[{{$mess_rule->id}}]">{{$mess_rule->message}}</textarea>
                                    </div>

                                    <div class="text-h1-fo-select-panel">Отображение приветствия, когда</div>

                                    <div class="pravilo-container">
@foreach($mess_rule->rules as $rules)
                                        <div class="pravilo-block col-xs-12">
                                            <div  class="select-panel-blok col-sm-5" >

                                                <div class="dropdown add-user-new add-number-new select-panel-blok-input">
                                                    <button  class="btn btn-success" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Выбрать правило</button>
                                                    <ul class="dropdown-menu"  aria-labelledby="dLabel">
                                                        <li class="t__1  @if($rules->condition=='time-page') active @endif"><label class="add-number-new-checkbox">Время на текущей странице<input value="time-page" type="checkbox"  name="condition[{{$rules->id}}]"  @if($rules->condition=='time-page') checked @endif ><span class="checkmark"></span></label></li>
                                                        <li class="t__2    @if($rules->condition=='time-site') active @endif"><label class="add-number-new-checkbox">Время на сайте<input value="time-site"  @if($rules->condition=='time-site') checked @endif type="checkbox" name="condition[{{$rules->id}}]"  ><span class="checkmark"></span></label></li>
                                                        <li class="t__3  @if($rules->condition=='url-page') active @endif"><label class="add-number-new-checkbox">Адрес текущей страницы<input value="url-page"  @if($rules->condition=='url-page') checked @endif type="checkbox" name="condition[{{$rules->id}}]"  ><span class="checkmark"></span></label></li>
                                                        <li class="t__4  @if($rules->condition=='return-user') active @endif"><label class="add-number-new-checkbox">Повторный пользователь<input value="return-user" type="checkbox" name="condition[{{$rules->id}}]" @if($rules->condition=='return-user') checked @endif  ><span class="checkmark"></span></label></li>
                                                    </ul>
                                                </div>



                                            </div>




                                            <div class="col-sm-7 zvonok-block two-panel-result-show select-panel-blok-time time-page"  style="
                                            @if(in_array($rules->condition,['time-page','time-site']))   display:block; @else   display:none @endif

                                          " >
                                                <div class="form__block " style="width:auto">
                                                    <div class="text-form-block">больше</div>
                                                </div>
                                                <div class="form__block " style="width:65px">

                                                    <input type="text" class="form-control form-control-text" placeholder="00" name="time[{{$rules->id}}]" value="{{$rules->time}}">
                                                </div>

                                                <div class="form__block " style="width:auto">
                                                    <div class="text-form-block">сек</div>
                                                </div>
                                            </div>

                                            <div class="col-sm-7 zvonok-block two-panel-result-show select-panel-blok-time url-page"  style="
                                            @if($rules->condition=='url-page') display:block;  @else display:none;  @endif
                                            ">
                                                <div class="dropdown add-user-new add-number-new select-panel-blok-input">
                                                    <button  class="btn btn-success" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">содержит строку</button>
                                                    <ul class="dropdown-menu"  aria-labelledby="dLabel">
                                                        <li @if($rules->rules_condition=='%LIKE%') class="active" @endif><label class="add-number-new-checkbox">содержит строку<input type="checkbox" name="rules_condition[{{$rules->id}}]" value="%LIKE%" @if($rules->rules_condition=='%LIKE%') checked @endif><span class="checkmark"></span></label></li>
                                                        <li @if($rules->rules_condition=='NOT%LIKE%') class="active" @endif><label class="add-number-new-checkbox">не содержит строку<input   type="checkbox"  name="rules_condition[{{$rules->id}}]"  value="NOT%LIKE%" @if($rules->rules_condition=='NOT%LIKE%') checked @endif><span class="checkmark"></span></label></li>
                                                        <li @if($rules->rules_condition=='==') class="active" @endif><label class="add-number-new-checkbox">это точно<input  type="checkbox"  name="rules_condition[{{$rules->id}}]"  value="==" @if($rules->rules_condition=='==') checked @endif><span class="checkmark"></span></label></li>
                                                        <li @if($rules->rules_condition=='!=') class="active" @endif><label class="add-number-new-checkbox">не являеться<input value="!=" @if($rules->rules_condition=='!=') checked @endif type="checkbox" name="rules_condition[{{$rules->id}}]" ><span class="checkmark"></span></label></li>

                                                    </ul>
                                                </div>

                                                <div class="form__block " >

                                                    <input type="text" class="form-control form-control-text" placeholder="" name="rules_condition_str[{{$rules->id}}]" value="{{$rules->rules_condition_str}}">
                                                </div>



                                            </div>



                                            <div class="delete_pravilo"><img src="/global_assets/images/icon/user/trash.svg"></div>
                                        </div>
@endforeach
                                    </div>
                                    <div class="col-xs-12 add_sourse_block">
                                        <div class="add_sourse add_time_call" id="add_pravilo">
                                            <div class="cont__left">+</div>
                                            <div class="cont_right">Добавить правило</div>
                                        </div>
                                    </div>

                                    <div class="banel-body-footer">
                                        <button type="button" class="btn btn-primary save-setings2   w_safebutton">Сохранить</button>
                                    </div>
                                </div>
                            </form>
                        </div>
@endforeach





                    </div>


                    <div class="col-xs-12 add_sourse_block add_sourse_block__chat" style=" display:block;">
                        <div class="add_sourse add_time_call">
                            <div class="cont__left">+</div>
                            <div class="cont_right">ДОБАВИТЬ СООБЩЕНИЕ</div>
                        </div>
                    </div>

                </div>


            </div>



        </div>




    </div>

</div>


<div class="panel panel-default new-panel-default">


    <div class="panel-heading" role="tab" id="heading__3">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse__3" aria-expanded="false" aria-controls="collapse__3">
            <div class="number-accardion"><img src="/global_assets/images/icon/settings_2.svg"></div>
            <div class="h-1">Маршрутизация чатов</div>
            <div class="descr-text">Какое-то краткое краткое описание</div>
        </a>
    </div>


    <div id="collapse__3" class="panel-collapse collapse" role="tabpane1" aria-labelledby="heading__3" aria-expanded="false" style="height: 0px;">


        <div class="panel-body" style="padding-top:0px">
            <div class="cont-btn-content col-xs-12" style="padding-top: 0px;">
                <div class="tab-content-block active">
                    <div class="col-xs-12 block__esli">
                        <div class="block__esli_1"><span>Если</span></div>
                        <div class="block__esli_2_select" >
                            <div class="dropdown ">
                                <button  class="btn btn-success" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><div class="add_sourse " ><div class="cont__left">+</div><div class="cont_right">Добавить данные</div></div></button>
                                <ul class="dropdown-menu"  aria-labelledby="dLabel">
                                    <li ><label class="add-number-new-checkbox">Время на сайте<input value="time-page" type="checkbox" ><span class="checkmark"></span></label></li>
                                    <li ><label class="add-number-new-checkbox">Время на странице<input value="time-site" type="checkbox" ><span class="checkmark"></span></label></li>
                                    <li ><label class="add-number-new-checkbox">Посетил страницу<input value="url-page" type="checkbox" ><span class="checkmark"></span></label></li>
                                    <li ><label class="add-number-new-checkbox">Повторный пользователь<input value="return-user" type="checkbox" ><span class="checkmark"></span></label></li>
                                </ul>
                            </div>





                        </div>

                        <div class="block__esli_3" style="display:none;">Время на сайте</div>
                    </div>

                    <div class="col-xs-12 block__esli">
                        <div class="block__esli_1"><span>То</span></div>
                        <div class="block__esli_2_select" >
                            <div class="dropdown ">
                                <button  class="btn btn-success" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><div class="add_sourse " ><div class="cont__left">+</div><div class="cont_right">Добавить данные</div></div></button>
                                <ul class="dropdown-menu"  aria-labelledby="dLabel">
                                    <li ><label class="add-number-new-checkbox">Чат<input value="time-page" type="checkbox" ><span class="checkmark"></span></label></li>
                                    <li ><label class="add-number-new-checkbox">Колбек<input value="time-site" type="checkbox" ><span class="checkmark"></span></label></li>

                                </ul>
                            </div>





                        </div>

                        <div class="block__esli_3" style="display:none;">Время на сайте</div>
                    </div>

                </div>
            </div>
            <div class="banel-body-footer">
                <button type="button" class="btn btn-primary save-setings   w_safebutton">Сохранить</button>
            </div>

        </div>




    </div>
</div>




<script>

    function getRandomInt(max) {
        return Math.floor(Math.random() * Math.floor(max));
    }


    $(document).on('click','#add_pravilo_operator',function(){
        var is_random=getRandomInt(99999990);
        $('.show-chat-operator-all').append(`<div class="show-chat-operator col-xs-12">
                <div class=" operator-select-block">
                    <div class="dropdown operator-select add-user-new add-number-new select-panel-blok-input">
            <button  class="btn btn-success" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Выберите оператора</button>
             <ul class="dropdown-menu"  aria-labelledby="dLabel">
                @foreach($operators as $operator) <li ><label class="add-number-new-checkbox">{{$operator->name}}<input value="{{$operator->id}}" type="checkbox" name="operator[n`+is_random+`]"><span class="checkmark"></span></label></li>@endforeach



             </ul>
    </div>
                </div>

                <div class=" operator-select-block">
                    <div class="dropdown operator-select add-user-new add-number-new select-panel-blok-input">
            <button  class="btn btn-success" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Выберите условие</button>
            <ul class="dropdown-menu"  aria-labelledby="dLabel">
                                        <li ><label class="add-number-new-checkbox">содержит строку<input type="checkbox" name="condition[n`+is_random+`]" value="%LIKE%"  ><span class="checkmark"></span></label></li>
                                        <li ><label class="add-number-new-checkbox">не содержит строку<input   type="checkbox"  name="condition[n`+is_random+`]"  value="NOT%LIKE%" ><span class="checkmark"></span></label></li>
                                        <li ><label class="add-number-new-checkbox">это точно<input  type="checkbox"  name="condition[n`+is_random+`]"  value="=="  ><span class="checkmark"></span></label></li>
                                        <li ><label class="add-number-new-checkbox">не являеться<input value="!="   type="checkbox" name="condition[n`+is_random+`]" ><span class="checkmark"></span></label></li>

                                    </ul>
    </div>
                </div>


                    <div class="form__block " >

                            <input type="text" class="form-control form-control-text" placeholder="" name="str[n`+is_random+`]" value="">
                        </div>
						 <div class="delete_pravilo2"><img src="/global_assets/images/icon/user/trash.svg"></div>
                </div>`);



    })



/*правили внутри приветственного сообщенния*/
    $(document).on('click','#add_pravilo',function(){

        var is_random=getRandomInt(99999990);
		$(this).closest('.panel-body-panel').find('.pravilo-container').append(`<div class="pravilo-block col-xs-12">
                        <div  class="select-panel-blok col-sm-5" >

    <div class="dropdown add-user-new add-number-new select-panel-blok-input">
            <button  class="btn btn-success" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Выбрать правило</button>
             <ul class="dropdown-menu"  aria-labelledby="dLabel">
                 <li class="t__1"><label class="add-number-new-checkbox">Время на текущей странице<input value="time-page" type="checkbox"  name="condition[n`+is_random+`]" ><span class="checkmark"></span></label></li>
                 <li class="t__2"><label class="add-number-new-checkbox">Время на сайте<input value="time-site" type="checkbox" name="condition[n`+is_random+`]" ><span class="checkmark"></span></label></li>
                 <li class="t__3"><label class="add-number-new-checkbox">Адрес текущей страницы<input value="url-page" type="checkbox" name="condition[n`+is_random+`]" ><span class="checkmark"></span></label></li>
           <li class="t__4"><label class="add-number-new-checkbox">Повторный пользователь<input value="return-user" type="checkbox"  name="condition[n`+is_random+`]"><span class="checkmark"></span></label></li>
             </ul>
    </div>



                    </div>




                    <div class="col-sm-7 zvonok-block two-panel-result-show select-panel-blok-time time-page"  style="display:none" >
                            <div class="form__block " style="width:auto">
                                <div class="text-form-block">больше</div>
                            </div>
                            <div class="form__block " style="width:65px">

                                <input type="text" class="form-control form-control-text" placeholder="00" name="time[n`+is_random+`]">
                            </div>

                            <div class="form__block " style="width:auto">
                                <div class="text-form-block">сек</div>
                            </div>
                        </div>

                      <div class="col-sm-7 zvonok-block two-panel-result-show select-panel-blok-time url-page"  style="display:none">
    <div class="dropdown add-user-new add-number-new select-panel-blok-input">
            <button  class="btn btn-success" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">содержит строку</button>
             <ul class="dropdown-menu"  aria-labelledby="dLabel">
                 <li ><label class="add-number-new-checkbox">содержит строку<input value="%LIKE%" type="checkbox" name="rules_condition[n`+is_random+`]" ><span class="checkmark"></span></label></li>
                 <li ><label class="add-number-new-checkbox">не содержит строку<input value="NOT%LIKE%" type="checkbox" name="rules_condition[n`+is_random+`]"><span class="checkmark"></span></label></li>
                 <li ><label class="add-number-new-checkbox">это точно<input value="==" type="checkbox" name="rules_condition[n`+is_random+`]"><span class="checkmark"></span></label></li>
           <li ><label class="add-number-new-checkbox">не являеться<input value="!=" type="checkbox" name="rules_condition[n`+is_random+`]" ><span class="checkmark"></span></label></li>
             </ul>
    </div>

    <div class="form__block " >

                            <input type="text" class="form-control form-control-text" placeholder="" name="rules_condition_str[n`+is_random+`]" value="">
                        </div>



                        </div>


                     <div class="delete_pravilo"><img src="/global_assets/images/icon/user/trash.svg"></div>

               </div>`);



    })
/*приветственное сообщение*/
    $(document).on('click','.add_sourse_block__chat',function(){
        Rand =	Date.now()

        var is_random_first=getRandomInt(99999990);

        $('#sortable-panel-otobragenie').append(`<div class="panel-otobragenie col-xs-12">
    <form name="chat_form_operator_url"  >
        <input type="hidden" name="form_action" value="chat_mess_rules">
        <input type="hidden" name="widget" value="{{$widget->id}}">
        <input type="hidden" name="my_company_id" value="{{$widget->my_company_id}}">
        <div class="panel-header">
            <div class="block-header block-header-1"><img src="/global_assets/images/icon_chat/menu_gray.svg"></div>
            <div class="block-header block-header-2"><img src="/images/icon/chat/2.png"> <span class="text__header">Правила отображения</span><span class="switchery-xs-new"><input checked type="checkbox" value="1" name="status[n`+is_random_first+`]" class="`+'js-switch'+Rand+`" data-id=""></span></div>
            <div class="block-header block-header-3"><img src="/images/icon/chat/3.png"></div>
            <div class="block-header block-header-4"><img src="/global_assets/images/icon_chat/file_gray.svg"></div>
            <div class="block-header block-header-5"><img src="/global_assets/images/icon/user/trash.svg"></div>


        </div>

        <div class="panel-body-panel col-xs-12" style="display: none;">
            <div class="text-panel-blok">
                <label>Текст сообщения</label>
                <textarea class=""  name="message[n`+is_random_first+`]" >Здравствуйте! Чем могу помочь?</textarea>
            </div>

            <div class="text-h1-fo-select-panel">Отображение приветствия, когда</div>
 <div class="pravilo-container"></div>

            <div class="col-xs-12 add_sourse_block">
                <div class="add_sourse add_time_call" id="add_pravilo">
                    <div class="cont__left">+</div>
                    <div class="cont_right">Добавить правило</div>
                </div>
            </div>

            <div class="banel-body-footer">
                <button type="button" class="btn btn-primary save-setings2 w_safebutton  ">Сохранить</button>
            </div>
        </div>
    </form>
</div>`)

        var elems = document.querySelectorAll('.js-switch'+Rand+'');

        for (var i = 0; i < elems.length; i++) {
            var switchery = new Switchery(elems[i], { size: 'small' , color: '#00B9EE'});
        }
    })

</script>