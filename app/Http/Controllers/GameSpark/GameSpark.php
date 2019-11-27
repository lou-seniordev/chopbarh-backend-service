<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 24.11.19
 * Time: 19:50
 */

namespace App\Http\Controllers\GameSpark;

use App\Models\CronData;
use App\Models\Player;
use App\Models\TranPlayer;
use GuzzleHttp;
use \GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait GameSpark
{

    private function fetchPlayerList() {
        $eventKey = 'WEB_PLAYER_LIST';

        $cronData = CronData::where('eventKey', $eventKey)->first();

        $client = new GuzzleHttp\Client();

        $form = array(
            '@class' => '.LogEventRequest',
            'eventKey' => $eventKey,
            'playerId' => '5cd59c724c8e100520d660cd',
            'lastPlayerID' => $cronData->lastID
        );

        try {
            $response = $client->post('https://Y376891fcBvk.live.gamesparks.net/rs/debug/lz53ZTZDy60nxL9nXbJDvnYzSN8YYCJN/LogEventRequest',
                [
                    GuzzleHttp\RequestOptions::JSON => $form
                ],
                [
                    'Content-Type' => 'application/json'
                ]);

            if ($response->getStatusCode() == 200) {
                $result = json_decode($response->getBody());

                $data = $result->scriptData->Result;

                foreach ($data as $p) {
                    try {
                        $player = Player::where('PlayerID', $p->PlayerID)->firstOrFail();
                    } catch (ModelNotFoundException $exception) {
                        $player = new Player();
                    }

                    $player->fill((array) $p);
                    $player->save();

                    $cronData->update([
                        'lastID' => $p->PlayerID
                    ]);
                }

                return $data;
            } else {
                return ['error' => 'GameSpark not connected'];
            }

        } catch (GuzzleException $e) {
            return ['error' => 'Network not connected', 'detail' => $e->getMessage()];
        }
    }

    private function fetchTranPlayerList() {
        $eventKey = 'WEB_TRAN_PLAYER';

        $cronData = CronData::where('eventKey', $eventKey)->first();

        $client = new GuzzleHttp\Client();

        $form = array(
            '@class' => '.LogEventRequest',
            'eventKey' => $eventKey,
            'playerId' => '5cd59c724c8e100520d660cd',
            'lastTranID' => $cronData->lastID
        );

        try {
            $response = $client->post('https://Y376891fcBvk.live.gamesparks.net/rs/debug/lz53ZTZDy60nxL9nXbJDvnYzSN8YYCJN/LogEventRequest',
                [
                    GuzzleHttp\RequestOptions::JSON => $form
                ],
                [
                    'Content-Type' => 'application/json'
                ]);

            if ($response->getStatusCode() == 200) {
                $result = json_decode($response->getBody());

                $data = $result->scriptData->Result;

                foreach ($data as $tp) {
                    try {
                        $tranPlayer = TranPlayer::where('ID', $tp->ID)->firstOrFail();
                    } catch (ModelNotFoundException $exception) {
                        $tranPlayer = new TranPlayer();
                    }

                    $tranPlayer->fill((array) $tp);
                    $tranPlayer->save();

                    $cronData->update([
                        'lastID' => $tp->ID
                    ]);
                }

                return $data;
            } else {
                return ['error' => 'GameSpark not connected'];
            }

        } catch (GuzzleException $e) {
            return ['error' => 'Network not connected', 'detail' => $e->getMessage()];
        }
    }

}