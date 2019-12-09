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
use App\Models\TranGame;
use App\Models\TranPlayer;
use App\Models\TranTransfer;
use GuzzleHttp;
use \GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

trait GameSpark
{

    private function fetchPlayerList() {
        $eventKey = 'WEB_PLAYER_LIST';

        $cronData = CronData::where('eventKey', $eventKey)->first();

        $client = new GuzzleHttp\Client();

        $form = array(
            '@class' => '.LogEventRequest',
            'eventKey' => $eventKey,
            'playerId' =>  env('GAMESPARK_PLAYER_ID', ''),
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
            'playerId' =>  env('GAMESPARK_PLAYER_ID', ''),
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

    private function fetchTransactionList() {
        $eventKey = 'WEB_TRANSACTION';

        $cronData = CronData::where('eventKey', $eventKey)->first();

        $client = new GuzzleHttp\Client();

        $form = array(
            '@class' => '.LogEventRequest',
            'eventKey' => $eventKey,
            'playerId' =>  env('GAMESPARK_PLAYER_ID', ''),
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

                foreach ($data as $t) {
                    if ($t->TranType == "GAME") {
                        try {
                            $tranGame = TranGame::where('TranID', $t->TranID)->firstOrFail();
                        } catch (ModelNotFoundException $exception) {
                            $tranGame = new TranGame();
                        }

                        $tranGame->fill((array) $t);
                        $tranGame->save();
                    } elseif ($t->TranType == "TRANSFER") {
                        try {
                            $tranTransfer = TranTransfer::where('TranID', $t->TranID)->firstOrFail();
                        } catch (ModelNotFoundException $exception) {
                            $tranTransfer = new TranTransfer();
                        }

                        $tranTransfer->fill((array) $t);
                        $tranTransfer->save();
                    }

                    $cronData->update([
                        'lastID' => $t->TranID
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