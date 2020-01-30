<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 28.11.19
 * Time: 02:13
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\GameSpark;

class TransactionController extends Controller
{
    use GameSpark;

    public function fetchFromGameSpark()
    {
        $result = $this->fetchTransactionList();
        return response()->json($result);
    }
}