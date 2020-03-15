<div id="myModalBox" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Заголовок модального окна -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Настройки</h4>
            </div>
            <!-- Основное содержимое модального окна -->
            <div class="modal-body">
                <h3>Вид страницы</h3>
                <div class="row">
                    <div class="col-md-6">Воронка</div>
                    <div class="col-md-6"><input type="radio" name="task_vid" value="0" @if($task_vid==0) checked @endif ></div>


                </div>
                <div class="row">
                    <div class="col-md-6">Список</div>
                    <div class="col-md-6"><input type="radio" name="task_vid" value="1"  @if($task_vid==1) checked @endif></div>


                </div>

            </div>
            <!-- Футер модального окна -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary safe_task_vid" >Сохранить изменения</button>
            </div>
        </div>
    </div>
</div>