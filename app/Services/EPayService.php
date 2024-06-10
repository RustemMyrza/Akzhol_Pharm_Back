<?php

declare(strict_types=1);

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class EPayService
{
    const TERMINAL_ID = '67e34d63-102f-4bd1-898e-370781d0074d';
    const CLIENT_ID = 'test';
    const CLIENT_SECRET = 'yF587AV9Ms94qN2QShFzVR3vFnWkhjbAK3sG';
    const IS_TEST = 1;

    /**
     * @throws \Exception
     */
    public function createToken(object $payment)
    {
        $url = self::IS_TEST ? 'https://testoauth.homebank.kz/epay2/oauth2/token' : 'https://epay-oauth.homebank.kz/oauth2/token';

        try {
            $client = new Client();

            $response = $client->post($url, [
                'form_params' => [
                    'grant_type' => 'client_credentials',
                    'scope' => 'webapi usermanagement email_send verification statement statistics payment',
                    'client_id' => self::CLIENT_ID,
                    'client_secret' => self::CLIENT_SECRET,
                    'invoiceID' => $payment->invoice_id,
                    'amount' => $payment->amount,
                    'description' => $payment->description,
                    'currency' => 'KZT',
                    'terminal' => self::TERMINAL_ID,
                    'postLink' => '',
                    'failurePostLink' => '',
                    'cardSave' => true,
                ]
            ]);

            return json_decode($response->getBody()->getContents());
        } catch (GuzzleException $guzzleException) {
            Log::channel('epay')->error('Error creating token: ' . $guzzleException->getMessage());
            throw new \Exception($guzzleException->getMessage());
        }
    }
}
