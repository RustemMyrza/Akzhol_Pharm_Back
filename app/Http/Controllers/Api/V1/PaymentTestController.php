<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Token;

class PaymentTestController extends Controller
{
    public function getToken ()
    {
        $url = 'https://testoauth.homebank.kz/epay2/oauth2/token';
        $params = [
            'grant_type' => 'client_credentials',
            'scope' => 'webapi usermanagement email_send verification statement statistics payment',
            'client_id' => 'test',
            'client_secret' => 'yF587AV9Ms94qN2QShFzVR3vFnWkhjbAK3sG',
            'invoiceID' => '000001',
            'amount' => 100,
            'currency' => 'KZT',
            'terminal' => '67e34d63-102f-4bd1-898e-370781d0074d'
        ];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        $tokenData = json_decode($response, 1);

        Token::create([
            'access_token' => $tokenData['access_token'],
            'expires_in' => $tokenData['expires_in'],
            'token_type' => $tokenData['token_type']
        ]);

        return $response; 
    }
}
