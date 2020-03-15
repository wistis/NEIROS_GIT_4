<!-- HTML-код модального окна -->
<div id="add_test_modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Заголовок модального окна -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Тест</h4>
            </div>
            <!-- Основное содержимое модального окна -->
            <div class="modal-body ">
<form id="lead_ad_test"  name="lead_ad_test">


    @include('widgets.render.catch_lead.test_form')

</form>
















            </div>
            <!-- Футер модального окна -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary w_safebutton_adad">Добавить</button>
            </div>
        </div>
    </div>
</div>