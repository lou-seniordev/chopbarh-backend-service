<?php

namespace App\Http\Controllers;

use App\Models\Deposits;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;


class DepositsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //****READ****
    public function index(Request $request)
    {
        //

        $deposits = DB::table('deposits')->paginate(50);

        print_r(json_encode($deposits));

    }

    public function search(Request $request)
    {
        $input = $request->json()->all();
        $query = $input['query'];

        $deposits = DB::table('deposits')->where('playerId', 'like', '%'.$query.'%')
            ->orWhere('amount','LIKE','%'.$query.'%')
            ->orWhere('channel','LIKE','%'.$query.'%')
            ->orWhere('customer_id','LIKE','%'.$query.'%')
            ->orWhere('gateway','LIKE','%'.$query.'%')
            ->orWhere('refId','LIKE','%'.$query.'%')
            ->orWhere('status','LIKE','%'.$query.'%')
            ->orWhere('transaction_fees','LIKE','%'.$query.'%')
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
            'amount' => 'required|integer',
            'channel' => 'required|string',
            'customer_id' => 'required|string',
            'deposit_date' => 'required|string',
            'gameTransactionId' => 'string',
            'gateway' => 'required|string',
            'paid_at' => 'required|string',
            'playerId' => 'required|string',
            'refId' => 'required|string',
            'rownum' => 'integer',
            'status' => 'required|string',
            'time_seconds' => 'string',
            'time_nanoseconds' => 'string',
            'transaction_fees' => 'required|integer',
            'transaction_reference'=> 'required|string'
        ];


        $validator = Validator::make((array)$input, $rules);

        if ($validator->fails()) {

            foreach($validator->errors()->all() as $error){

                $response->message = $response->message.$error."\n";

            }

        }else {


            $deposit = Deposits::create([
                'id' => $input['id'],
                'amount' => $input['amount'],
                'channel' => $input['channel'],
                'customer_id' => $input['customer_id'],
                'deposit_date' => $input['deposit_date'],
                'gameTransactionId' => '',
                'gateway' => $input['gateway'],
                'paid_at' => $input['paid_at'],
                'playerId' => $input['playerId'],
                'refId' => $input['refId'],
                'rownum' => '',
                'status' => $input['status'],
                'timeseconds' => '',
                'timenanoseconds' => '',
                'transaction_fees' => $input['transaction_fees'],
                'transaction_reference'=> $input['transaction_reference']
            ]);


            $response->id = 1;
            $response->message = "New deposit done.";

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

        $deposit = Deposits::find($id);


        $rules = [
            'amount_Mod' => 'required|string',
            'channel_Mod' => 'required|string',
            'customer_id_Mod' => 'required|string',
            'deposit_date_Mod' => 'required|string',
            'gameTransactionId_Mod' => 'required|string',
            'gateway_Mod' => 'required|string',
            'paid_at_Mod' => 'required|string',
            'playerId_Mod' => 'required|string',
            'refId_Mod' => 'required|string',
            'rownum_Mod' => 'required|integer',
            'status_Mod' => 'required|string',
            'time_Mod' => 'required|datetime',
            'transaction_fees_Mod' => 'required|integer',
            'transaction_reference_Mod'=> 'required|string'
        ];

        $validator = Validator::make((array)$request->all(), $rules);

        if ($validator->fails()) {

            foreach($validator->errors()->all() as $error){

                $response->message = "\n".$response->message.$error."\n";

            }

        } else {

            $deposit->update([
                'amount' =>  (isset($request->amount_Mod)) ? $request->amount_Mod : $deposit->amount,
                'channel' => (isset($request->channel_Mod)) ? $request->channel_Mod : $deposit->channel,
                'customer_id' => (isset($request->customer_id_Mod)) ? $request->customer_id_Mod : $deposit->customer_id,
                'deposit_date' => (isset($request->deposit_date_Mod)) ? $request->deposit_date_Mod : $deposit->deposit_date,
                'gameTransactionId' => (isset($request->gameTransactionId_Mod)) ? $request->gameTransactionId_Mod : $deposit->gameTransactionId,
                'gateway' => (isset($request->gateway_Mod)) ? $request->gateway_Mod : $deposit->gateway,
                'paid_at' => (isset($request->paid_at_Mod)) ? $request->paid_at_Mod : $deposit->paid_at,
                'playerId' => (isset($request->playerId_Mod)) ? $request->playerId_Mod : $deposit->playerId,
                'refId' => (isset($request->refId_Mod)) ? $request->refId_Mod : $deposit->refId,
                'rownum' => (isset($request->rownum_Mod)) ? $request->rownum_Mod : $deposit->rownum,
                'status' => (isset($request->status_Mod)) ? $request->status_Mod : $deposit->status,
                'time' => (isset($request->time_Mod)) ? $request->time_Mod : $deposit->time,
                'transaction_fees' => (isset($request->transaction_fees_Mod)) ? $request->transaction_fees_Mod : $deposit->transaction_fees,
                'transaction_reference'=> (isset($request->transaction_reference_Mod)) ? $request->transaction_reference_Mod : $deposit->transaction_reference,
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
    //****DELETE***
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


        $deposit = Deposits::find($id);

        DB::beginTransaction();

        try{


            $deposit->delete();

            $response = (Object)[
                'id' => 1,
                'type' => "success",
                'title' => "Reussite !!!",
                'message' => "Deposit deleted."
            ];

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();
            $response->message = $e->getMessage();

        }


        echo json_encode($response);
    }
}
