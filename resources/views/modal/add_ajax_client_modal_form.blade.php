<!-- HTML-код модального окна -->
<div id="add_ajax_task_modal_form" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Заголовок модального окна -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Добавление контакта</h4>
            </div>
            <!-- Основное содержимое модального окна -->
            <div class="modal-body">

                <input type="hidden" id="t_project_id" value="{{$id}}">

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">ФИО:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="t_fio" id="t_fio"    required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">E-mail:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="t_email" id="t_email"    required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Телефон:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="t_phone" id="t_phone"    required>
                                    </div>
                                </div>





                            </fieldset>
                        </div>
                        {{--Дополнительные поля--}}
                        <div class="col-md-6">
                            <fieldset>


                            </fieldset>
                        </div>
                    </div>


                </div>


















            </div>
            <!-- Футер модального окна -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary add_ajax_contact_modal_safe">Добавить</button>
            </div>
        </div>
    </div>
</div>