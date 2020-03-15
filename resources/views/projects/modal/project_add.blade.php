<div id="ClientInfoModalAdd" class="modal fade ClientInfoModal lids-neiros">
   <form id="add_ajax_project">
       @csrf

    <div class="modal-dialog" >
        <div class="modal-content"  style="height: 100vh">
            <!-- Заголовок модального окна -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >×</button>
            </div>
            <!-- Основное содержимое модального окна -->
            <div class="modal-body">
                <div class="name-block-fixed">
                    <div class="col-sm-5 col-xs-12" ><div class="h1-modal pos-left">Информация пользователя</div></div>
                    <div class="col-sm-7 col-xs-12" ><div class="h1-modal pos-right">Активность</div></div>
                </div>


                <div class="col-sm-5 col-xs-12" >

                    <div class="user-block col-xs-12">
                        <div class="col-xs-4 img-avatar">
                            <img src="/templatechat/images/pfotografy-none.jpg" width="100%">
                        </div>
                        <div class="col-xs-8 user-description">
                            <div class="h1">Клиент </div>
                            <div class="h2"><span>в сети:</span>
                                <span></span> <span></span>


                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12" style="padding-left:0px; padding-right:0px;">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#info" aria-controls="home" role="tab" data-toggle="tab">Основная информация</a></li>

                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade in active" id="info">
                                <div class="">


                                    <div class="form-group col-xs-12" style="padding-left:0px; padding-right:0px;">
                                        <label for="city">ФИО</label>
                                        <input type="text"   class="form-control" name="fio"   placeholder="Фио" value="">
                                    </div>


                                    <div class="form-group col-xs-12" style="padding-left:0px; padding-right:0px;">
                                        <label for="city">Телефон</label>
                                        <input type="text"   class="form-control"   name="phone"   placeholder="Телефон" value="">
                                    </div>


                                    <div class="form-group col-xs-12" style="padding-left:0px; padding-right:0px;">
                                        <label for="city">E-mail</label>
                                        <input type="text"   class="form-control"  name="email"   placeholder="E-mail" value="">
                                    </div>

                                </div>

                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="analitics"></div>

                        </div>


                    </div>
                </div>

                <div class="col-sm-7 col-xs-12 right-block-mod" >


                    <div class="activnost" >
                        <div class="block-activnost">
                            <div class="diliver diliver--gray" style="margin-top: 6px;"><span>Сегодня</span></div>
                            <div class="activnost-block new-lid" >
                                <div class="time-event">
                                    Новая сделка
                                    <span>в  <?=date('H:i');?></span>
                                </div>
                                <div class="lid-input-modal-block">
                                    @if($widget_promocod->status==1) <div class="lid-cont-modal-input"><input type="text" class=" lid-input-modal" name="promokod" placeholder="Введите промокод" value=""></div>@endif
                                    <div class="lid-cont-modal-input summ"><input type="text" class=" lid-input-modal" name="summ" placeholder="Сумма сделки" value=""> </div>

                                <div class="lid-cont-modal-input save"><button type="button" class="btn btn-info add_ajax_lead create-lid" >Сохранить</button></div>



                                </div>
                            </div>


                        </div>

                    </div>

                </div>
            </div>


        <?php /*?><div class="modal-body infclinfo" >

            </div><?php */?>
        <!-- Футер модального окна -->

        </div>
    </div>
   </form>
</div>
