<script>
    function show_tab(id) {

        if ($('#' + id).prop('checked')) {
            valu = 1;
            $('[data-mytab=' + id + ']').show();
        } else {
            valu = 0;
            $('[data-mytab=' + id + ']').hide();
        }


    }
</script>
<script>
    var switches = Array.prototype.slice.call(document.querySelectorAll('.switchery'));
    switches.forEach(function(html) {
        var switchery = new Switchery(html, {color: '#4CAF50'});
    });

    function select_tip_redirect(id) {
        $('#block_0').hide();
        $('#block_1').hide();
        $('#block_2').hide();
        $('#block_' + id).show();


    }

    function edit_operator(id) {
        datatosend = {
            id: id
        }
        $.ajax({
            type: "POST",
            url: '/ajax/get_operator',
            data: datatosend,
            success: function (html1) {
                res = JSON.parse(html1);
                $('#url_modal').val(res['url']);
                $('#operator_name_modal').val(res['operator_name']);
                $('#job_modal').val(res['job']);
                $('#id_modal').val(res['id']);
                $('#first_message_modal').val(res['first_message']);
                $('#logo_modal').val(res['logo']);
                $('#timer_modal').val(res['timer']);
                $('.ajax-reply_modal').html('<img src="/user_upload/{{Auth::user()->my_company_id}}/' + res['logo'] + '" style="height: 100px">');
                $('#add_operator_modal').modal('show');


            }
        })
    }

    $('.edit_widget').click(function () {


        valur=$('#myform').serialize();


        $.ajax({
            type: "POST",
            url: '/ajax/wchat_save',
            data: valur,
            success: function (html1) {

                $.jGrowl('Изменения успешно сохранены', {
                    header: 'Успешно!',
                    theme: 'bg-success'
                });

            }
        })


        return false;
    });
    var files; // переменная. будет содержать данные файлов

    // заполняем переменную данными, при изменении значения поля file
    $('input[type=file]').on('change', function () {
        files = this.files;
    });
    $('.upload_files').on('click', function (event) {

        event.stopPropagation(); // остановка всех текущих JS событий
        event.preventDefault();  // остановка дефолтного события для текущего элемента - клик для <a> тега

        // ничего не делаем если files пустой
        if (typeof files == 'undefined') return;

        // создадим объект данных формы
        var data = new FormData();

        // заполняем объект данных файлами в подходящем для отправки формате
        $.each(files, function (key, value) {

            data.append(key, value);
        });

        // добавим переменную для идентификации запроса
        data.append('my_file_upload', 1);

        // AJAX запрос
        $.ajax({
            url: '/ajax/uploadfilechatavatar',
            type: 'POST', // важно!
            data: data,
            cache: false,
            dataType: 'json',
            // отключаем обработку передаваемых данных, пусть передаются как есть
            processData: false,
            // отключаем установку заголовка типа запроса. Так jQuery скажет серверу что это строковой запрос
            contentType: false,
            // функция успешного ответа сервера
            success: function (result) {


                // ОК - файлы загружены
                if (result['status'] == 1) {
                    $('.ajax-reply').html('<img src="/user_upload/{{Auth::user()->my_company_id}}/' + result['path_file'] + '" style="height: 100px">');
                    $('#logo').val(result['path_file']);
                }
                // ошибка
                else {
                    $('.ajax-reply').html(result['path_file']);
                }
            },
            // функция ошибки ответа сервера
            error: function (jqXHR, status, errorThrown) {
                console.log('ОШИБКА AJAX запроса: ' + status, jqXHR);
            }

        });

    });

    function operator_modal() {
        $('#add_operator_modal').modal('show');
        return false;
    }
</script>
<script>
    var config = {
        apiKey: "AAAAuyLEoU4:APA91bFXajGwOURe_JSk7u7jxmsLoZVnCG_rQyZukCqwe6LF4hu1e-sbGf25zR48dAUUGVZ7ZzVje38Y4EFqIr5Wq0RmgiYiAUP1HhsDStJoMO2nmsBfoXgMabFiXYyxNF7s4tXxnQdpOGzb3wpawCDLbspubNmgfg",
        authDomain: "crmtools-214107.firebaseapp.com",
        databaseURL: "https://crmtools-214107.firebaseio.com",
        projectId: "crmtools-214107",
        storageBucket: "crmtools-214107.appspot.com",
        messagingSenderId: "803742196046"
    };
    firebase.initializeApp(config);

    ;

    // браузер поддерживает уведомления
    // вообще, эту проверку должна делать библиотека Firebase, но она этого не делает
    if ('Notification' in window) {
        var messaging = firebase.messaging();

        // пользователь уже разрешил получение уведомлений
        // подписываем на уведомления если ещё не подписали
        if (Notification.permission === 'granted') {
            subscribe();
        }

        // по клику, запрашиваем у пользователя разрешение на уведомления
        // и подписываем его
        $('#subscribe').on('click', function () {

        });
    }

    function subscribe() {
        // запрашиваем разрешение на получение уведомлений
        messaging.requestPermission()
            .then(function () {
                // получаем ID устройства
                messaging.getToken()
                    .then(function (currentToken) {
                        console.log(currentToken);

                        if (currentToken) {
                            sendTokenToServer(currentToken);
                        } else {
                            console.warn('Не удалось получить токен.');
                            setTokenSentToServer(false);
                        }
                    })
                    .catch(function (err) {
                        console.warn('При получении токена произошла ошибка.', err);
                        setTokenSentToServer(false);
                    });
            })
            .catch(function (err) {
                console.warn('Не удалось получить разрешение на показ уведомлений.', err);
            });
    }

    // отправка ID на сервер
    function sendTokenToServer(currentToken) {
        // if (!isTokenSentToServer(currentToken)) {
        console.log('Отправка токена на сервер...');

        var url = ''; // адрес скрипта на сервере который сохраняет ID устройства
        $.ajax({
            type: "POST",
            url: "/chat_insertreq/setnotification",
            data: "token=" + currentToken,
            success: function (html1) {

                window.location.reload();
            }
        });

        setTokenSentToServer(currentToken);
        //  } else {
        console.log('Токен уже отправлен на сервер.');
        //   }
    }

    // используем localStorage для отметки того,
    // что пользователь уже подписался на уведомления
    function isTokenSentToServer(currentToken) {
        return window.localStorage.getItem('sentFirebaseMessagingToken') == currentToken;
    }

    function setTokenSentToServer(currentToken) {
        window.localStorage.setItem(
            'sentFirebaseMessagingToken',
            currentToken ? currentToken : ''
        );
    }


    /*  const messaging = firebase.messaging();
      //사용가능한 토큰을 발급???(요건 잘 모르겠다.)
      messaging.onTokenRefresh(function () {
          messaging.getToken().then(function (refreshedToken) {
              console.log('Token refreshed.');
              // Indicate that the new Instance ID token has not yet been sent to the
              // app server.
              setTokenSentToServer(false);
              // Send Instance ID token to app server.
              sendTokenToServer(refreshedToken);
              // [START_EXCLUDE]
              // Display new Instance ID token and clear UI of all previous messages.
              resetUI();
              // [END_EXCLUDE]
          }).catch(function (err) {
              console.log('Unable to retrieve refreshed token ', err);
              showToken('Unable to retrieve refreshed token ', err);
          });
      });

      //알림 권한 받기
      function requestPermission() {
          messaging.requestPermission().then(function () {
              console.log('Notification permission granted.');

              return messaging.getToken();

          }).then(function (token) {

              $.ajax({
                  type: "POST",
                  url: "/ajax/settoken",
                  data: "token="+token,
                  success: function (html1) {

                      window.location.reload();
                  }
              });


          }).catch(function (err) {
              console.log('Unable to get permission to notify.', err);
          });
      }
*/

</script>