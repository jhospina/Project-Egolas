<?php
return array(
    // set your paypal credential
    'client_id' => 'AXwJU9Fzw1U2KskRkuymgpZ2ws6DDJx-udkZI1XiWZ8snI1vgMSKRsICXvZYG3_cf4dy3V6iYBsxfKwZ',
    'secret' => 'EFrwv83hhNMbUQwEbqM3oq2goEpVWUQv9n7BkKLDKQr5xzByjRbkarir-ZO7X5nekqpnvAGKHkv8ntfp',

    /**
     * SDK configuration 
     */
    'settings' => array(
        /**
         * Available option 'sandbox' or 'live'
         */
        'mode' => 'sandbox',

        /**
         * Specify the max request time in seconds
         */
        'http.ConnectionTimeOut' => 30,

        /**
         * Whether want to log to a file
         */
        'log.LogEnabled' => true,

        /**
         * Specify the file that want to write on
         */
        'log.FileName' => storage_path() . '/logs/paypal.log',

        /**
         * Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
         *
         * Logging is most verbose in the 'FINE' level and decreases as you
         * proceed towards ERROR
         */
        'log.LogLevel' => 'FINE'
    ),
);