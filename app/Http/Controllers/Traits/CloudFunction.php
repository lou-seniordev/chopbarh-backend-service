<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 29.01.20
 * Time: 02:42
 */

namespace App\Http\Controllers\Traits;

use GuzzleHttp;
use \GuzzleHttp\Exception\GuzzleException;

trait CloudFunction
{
    private function chopbarhWidthraw($param) {

        try {
            $client = new GuzzleHttp\Client([
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-type' => 'application/json',
                    'x-api-key' => '50184d1c-c010-4346-9d6b-24951596d5e7' ]
            ]);

            $response = $client->post('https://us-central1-dev-sample-31348.cloudfunctions.net/chopbarhWithdrawal/player/withdraw',
                [
                    GuzzleHttp\RequestOptions::JSON => $param
                ]
            );

            if ($response->getStatusCode() == 200) {
                return json_decode($response->getBody()->getContents());
            } else return [
                'status' => false,
                'message' => "Action was not carried out due to an error"
            ];
        } catch (GuzzleException $e) {
            return ['error' => 'Unknown issue', 'message' => $e->getMessage()];
        }

    }
}