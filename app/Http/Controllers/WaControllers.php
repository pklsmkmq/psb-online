<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\KelulusanController;
use env;

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

    public function wablas($hp, $message)
    {
        // $curl = curl_init("https://jogja.wablas.com");
        $url = "https://jogja.wablas.com/api/send-message";
        $token = env('TOKEN_WA_BLAS');
        if (substr($hp, 0, 1) == "0") {
            $hp = "62" + substr($hp, 1);
        } else if(substr($hp, 0, 1) == "+62"){
            $hp = substr($hp, 1);
        }

        $postInput = [
            'phone' => $hp,
            'message' => $message
        ];

        $headers = [
            "Authorization" => $token,
            "Content-Type" => "application/json"
        ];

        $response = Http::withHeaders($headers)->post($url, $postInput);

        $statusCode = $response->status();
        $responseBody = json_decode($response->getBody(), true);

        echo $statusCode;  // status code

        dd($responseBody);
    }

    public function nyobaWa()
    {
        $hp = "6287851258850";
        $nama = "Nur";
        $message = "*Chat Otomatis PPDB SMK MQ (Jangan Dibalas)*
 بِسْمِ اللَّهِ
Pengumuman PPDB SMK MADINATULQURAN
Tahun Pelajaran 2022/2023

Berdasarkan Hasil tes dan wawancara yang telah dilaksanakan maka dengan ini kami menyatakan bahwa santri atas Nama $nama dinyatakan :

                        *LULUS*

Untuk tahapan selanjutnya, wali santri bisa langsung melakukan pembayaran ke rekening di bawah ini sejumlah *Rp. 18.500.000* (Delapan Belas Juta Lima Ratus Ribu Rupiah). Berikut ini nomor rekeningnya:
Nomor Rekening : 3310006100
Kode Bank : (147) Bank Muamalat
Atas Nama : Yayasan Wisata Al Islam

Untuk pembayaran dapat di bayar secara tunai ataupun dicicil. berikut ini adalah tahapan pembayarannya:
Tahap 1 - Rp. 5.000.000
Tahap 2 - Rp. 5.000.000
Tahap 3 - Rp. 5.000.000
Tahap 4 - Rp. 3.500.000

Jika sudah melakukan pembayaran silahkan mengupload bukti pembayaran di menu Pembayaran pada website atau bisa klik link ini https://ppdb.smkmadinatulquran.sch.id/ppdb/pembayaran

Jika ada pertanyaan hubungi CS kami
085888222457 (Ustadz Dedi)
081311868066 (Ustadz Patjri)

Barakallahu fiikum
Hormat kami,


Panitia PPDB SMK MADINATULQURAN";

        $whatsapp = $this->wablas($hp, $message);

        // if ($result) {
        //     echo "oke";
        // }else{
        //     echo "gagal";
        // }
    }

    public function bla()
    {
        $data = new KelulusanController();
        return $data->fxas();
    }
}