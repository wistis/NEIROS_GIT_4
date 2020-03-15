
<div id="add_operator_modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Заголовок модального окна -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Добавление Url</h4>
            </div>
            <!-- Основное содержимое модального окна -->
            <div class="modal-body">

                <div class="row mt-10">
                    <label class="col-lg-3 control-label">URL :</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="url_modal" id="url_modal"   >

                    </div>

                </div>


                <div class="row mt-10">
                    <label class="col-lg-3 control-label">Имя оператора :</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="operator_name_modal" id="operator_name_modal"  value="" >

                    </div>

                </div>
                <div class="row mt-10">
                    <label class="col-lg-3 control-label">Должность :</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="job_modal" id="job_modal"  value="" >
                        <input type="hidden" class="form-control" name="id_modal" id="id_modal"  value="0" >

                    </div>

                </div>
                <div class="row mt-10">
                    <label class="col-lg-3 control-label">Приветственное сообщение:</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="first_message_modal" id="first_message_modal"    >

                    </div>

                </div>

                <div class="row mt-10">
                    <label class="col-lg-3 control-label">Фото оператора:</label>
                    <div class="col-md-4">
                        <input type="hidden" class="form-control" name="logo_modal" id="logo_modal"    >
                        <input type="file" id="file_modal" multiple="multiple" accept=".txt,image/*">

                    </div>


                </div>
                <div class="row mt-10">

                    <div class="ajax-reply_modal col-md-6">



                    </div>  <div class="col-md-6">
                        <a href="#" class="upload_files_modal button btn btn-info">Загрузить файлы</a>

                    </div></div>

                <div class="row mt-10">
                    <label class="col-lg-3 control-label">Через сколько секунд показывать приветствие:</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="timer_modal" id="timer_modal"    >

                    </div>

                </div>


            </div>
            <!-- Футер модального окна -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary" onclick="add_operator( );return false;">Сохранить URL</button>
            </div>
        </div>
    </div>
</div>

<script>
    function add_operator() {
        datatosend={
            url_modal:$('#url_modal').val(),
            operator_name_modal:$('#operator_name_modal').val(),
            job_modal:$('#job_modal').val(),
            id_modal:$('#id_modal').val(),
            first_message_modal:$('#first_message_modal').val(),
            logo_modal:$('#logo_modal').val(),
            timer_modal:$('#timer_modal').val(),
            widget_id:$('#rtutu').val(),
              };
        $.ajax({
            type: "POST",
            url: '/ajax/safe_operator',
            data: datatosend,
            success: function (html1) {

                mynotif( 'Успешно!','Изменения успешно сохранены','success')
setTimeout(f=>{
  window.location.reload()
},1000)
            }
        })

    }

    var files_modal; // переменная. будет содержать данные файлов

    // заполняем переменную данными, при изменении значения поля file
    $('#file_modal').on('change', function(){
        files_modal = this.files;
    });
    $('.upload_files_modal').on( 'click', function( event ){

        event.stopPropagation(); // остановка всех текущих JS событий
        event.preventDefault();  // остановка дефолтного события для текущего элемента - клик для <a> тега

        // ничего не делаем если files пустой
        if( typeof files_modal == 'undefined' ) return;

        // создадим объект данных формы
        var data = new FormData();

        // заполняем объект данных файлами в подходящем для отправки формате
        $.each( files_modal, function( key, value ){

            data.append( key, value );
        });

        // добавим переменную для идентификации запроса
        data.append( 'my_file_upload', 1 );

        // AJAX запрос
        $.ajax({
            url         : '/ajax/uploadfilechatavatar',
            type        : 'POST', // важно!
            data        : data,
            cache       : false,
            dataType    : 'json',
            // отключаем обработку передаваемых данных, пусть передаются как есть
            processData : false,
            // отключаем установку заголовка типа запроса. Так jQuery скажет серверу что это строковой запрос
            contentType : false,
            // функция успешного ответа сервера
            success     : function( result){


                // ОК - файлы загружены
                if( result['status']== 1 ){
                    $('.ajax-reply_modal').html('<img src="/user_upload/{{Auth::user()->my_company_id}}/'+result['path_file']+'" style="height: 100px">');
                    $('#logo_modal').val(result['path_file']);
                }
                // ошибка
                else {
                    $('.ajax-reply_modal').html(result['path_file']);
                }
            },
            // функция ошибки ответа сервера
            error: function( jqXHR, status, errorThrown ){
                console.log( 'ОШИБКА AJAX запроса: ' + status, jqXHR );
            }

        });

    });


</script>