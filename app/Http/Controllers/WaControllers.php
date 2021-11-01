<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WaControllers extends Controller
{
    public function sendMassage()
    {
        $data = [
            'phone' => '62895320050324', // Receivers phone
            'body' => 'Tes lagi pak', // Message
        ];
        $json = json_encode($data); // Encode data to JSON
        // URL for request POST /message
        $url = 'https://api.chat-api.com/instance358080/message?token=zj0vzp5j9joxcsgp';
        // Make a POST request
        $options = stream_context_create(['http' => [
                'method'  => 'POST',
                'header'  => 'Content-type: application/json',
                'content' => $json
            ]
        ]);
        // Send a request
        $result = file_get_contents($url, false, $options);

        if ($result) {
            echo "Sukses";
            return $result;
        }else{
            echo "gagal";
        }
    }

    public function wablas()
    {
        $curl = curl_init("https://us.wablas.com");
        $token = "ZNogcV8FuO7hnCIlJT2HZgHeFrZI1Q9ryRGL8d1mzRCQXqTPsYCXa88rr7K3H8JN";

        $payload = [
            "data" => [
                [
                    'phone' => '0895320050324',
                    'message' => 'Message From Wablas',
                    'secret' => false, // or true
                    'priority' => false, // or true
                ],
            ]
        ];

        curl_setopt($curl, CURLOPT_HTTPHEADER,
            array(
                "Authorization: $token",
                "Content-Type: application/json"
            )
        );
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload) );
        curl_setopt($curl, CURLOPT_URL, "https://us.wablas.com/api/v2/send-bulk/text");
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curl);
        curl_close($curl);

        echo "<pre>";
        if ($result) {
            echo "oke";
        }else{
            echo "gagal";
        }
        return $result;
    }
}