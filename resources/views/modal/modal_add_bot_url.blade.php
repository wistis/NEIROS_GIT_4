<!-- HTML-код модального окна -->
<div id="modal_add_bot_url_1" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Заголовок модального окна -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Добавление Url списком</h4>
            </div>
            <!-- Основное содержимое модального окна -->
            <div class="modal-body">


                <div class="form-group">
                    <label class="col-lg-12 control-label">Вставьте URL,по 1 урл в строке :</label>
                    <div class="col-lg-12">
                        <textarea id="modal_add_bot_url_1_text" class="form-control"></textarea>
                    </div>
                </div>


            </div>
            <!-- Футер модального окна -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary" onclick="add_url(1);return false;">Добавить URL</button>
            </div>
        </div>
    </div>
</div>

