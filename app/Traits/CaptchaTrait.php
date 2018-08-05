<?php namespace App\Traits;

use ReCaptcha\ReCaptcha;

trait CaptchaTrait {

    public function captchaCheck($data)
    {

        $response = $data;

        $remoteip = $_SERVER['REMOTE_ADDR'];
        $secret   = config('app.google_recap_secret');

        $recaptcha = new ReCaptcha($secret);
        $resp = $recaptcha->verify($response, $remoteip);
        if ($resp->isSuccess()) {
            return 1;
        } else {
            return 0;
        }

    }

}