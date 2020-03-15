<!-- HTML-код модального окна -->
<div id="modal_field" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Заголовок модального окна -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Поля</h4>
            </div>
            <!-- Основное содержимое модального окна -->
            <div class="modal-body">

                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#panel1">Добавить поле</a></li>
                    <li><a data-toggle="tab" href="#panel2">Уже созданые пол</a></li>

                </ul>

                <div class="tab-content">
                    <div id="panel1" class="tab-pane fade in active">
                        <h3>Добавление поля</h3>
                        <p>
                            <form id="add_field">
                            <div class="col-md-12 mt-15"><input type="text" placeholder="Название поля" name="field_name" id="field_name" class="form-control" required> </div>
                            <div class="col-md-12 mt-15"><select name="field_tip" id="field_tip" class="form-control" required>
                                    <option value="">Выберите тип поля</option>
                                    <option value="0">Текст</option>
                                    <option value="1">Многострочный текст</option>
                                    <option value="2">Галочка</option>
                                    <option value="3">Дата</option>
                                </select></div>
                            <div class="col-md-12 mt-15"><button type="button" class="add_field btn  btn-success">Добавть</button> </div>




                        </form>

                        </p>
                    </div>
                    <div id="panel2" class="tab-pane fade">
                        <h3>Уже существуют</h3>
                        <div class="row allfields">Поля...</div>
                    </div>

                </div>




















            </div>
            <!-- Футер модального окна -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>