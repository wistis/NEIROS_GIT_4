<div class="panel-otobragenie col-xs-12">
    <form name="chat_form_operator_url"  >
        <input type="hidden" name="form_action" value="chat_mess_rules">
        <input type="hidden" name="widget" value="{{$widget->id}}">
        <input type="hidden" name="my_company_id" value="{{$widget->my_company_id}}">
        <div class="panel-header">
            <div class="block-header block-header-1"><img src="/global_assets/images/icon_chat/menu_gray.svg"></div>
            <div class="block-header block-header-2"><img src="/images/icon/chat/2.png"> <span class="text__header">Правила отображения</span><span class="switchery-xs-new"><input checked type="checkbox" name="status[n`+is_random_first+`]" class="`+'js-switch'+Rand+`" data-id=""></span></div>
            <div class="block-header block-header-3"><img src="/images/icon/chat/3.png"></div>
            <div class="block-header block-header-4"><img src="/global_assets/images/icon_chat/file_gray.svg"></div>
            <div class="block-header block-header-5"><img src="/global_assets/images/icon/user/trash.svg"></div>


        </div>

        <div class="panel-body-panel col-xs-12" style="display: none;">
            <div class="text-panel-blok">
                <label>Текст сообщения</label>
                <textarea class=""  name="message[n`+is_random_first+`]" ></textarea>
            </div>

            <div class="text-h1-fo-select-panel">Отображение приветствия, когда</div>

            <div class="pravilo-container">

                <div class="pravilo-block col-xs-12">
                    <div  class="select-panel-blok col-sm-5" >

                        <div class="dropdown add-user-new add-number-new select-panel-blok-input">
                            <button  class="btn btn-success" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Выбрать правило</button>
                            <ul class="dropdown-menu"  aria-labelledby="dLabel">
                                <li class="t__1"><label class="add-number-new-checkbox">Время на текущей странице<input value="time-page" type="checkbox" ><span class="checkmark"></span></label></li>
                                <li class="t__2"><label class="add-number-new-checkbox">Время на сайте<input value="time-site" type="checkbox" ><span class="checkmark"></span></label></li>
                                <li class="t__3"><label class="add-number-new-checkbox">Адрес текущей страницы<input value="url-page" type="checkbox" ><span class="checkmark"></span></label></li>
                                <li class="t__4"><label class="add-number-new-checkbox">Повторный пользователь<input value="return-user" type="checkbox" ><span class="checkmark"></span></label></li>
                            </ul>
                        </div>



                    </div>




                    <div class="col-sm-7 zvonok-block two-panel-result-show select-panel-blok-time time-page"  style="display:none" >
                        <div class="form__block " style="width:auto">
                            <div class="text-form-block">больше</div>
                        </div>
                        <div class="form__block " style="width:65px">

                            <input type="text" class="form-control form-control-text" placeholder="00" name="">
                        </div>

                        <div class="form__block " style="width:auto">
                            <div class="text-form-block">сек</div>
                        </div>
                    </div>

                    <div class="col-sm-7 zvonok-block two-panel-result-show select-panel-blok-time url-page"  style="display:none">
                        <div class="dropdown add-user-new add-number-new select-panel-blok-input">

                            <button  class="btn btn-success" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">содержит строку</button>
                            <ul class="dropdown-menu"  aria-labelledby="dLabel">
                                <li ><label class="add-number-new-checkbox">содержит строку<input value="time-page" type="checkbox" ><span class="checkmark"></span></label></li>
                                <li ><label class="add-number-new-checkbox">не содержит строку<input value="time-site" type="checkbox" ><span class="checkmark"></span></label></li>
                                <li ><label class="add-number-new-checkbox">это точно<input value="url-page" type="checkbox" ><span class="checkmark"></span></label></li>
                                <li ><label class="add-number-new-checkbox">не являеться<input value="return-user" type="checkbox" ><span class="checkmark"></span></label></li>
                            </ul>
                        </div>

                        <div class="form__block " >

                            <input type="text" class="form-control form-control-text" placeholder="" name="catch_aou" value="">
                        </div>



                    </div>


                    <div class="delete_pravilo"><img src="/global_assets/images/icon/user/trash.svg"></div>

                </div>

            </div>
            <div class="col-xs-12 add_sourse_block">
                <div class="add_sourse add_time_call" id="add_pravilo">
                    <div class="cont__left">+</div>
                    <div class="cont_right">Добавить правило</div>
                </div>
            </div>

            <div class="banel-body-footer">
                <button type="button" class="btn btn-primary save-setings2   ">Сохранить</button>
            </div>
        </div>
    </form>
</div>