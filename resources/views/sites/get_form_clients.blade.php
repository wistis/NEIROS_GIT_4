<div class="panel panel-flat" id="t_display_{{$number}}">
    <input type="hidden" id="t_active_{{$number}}" value="1">
    <input type="hidden" id="t_id_{{$number}}" value="0">
    <div class="panel-heading">
        <h6 class="panel-title">Новый контакт</h6>
        <div class="heading-elements">
            <ul class="icons-list">

                <li><a   onclick="close_task({{$number}})" >X</a></li>
            </ul>
        </div>
    </div>

    <div class="panel-body"> <fieldset>
            <div class="col-md-12">
                <fieldset>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">ФИО:</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="t_fio" id="t_fio_{{$number}}"    required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">E-mail:</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="t_email" id="t_email_{{$number}}"    required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">Телефон:</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="t_phone" id="t_phone_{{$number}}"    required>
                        </div>
                    </div>





                </fieldset>
            </div>













</div>
</div>
