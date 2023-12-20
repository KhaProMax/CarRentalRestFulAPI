<?php

namespace App\Http\Controllers\Stripe;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use Illuminate\Http\Request;
use Stripe\Stripe;

class StripeController extends Controller
{
    //
    public function session(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $LICENSE_PLATE = $request->get('LICENSE_PLATE');
        $price = $request->get('price');
        $buyer_id = $request->get('buyer_id');

        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $res = $stripe->tokens->create([
            'card' => [
                'number' => $request->number,
                'exp_month' => $request->exp_month,
                'exp_year' => $request->exp_year,
                'cvc' => $request->cvc,
            ],
        ]);

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $response = $stripe->charges->create([
            'amount' => $price,
            'currency' => 'usd',
            'source' => $res->id,
        ]);

        $rules = [
            'USER_ID' => 'required|string',
            'LICENSE_PLATE' => 'required|string',
            'START_DATE' => 'required|date|after_or_equal:now',
            'END_DATE' => 'required|date|after_or_equal:START_DATE',
            'PRICE' => 'required',
            'DEPOSIT_STATUS' => 'string|in:Y,N',
            'RETURN_STATUS' => 'string|in:Y,N'
        ];

        $request->validate($rules);

        $data['USER_ID'] = $buyer_id;
        $data['LICENSE_PLATE'] = $LICENSE_PLATE;
        $data['PRICE'] = $price;
        $data['START_DATE'] = $start_date;
        $data['END_DATE'] = $end_date;
        $data['DEPOSIT_STATUS'] = 'Y';
        $data['RETURN_STATUS'] = 'N';
        $data['CONTRACT_ID'] = Contract::generateUniqueId();

        $contract = Contract::create($data);

        return response()->json(['message' => $response->status, 'data' => $contract, 'statusCode' => 201], 201);
    }
}
