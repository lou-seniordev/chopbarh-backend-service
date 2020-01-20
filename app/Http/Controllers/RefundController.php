<?php

namespace App\Http\Controllers;

use App\Models\Refund;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class RefundController extends Controller
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
        $refunds = DB::table('refunds')->paginate(50);

        print_r(json_encode($refunds));
    }

    public function search(Request $request)
    {
        $input = $request->json()->all();
        $query = $input['query'];

        $deposits = DB::table('refunds')->where('playerId', 'like', '%'.$query.'%')
            ->orWhere('amount','LIKE','%'.$query.'%')
            ->orWhere('bank','LIKE','%'.$query.'%')
            ->orWhere('status','LIKE','%'.$query.'%')
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
            'bank' => 'required|string',
            'gameTransactionId' => 'required|string',
            'paid_at' => 'required|string',
            'refund_date' => 'required|string',
            'status' => 'required|string',
            'time_seconds' => 'required|string',
            'time_nanoseconds' => 'required|string',
            'transaction_reference'=> 'required|string',
        ];


        $validator = Validator::make((array)$input, $rules);

        if ($validator->fails()) {

            foreach($validator->errors()->all() as $error){

                $response->message = $response->message.$error."\n";

            }

        }else {

            $refund = Refund::create([
                'id' => $request['id'],
                'playerId' => $request['playerId'],
                'amount' => $request['amount'],
                'bank' => $request['bank'],
                'gameTransactionId' => $request['gameTransactionId'],
                'paid_at' => $request['paid_at'],
                'refund_date' => $request['refund_date'],
                'status' => $request['status'],
                'time_seconds' => $request['time_seconds'],
                'time_nanoseconds' => $request['time_nanoseconds'],
                'transaction_reference'=> $request['transaction_reference']
            ]);


            $response->id = 1;
            $response->message = "New refund done.";

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

        $refund = Refund::find($id);


        $rules = [
            'amount_Mod' => 'required|string',
            'bank_Mod' => 'required|string',
            'gameTransactionId_Mod' => 'required|string',
            'paid_at_Mod' => 'required|string',
            'playerId_Mod' => 'required|string',
            'refund_date_Mod' => 'required|string',
            'status_Mod' => 'required|string',
            'time_Mod' => 'required|datetime',
            'transaction_reference_Mod'=> 'required|string'
        ];

        $validator = Validator::make((array)$request->all(), $rules);

        if ($validator->fails()) {

            foreach($validator->errors()->all() as $error){

                $response->message = "\n".$response->message.$error."\n";

            }

        } else {

            $refund->update([
                'amount' =>  (isset($request->amount_Mod)) ? $request->amount_Mod : $refund->amount,
                'bank' => (isset($request->bank_Mod)) ? $request->bank_Mod : $refund->bank,
                'gameTransactionId' => (isset($request->gameTransactionId_Mod)) ? $request->gameTransactionId_Mod : $refund->gameTransactionId,
                'paid_at' => (isset($request->paid_at_Mod)) ? $request->paid_at_Mod : $refund->paid_at,
                'playerId' => (isset($request->playerId_Mod)) ? $request->playerId_Mod : $refund->playerId,
                'refund_date' => (isset($request->refund_date_Mod)) ? $request->refund_date_Mod : $refund->refund_date,
                'status' => (isset($request->status_Mod)) ? $request->status_Mod : $refund->status,
                'time' => (isset($request->time_Mod)) ? $request->time_Mod : $refund->time,
                'transaction_reference'=> (isset($request->transaction_reference_Mod)) ? $request->transaction_reference_Mod : $refund->transaction_reference,
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


        $refund = Refund::find($id);

        DB::beginTransaction();

        try{


            $refund->delete();

            $response = (Object)[
                'id' => 1,
                'type' => "success",
                'title' => "Reussite !!!",
                'message' => "Refund deleted."
            ];

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();
            $response->message = $e->getMessage();

        }


        echo json_encode($response);
    }
}
