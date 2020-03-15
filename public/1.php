<?php
try {
   $m= imap_open(
        "{smtp.yandex.ru:993/imap/ssl}",

        "ceo@wistis.ru",

        "HellRestor",

        0,

        3,

        []

    );
    var_dump($m);  $errors = imap_errors(); var_dump($errors);
} catch (\ErrorException $e) {

}