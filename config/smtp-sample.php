<?php

return array(

    // Debug mode will echo connection status alerts to
    // the screen throughout the email sending process.
    // Very helpful when testing your credentials.

    'debug_mode' => false,

    // Define the different connections that can be used.
    // You can set which connection to use when you create
    // the SMTP object: ``$mail = new SMTP('my_connection')``.

    'default' => 'primary',
    'connections' => array(
        'primary' => array(
            'host' => 'smtp.yandex.ru',
            'port' => '587',
            'secure' => 'tls', // null, 'ssl', or 'tls'
            'auth' => true, // true if authorization required
            'user' => 'support@neiros.ru',
            'pass' => '6356232',
        ),
    ),

);