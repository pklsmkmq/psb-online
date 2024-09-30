<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\KelulusanController;
use App\Models\calonSiswa;
use env;
use Carbon\Carbon;

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

    public function wablas($hp, $message, $isGrup)
    {
        // $curl = curl_init("https://jogja.wablas.com");
        $url = "https://jogja.wablas.com/api/send-message";
        $token = env('TOKEN_WA_BLAS');
        $hpFix = $hp;
        $hpFix2 = $hp;
        if ($isGrup) {
            $postInput = [
                'phone' => $hp,
                'message' => $message,
                'isGroup' => true
            ];
        } else {
            if (str_contains($hpFix, ",")) {
                $arrayHp = explode(",",$hpFix);
                $hpp = "";
                for ($i=0; $i < count($arrayHp); $i++) {
                    $nomor = $arrayHp[$i];
                    if (substr($nomor, 0, 1) == "0") {
                        if ($hpp == "") {
                            $hpp = "62" . substr($arrayHp[$i], 1);
                        } else {
                            $hpp = $hpp . "," . "62" . substr($arrayHp[$i], 1);
                        }
                    } else if(substr($nomor, 0, 3) == "+62"){
                        if ($hpp == "") {
                            $hpp = substr($arrayHp[$i], 1);
                        } else {
                            $hpp = $hpp . "," . substr($arrayHp[$i], 1);
                        }
                    }
                }
                $hp = $hpp;
            } else {
                if (substr($hpFix, 0, 1) == "0") {
                    $hp = "62" . substr($hp, 1);
                } else if(substr($hpFix2, 0, 3) == "+62"){
                    $hp = substr($hp, 1);
                }
            }

            $postInput = [
                'phone' => $hp,
                'message' => $message
            ];
        }

        $headers = [
            "Authorization" => $token,
            "Content-Type" => "application/json"
        ];

        $response = Http::withHeaders($headers)->post($url, $postInput);

        $statusCode = $response->status();
        $responseBody = json_decode($response->getBody(), true);

        // echo $statusCode;  // status code

        // dd($responseBody);
    }

    public function nyobaWa()
    {
        $currentMonth = Carbon::now()->month;

        // Inisialisasi variabel
        $totalHarga = "";
        $nominal = "";
        $tahap1 = "";
        $tahap2 = "";
        $tahap3 = "";
        $tahap4 = "";

        // Logika berdasarkan bulan
        if ($currentMonth >= 8 && $currentMonth <= 12) {
            // Agustus - Desember
            $totalHarga = "Rp. 14.500.000";
            $nominal = "Empat Belas Juta Lima Ratus Ribu Rupiah";
            $tahap1 = "Rp. 5.000.000";
            $tahap2 = "Rp. 5.000.000";
            $tahap3 = "Rp. 4.500.000";
            $tahap4 = "";
        } elseif ($currentMonth >= 1 && $currentMonth <= 3) {
            // Januari - Maret
            $totalHarga = "Rp. 16.500.000";
            $nominal = "Enam Belas Juta Lima Ratus Ribu Rupiah";
            $tahap1 = "Rp. 5.000.000";
            $tahap2 = "Rp. 5.000.000";
            $tahap3 = "Rp. 5.000.000";
            $tahap4 = "Tahap 4 - Rp. 1.500.000";
        } elseif ($currentMonth >= 4 && $currentMonth <= 6) {
            // April - Juni
            $totalHarga = "Rp. 18.500.000";
            $nominal = "Delapan Belas Juta Lima Ratus Ribu Rupiah";
            $tahap1 = "Rp. 5.000.000";
            $tahap2 = "Rp. 5.000.000";
            $tahap3 = "Rp. 5.000.000";
            $tahap4 = "Tahap 4 - Rp. 3.500.000";
        }

        $hp = "6285794120637";
        $nama = "Nur";
        $message = "*Chat Otomatis PPDB SMK MQ (Jangan Dibalas)*
 بِسْمِ اللَّهِ
Pengumuman PPDB SMK MADINATULQURAN
Tahun Pelajaran 2025/2026

Berdasarkan Hasil tes dan wawancara yang telah dilaksanakan maka dengan ini kami menyatakan bahwa santri atas Nama $nama dinyatakan :

                        *LULUS*

Untuk tahapan selanjutnya, wali santri bisa langsung melakukan pembayaran ke rekening di bawah ini sejumlah *$totalHarga* ($nominal). Berikut ini nomor rekeningnya:
Nomor Rekening : 3310006100
Kode Bank : (147) Bank Muamalat
Atas Nama : Ponpes Madinatulquran (Yayasan Wisata Al Islam)

Untuk pembayaran dapat di bayar secara tunai ataupun dicicil. berikut ini adalah tahapan pembayarannya:
Tahap 1 - $tahap1
Tahap 2 - $tahap2
Tahap 3 - $tahap3
$tahap4

Jika sudah melakukan pembayaran silahkan mengupload bukti pembayaran di menu Pembayaran pada website atau bisa klik link ini https://ppdb.smkmadinatulquran.sch.id/ppdb/pembayaran

Jika ada pertanyaan hubungi CS kami
082113165990 (Ustadz Raihan)
0895320050324 (Ustadz Ihsan)

Barakallahu fiikum
Hormat kami,


Panitia PPDB SMK MADINATULQURAN";

        $whatsapp = $this->wablas($hp, $message, false);

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

    public function tesGrup()
    {
        $message = "Testing from waBlas iTCorps";
        // $this->wablas("6285720470284-1628656923", $message, true);
        $this->wablas("120363148522499155", $message, true); //24/25
    }

    public function wa1()
    {
        $this->wablas("085794120637","Bismillah", false);
        return response()->json([
                "status" => "success",
                "message" => 'Berhasil Mengirim WA BLAST Kouta'
            ]);
    }

    public function blasKouta(Request $request)
    {
        $message = "Bismillahirrahmanirrahim,SEAT KUOTA MASIH ADA...!!!
Pendaftaran Penerimaan Peserta Didik Baru (PPDB) TA. 2025/2026 SMK MADINATUL QURAN khusus untuk Ikhwan.
Program Unggulan :
📘 English & Tahfidz Camp
Program Pendidikan :
🕌 Diniyah & Umum
💻 Teknik Komputer & Jaringan (TKJ)
💻 Rekayasa Perangkat Lunak (RPL)
Keunggulan SMK MQ :
🕌 Pesantren IT Berlandaskan Al quran dan As Sunnah
♻️ Lingkungan yang Asri
📘 Kurikulum Sesuai dengan Perkembangan Industri

Ayoo... DAFTAR SEKARANG juga...!!!,
Mumpung Masih ada SEAT  tersisa...!
🔎 Pendaftaran hanya via Online :
Melalui: https://ppdb.smkmadinatulquran.sch.id
Web : https://smkmadinatulquran.sch.id
Link Brosur: s.id/brosur-smk-mq
NARAHUBUNG / INFORMASI:
SMK MQ Jonggol Ikhwan
PPDB : wa.me/628126900457
Alamat :
Kp.Kebon Kelapa, RT.02/RW.011, Singasari, Kec. Jonggol, Bogor, Jawa Barat 16830";

        // $this->wablas("6287851258850",$message, false);

        $hp = "";

        for ($i=0; $i < count($request->nomorhp); $i++) {
            if ($hp == "") {
                $hp = $request->nomorhp[$i];
            } else {
                $hp = $hp . "," . $request->nomorhp[$i];
            }
        }
        $this->wablas($hp,$message, false);
        return response()->json([
                "status" => "success",
                "message" => 'Berhasil Mengirim WA BLAST Kouta'
            ],200);
    }

    public function sendBikinJadwal(Request $request)
    {
        $message = "*Chat Otomatis PPDB SMK MQ (Jangan Dibalas)*

 بِسْمِ اللَّهِ

Terima kasih telah mendaftar di PPDB Smk Madinatul Quran, Proses pendaftaran tinggal sedikit lagi untuk menjadi santri SMK Madinatul Qur'an. Silahkan jadwalkan tes Diniyah, Umum, dan juga Wawancara pada website https://ppdb.smkmadinatulquran.sch.id

Jika ada pertanyaan hubungi CS kami
082113165990 (Ustadz Raihan)
0895320050324 (Ustadz Ihsan)

Barakallahu fiikum
Hormat kami,


Panitia PPDB SMK MADINATULQURAN";

        try {
            $this->wablas($request->hp,$message, false);
            // echo "tes sehabis jalanin pesan";
            return response()->json([
                "status" => "success",
                "message" => "Berhasil Mengirim Chat Whatsapp"
            ],200);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => "failed",
                "message" => "Gagal Mengirim Chat Whatsapp"
            ],500);
        }

    }

    public function sendKepastian(Request $request)
    {
        $siswa = calonSiswa::where('user_id',$request->user_id)->first();
        $message = "بِسْمِ اللَّهِ

Kami mengucapkan terima kasih atas niat baik dan keinginan mendaftarkan ananda *$siswa->name_siswa* untuk bergabung dalam lingkungan SMK Madinatulquran.Namun, saat ini kami masih belum menemukan bukti pendaftaran.

Kami memahami bahwa mungkin masih ada rasa keraguan dalam memutuskan. Apabila ada pertanyaan atau membutuhkan informasi lebih lanjut tentang SMK Madinatulquran, anda dapat menghubungi Kontak PPDB Di bawah ini.

Terima kasih atas minat dan niat baik anda untuk bergabung dengan kami. Semoga perjalanan ini membawa kebaikan dan manfaat yang berlimpah bagi anda dan keluarga.

Jika ada pertanyaan hubungi CS kami
082113165990 (Ustadz Raihan)
0895320050324 (Ustadz Ihsan)

Barakallahu fiikum
Hormat kami,


Panitia PPDB SMK MADINATULQURAN";

        try {
            $this->wablas($request->hp,$message, false);
            // echo "tes sehabis jalanin pesan";
            return response()->json([
                "status" => "success",
                "message" => "Berhasil Mengirim Chat Whatsapp"
            ],200);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => "failed",
                "message" => "Gagal Mengirim Chat Whatsapp"
            ],500);
        }

    }
}
