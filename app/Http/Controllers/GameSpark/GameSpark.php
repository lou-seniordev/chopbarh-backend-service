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

    private function getPlayer($phone) {
        $eventKey = 'ANALYTICS_PLAYER_DATA_VIA_PHONE';

        $client = new GuzzleHttp\Client();

        $form = array(
            '@class' => '.LogEventRequest',
            'eventKey' => $eventKey,
            'playerId' =>  env('GAMESPARK_PLAYER_ID', ''),
            'PHONE_NUM' => $phone
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

                $data = $result->scriptData->results;

                if (sizeof($data) > 0) return $data[0];
                else return null;
            } else {
                return ['error' => 'GameSpark not connected'];
            }
        } catch (GuzzleException $e) {
            return ['error' => 'Network not connected', 'detail' => $e->getMessage()];
        }
    }

    private function editPlayer($full_name, $dob, $sex, $email) {
        $eventKey = 'PLAYER_PROFILE_UPDATE';

        $client = new GuzzleHttp\Client();

        $form = array(
            '@class' => '.LogEventRequest',
            'eventKey' => $eventKey,
            'playerId' =>  env('GAMESPARK_PLAYER_ID', ''),
            'FULL_NAME' => $full_name,
            'DOB' => $dob,
            'SEX' => $sex,
            'Email' => $email
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

                if (isset($result->error)) return false;
                else return true;
            } else {
                return false;
            }
        } catch (GuzzleException $e) {
            return false;
        }
    }

    private function changePlayerPin($old_pin, $new_pin) {
        $eventKey = 'REGISTER_CHANGE_PASSWORD';

        $client = new GuzzleHttp\Client();

        $form = array(
            '@class' => '.LogEventRequest',
            'eventKey' => $eventKey,
            //'playerId' =>  env('GAMESPARK_PLAYER_ID', ''),
            'playerId' => "5d5ed4835a5f2305222de3ff",
            'OLD' => $old_pin,
            'NEW' => $new_pin
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

                if (isset($result->scriptData)) return false;
                else return true;
            } else
                return false;
        } catch (GuzzleException $e) {
            return false;
        }
    }

    private function loginPlayer($phone_number, $pin) {
        $client = new GuzzleHttp\Client();

        $form = array(
            '@class' => '.AuthenticationRequest',
            'userName' => $phone_number,
            'password' => $pin
        );

        try {
            $response = $client->post('https://Y376891fcBvk.live.gamesparks.net/rs/debug/lz53ZTZDy60nxL9nXbJDvnYzSN8YYCJN/AuthenticationRequest',
                [
                    GuzzleHttp\RequestOptions::JSON => $form
                ],
                [
                    'Content-Type' => 'application/json'
                ]);

            if ($response->getStatusCode() == 200) {
                $result = json_decode($response->getBody());

                return $result;
            } else {
                return null;
            }
        } catch (GuzzleException $e) {
            return null;
        }
    }

    private function updatePlayerCoin($amount, $playerId, $condition) {
        $eventKey = 'PLAYER_COINS_UPDATE';

        $client = new GuzzleHttp\Client();

        $form = array(
            '@class' => '.LogEventRequest',
            'eventKey' => $eventKey,
            'playerId' => $playerId,
            'Coins' => $amount,
            'Condition' => $condition
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

                return $result;
            } else
                return false;
        } catch (GuzzleException $e) {
            return false;
        }
    }

    private function updatePlayerCash($amount, $playerId, $condition) {
        $eventKey = 'PLAYER_CASH_UPDATE';

        $client = new GuzzleHttp\Client();

        $form = array(
            '@class' => '.LogEventRequest',
            'eventKey' => $eventKey,
            'playerId' => $playerId,
            'Cash' => $amount,
            'Condition' => $condition
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

                return $result;
            } else
                return false;
        } catch (GuzzleException $e) {
            return false;
        }
    }
}