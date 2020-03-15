<!-- HTML-код модального окна -->
<div id="settnotif" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Заголовок модального окна -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Уведомления чата</h4>
            </div>
            <!-- Основное содержимое модального окна -->
            <div class="modal-body">


                <button type="button" class="btn btn-success" onclick="subscribe();return false;">Разрешить</button>


            </div>
            <!-- Футер модального окна -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>

            </div>
        </div>
    </div>
</div>
<script>

    $('#settnotif').modal('show');



    /*chat_insertreq/{param}*/
</script>
