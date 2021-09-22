<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Midtrans\{
    Config,
    CoreApi
};

class PaymentController extends Controller
{
    public function __construct()
    {
        //
    }

    public function testPayment(Request $req)
    {
        try {
            $transaction = array(
                "payment_type" => "bank_transfer",
                "transaction_details" => [
                    "gross_amount" => 10000,
                    "order_id" => date('Y-m-dHis')
                ],
                "customer_details" => [
                    "email" => "budi.utomo@Midtrans.com",
                    "first_name" => "budi",
                    "last_name" => "utomo",
                    "phone" => "+6281 1234 1234"
                ],
                "item_details" => array([
                    "id" => "1388998298204",
                    "price" => 5000,
                    "quantity" => 1,
                    "name" => "Ayam Zozozo"
                ],[
                    "id" => "1388998298203",
                    "price" => 5000,
                    "quantity" => 1,
                    "name" => "Ayam xoxoxo"
                ]),
                "bank_transfer" => [
                    "bank" => "bca",
                    "va_number" => "111111",
                ]
            );

            $charge = CoreApi::charge($transaction);
            if (!$charge) {
                return [
                    'code' => 0,
                    'message' => 'Terjadi Kesalahan'
                ];
            }

            return [
                'code' => 1,
                'message' => 'Success',
                'result' => $charge
            ];
        } catch (\Throwable $th) {
            return [
                'code' => 0,
                'message' => 'Terjadi Kesalahan'
            ];
        }
    }
}
