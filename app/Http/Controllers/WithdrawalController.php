<?php

namespace App\Http\Controllers;

use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class WithdrawalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //READ
    public function index()
    {
        //
        $withdrawals = DB::table('withdrawals')->paginate(50);
        print_r(json_encode($withdrawals));

    }

    public function search(Request $request)
    {
        $input = $request->json()->all();
        $query = $input['query'];

        $deposits = DB::table('withdrawals')->where('playerId', 'like', '%'.$query.'%')
            ->orWhere('amount','LIKE','%'.$query.'%')
            ->orWhere('channel','LIKE','%'.$query.'%')
            ->orWhere('status','LIKE','%'.$query.'%')
            ->orWhere('transaction_fee','LIKE','%'.$query.'%')
            ->orWhere('transaction_reference','LIKE','%'.$query.'%')
            ->orWhere('gameTransactionId','LIKE','%'.$query.'%')
            ->paginate(50);

        print_r(json_encode($deposits));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //****CREATE****
    public function store(Request $request)
    {
        //
        $response = (Object) [
            'id'    => 0,
            'message' => ""
        ];

        $input = $request->json()->all();

        $rules = [
            'id' => 'required|string',
            'playerId' => 'required|string',
            'amount' => 'required|integer',
            'channel' => 'required|string',
            'gameTransactionId' => 'required|string',
            'paid_at' => 'required|string',
            'status' => 'required|string',
            'time_seconds' => 'required|string',
            'time_nanoseconds' => 'required|string',
            'transaction_fee' => 'required|integer',
            'transaction_reference'=> 'required|string',
            'withdrawal_date' => 'required|string',
        ];


        $validator = Validator::make((array)$input, $rules);

        if ($validator->fails()) {

            foreach($validator->errors()->all() as $error){

                $response->message = $response->message.$error."\n";

            }

        }else {


            $withdrawal = Withdrawal::create([
                'id' => $request['id'],
                'amount' => $request['amount'],
                'channel' => $request['channel'],
                'gameTransactionId' => $request['gameTransactionId'],
                'paid_at' => $request['paid_at'],
                'playerId' => $request['playerId'],
                'status' => $request['status'],
                'time_seconds' => $request['time_seconds'],
                'time_nanoseconds' => $request['time_nanoseconds'],
                'transaction_fee' => $request['transaction_fee'],
                'transaction_reference'=> $request['transaction_reference'],
                'withdrawal_date'=> $request['withdrawal_date']
            ]);


            $response->id = 1;
            $response->message = "New withdrawal done.";

        }

        return json_encode($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //****UPDATE****
    public function update(Request $request, $id)
    {
        //
        $response = (Object) [
            'id'    => 0,
            'message' => ""
        ];

        $withdrawal = Withdrawal::find($id);


        $rules = [
            'amount_Mod' => 'required|string',
            'channel_Mod' => 'required|string',
            'gameTransactionId_Mod' => 'required|string',
            'paid_at_Mod' => 'required|string',
            'playerId_Mod' => 'required|string',
            'status_Mod' => 'required|string',
            'time_Mod' => 'required|datetime',
            'transaction_fee_Mod'=> 'required|integer',
            'transaction_reference_Mod'=> 'required|string',
            'withdrawal_date_Mod'=> 'required|string'
        ];

        $validator = Validator::make((array)$request->all(), $rules);

        if ($validator->fails()) {

            foreach($validator->errors()->all() as $error){

                $response->message = "\n".$response->message.$error."\n";

            }

        } else {

            $withdrawal->update([
                'amount' =>  (isset($request->amount_Mod)) ? $request->amount_Mod : $withdrawal->amount,
                'channel' => (isset($request->channel_Mod)) ? $request->channel_Mod : $withdrawal->channel,
                'gameTransactionId' => (isset($request->gameTransactionId_Mod)) ? $request->gameTransactionId_Mod : $withdrawal->gameTransactionId,
                'paid_at' => (isset($request->paid_at_Mod)) ? $request->paid_at_Mod : $withdrawal->paid_at,
                'playerId' => (isset($request->playerId_Mod)) ? $request->playerId_Mod : $withdrawal->playerId,
                'status' => (isset($request->status_Mod)) ? $request->status_Mod : $withdrawal->status,
                'time' => (isset($request->time_Mod)) ? $request->time_Mod : $withdrawal->time,
                'transaction_fee' => (isset($request->transaction_fee_Mod)) ? $request->transaction_fee_Mod : $withdrawal->transaction_fee,
                'transaction_reference'=> (isset($request->transaction_reference_Mod)) ? $request->transaction_reference_Mod : $withdrawal->transaction_reference,
                'withdrawal_date'=> (isset($request->withdrawal_date_Mod)) ? $request->withdrawal_date_Mod : $withdrawal->withdrawal_date
            ]);


            $response = (Object)[
                'id' => 1,
                'message' => "Succes"
            ];
        }

        echo json_encode($response) ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $response = (Object)[
            'id' => 0,
            'type' => "error",
            'title' => "Echec !!!",
            'url' => " ",
            'message' => " "
        ];


        $withdrawal = Withdrawal::find($id);

        DB::beginTransaction();

        try{


            $withdrawal->delete();

            $response = (Object)[
                'id' => 1,
                'type' => "success",
                'title' => "Reussite !!!",
                'message' => "Withdrawal deleted."
            ];

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();
            $response->message = $e->getMessage();

        }


        echo json_encode($response);
    }
}
