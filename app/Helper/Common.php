<?php

namespace App\Helper;

class Common
{

    /** Return success response
     * @param $date
     * @return string
     */

    public static function dateColor($date, $past=true): string
    {
        if (is_null($date)) {
            return '--';
        }

        $formattedDate = $date->translatedFormat(company()->date_format);
        $todayText = __('app.today');

        if ($date->setTimezone(company()->timezone)->isToday()) {
            return '<span class="text-success">' . $todayText . '</span>';
        }

        if ($date->endOfDay()->isPast() && $past ) {
            return '<span class="text-danger">' . $formattedDate . '</span>';
        }

        return '<span>' . $formattedDate . '</span>';
    }

    public static function active(): string
    {
        return '<i class="fa fa-circle mr-1 text-light-green f-10"></i>' . __('app.active');
    }

    public static function inactive(): string
    {
        return '<i class="fa fa-circle mr-1 text-red f-10"></i>' . __('app.inactive');
    }

    public static function encryptDecrypt($string, $action = 'encrypt')
    {

        // DO NOT CHANGE IT. CHANGING IT WILL AFFECT THE APPLICATION
        $secret_key = 'e7f4d5b8a9c3e1f0d2a6b7c8e9f1a0d3f4c5b6a7d8e9f0c1b2a3d4e5f6a7b8c9'; // User define private key
        $secret_iv = '3f8c1e7a9d2b4f0c5e6a7b8d9f0e1c2a3d4b5f6a7c8e9d0b1f2a3c4e5d6b7f8'; // User define secret key

        $encryptMethod = 'AES-256-CBC';
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16); // sha256 is hash_hmac_algo

        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encryptMethod, $key, 0, $iv);

            return base64_encode($output);
        }

        if ($action == 'decrypt') {
            return openssl_decrypt(base64_decode($string), $encryptMethod, $key, 0, $iv);
        }

        throw new \Exception('No action provided for Common::encryptDecrypt');

    }

}
