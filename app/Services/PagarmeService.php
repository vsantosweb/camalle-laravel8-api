<?php

namespace App\Services;

use PagarMe\Client as Pagarme;

class PagarmeService
{
    private static $pagarme;

    public static function start()
    {
        if (!isset(self::$pagarme)) {
            try {
                self::$pagarme =  new Pagarme(env('PAGARME_API_KEY'));
            } catch (\Throwable $th) {
                throw $th;
            }
        }
        return self::$pagarme;
    }
}
