<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class DepositController extends Controller
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


            $deposit = Deposit::create([
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

        $deposit = Deposit::find($id);

        $input = $request->json()->all();

        $rules = [
            'amount_Mod' => 'required|integer',
            'channel_Mod' => 'required|string',
            'customer_id_Mod' => 'required|string',
            'deposit_date_Mod' => 'required|string',
            'gameTransactionId_Mod' => 'string',
            'gateway_Mod' => 'required|string',
            'paid_at_Mod' => 'required|string',
            'playerId_Mod' => 'required|string',
            'refId_Mod' => 'required|string',
            'rownum_Mod' => 'integer',
            'status_Mod' => 'required|string',
            'time_seconds_Mod' => 'string',
            'time_nanoseconds_Mod' => 'string',
            'transaction_fees_Mod' => 'required|integer',
            'transaction_reference_Mod'=> 'required|string'
        ];

        $validator = Validator::make((array)$input, $rules);

        if ($validator->fails()) {

            foreach($validator->errors()->all() as $error){

                $response->message = "\n".$response->message.$error."\n";

            }

        } else {

            $deposit->update([
                'amount' =>  (isset($input['amount_Mod'])) ? $input['amount_Mod'] : $deposit->amount,
                'channel' => (isset($input['channel_Mod'])) ? $input['channel_Mod'] : $deposit->channel,
                'customer_id' => (isset($input['customer_id_Mod'])) ? $input['customer_id_Mod'] : $deposit->customer_id,
                'deposit_date' => (isset($input['deposit_date_Mod'])) ? $input['deposit_date_Mod'] : $deposit->deposit_date,
                'gameTransactionId' => (isset($input['gameTransactionId_Mod'])) ? $input['gameTransactionId_Mod'] : $deposit->gameTransactionId,
                'gateway' => (isset($input['gateway_Mod'])) ? $input['gateway_Mod'] : $deposit->gateway,
                'paid_at' => (isset($input['paid_at_Mod'])) ? $input['paid_at_Mod'] : $deposit->paid_at,
                'playerId' => (isset($input['playerId_Mod'])) ? $input['playerId_Mod'] : $deposit->playerId,
                'refId' => (isset($input['refId_Mod'])) ? $input['refId_Mod'] : $deposit->refId,
                'status' => (isset($input['status_Mod'])) ? $input['status_Mod'] : $deposit->status,
                'transaction_fees' => (isset($input['transaction_fees_Mod'])) ? $input['transaction_fees_Mod'] : $deposit->transaction_fees,
                'transaction_reference'=> (isset($input['transaction_reference_Mod'])) ? $input['transaction_reference_Mod'] : $deposit->transaction_reference

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


        $deposit = Deposit::find($id);

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
