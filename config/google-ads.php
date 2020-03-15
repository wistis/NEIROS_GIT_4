<?php

return [
    'ADWORDS' => [
        'developerToken' => 'moQTiW4L_gSt6WmfPwElmw',
        'clientCustomerId' => '483-801-8994',

        /*
         * Optional. Set a friendly application name identifier.
         *
         * 'userAgent' => '',
         */

        /*
         * Optional additional AdWords API settings.
         * endpoint = "https://adwords.google.com/"
         *
         * 'isPartialFailure' => false,
         */

        /*
         * Optional setting for utility usage tracking in the user agent in requests.
         * Defaults to true.
         *
         * 'includeUtilitiesInUserAgent' => true,
         */
    ],

    'DFP' => [
        'networkCode' => '',
        'applicationName' => '',
    ],

    'ADWORDS_REPORTING' => [
        /*
         * Optional reporting settings.
         *
         * 'isSkipReportHeader' => false,
         * 'isSkipColumnHeader' => false,
         * 'isSkipReportSummary' => false,
         * 'isUseRawEnumValues' => false,
         */
    ],

    'OAUTH2' => [

            'clientId' => '928548831727-02q34vlpnvgk59rbvv1s7jdbihai6h2l.apps.googleusercontent.com',
         'clientSecret' => 'qNzgzdeQ6I9Oecv9Hi9e-fiP',
          'refreshToken' => '1/p6Igbx1kXvm2plCAAh_pKPz1119nKTuYJ4UbSKwlh1M',
/*
         * Required OAuth2 credentials. Uncomment and fill in the values for the
         * appropriate flow based on your use case. See the README for guidance:
         * https://github.com/googleads/googleads-php-lib/blob/master/README.md#getting-started
         */

        /*
         * For installed application or web application flow.
         *
         */

        /*
         * For service account flow.
         * 'jsonKeyFilePath' => 'INSERT_ABSOLUTE_PATH_TO_OAUTH2_JSON_KEY_FILE_HERE'
         * 'scopes' => 'https://www.googleapis.com/auth/adwords',
         */
    ],

    'SOAP' => [
        /*
         * Optional SOAP settings. See SoapSettingsBuilder.php for more information.
         * 'compressionLevel' => <COMPRESSION_LEVEL>,
         * 'wsdlCache' => <WSDL_CACHE>,
         */
    ],

    'PROXY' => [
        /*
         * Optional proxy settings to be used by SOAP requests.
         * 'host' => '<HOST>',
         * 'port' => <PORT>,
         * 'user' => '<USER>',
         * 'password' => '<PASSWORD>',
         */
    ],

    'LOGGING' => [
        /*
         * Optional logging settings.
         * 'soapLogFilePath' => 'path/to/your/soap.log',
         * 'soapLogLevel' => 'INFO',
         * 'reportDownloaderLogFilePath' => 'path/to/your/report-downloader.log',
         * 'reportDownloaderLogLevel' => 'INFO',
         * 'batchJobsUtilLogFilePath' => 'path/to/your/bjutil.log',
         * 'batchJobsUtilLogLevel' => 'INFO',
         */
    ],
];
