<?php

namespace App\Http\Controllers;

use App\Models\TesDiniyyah;
use App\Models\calonSiswa;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\WaControllers;
use Auth;
use Validator;
use Carbon\Carbon;

class TesDiniyyahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        {
            $rules = array(
                // 'user_id' => 'unique:tes_diniyyah,user_id',
                'metode' => 'required',
            );
            $id = Auth::user()->id;
            $cek = Validator::make($request->all(),$rules);
            $dtSiswa = calonSiswa::where('user_id',$id)->first();

            if($cek->fails()){
                $errorString = implode(",",$cek->messages()->all());
                return response()->json([
                    'message' => $errorString
                ], 401);
            }else{

                $jadwaltes = TesDiniyyah::create([
                    'user_id' => Auth::user()->id,
                    'tanggal' => $request->tanggal,
                    'metode' => $request->metode,
                    'status' => 0,
                    'jadwal_ulang' => 0,
                    'catatan' => $request->catatan,
                    'is_batal' => false
                ]);

                if ($request->metode == 1) {
                    $namaMetode = "Offline";
                } else {
                    $namaMetode = "Online";
                }


                // $details = [
                //     'name' => Auth::user()->name,
                //     'bukti' => $response
                // ];

                // \Mail::to("psbsmkmq@gmail.com")->send(new \App\Mail\BayarMail($details));
                $wa = new WaControllers();
                $message = "*Chat Otomatis PPDB SMK MQ (Jangan Dibalas)*

 بِسْمِ اللَّهِ

Ada yang ingin melakukan tes, berikut detailnya
Nama : $dtSiswa->name_siswa
Tanggal : $request->tanggal
Metode : $namaMetode
Catatan : $request->catatan

Untuk detailnya cek kembali website PPDB SMK MadinatulQuran
Barakallahu fiikum
Hormat kami,


Panitia PPDB SMK MADINATULQURAN";
                $wa->wablas("120363148522499155",$message, true);
                return response()->json([
                    "status" => "success",
                    "message" => 'Berhasil Menyimpan Data'
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TesDiniyyah  $tesDiniyyah
     * @return \Illuminate\Http\Response
     */
    public function show(TesDiniyyah $tesDiniyyah)
    {
       //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TesDiniyyah  $tesDiniyyah
     * @return \Illuminate\Http\Response
     */
    public function edit(TesDiniyyah $tesDiniyyah)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TesDiniyyah  $tesDiniyyah
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TesDiniyyah $tesDiniyyah)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TesDiniyyah  $tesDiniyyah
     * @return \Illuminate\Http\Response
     */
    public function destroy(TesDiniyyah $tesDiniyyah)
    {
        //
    }

    public function tesSaya(Request $request){

        $tes = TesDiniyyah::where('user_id', Auth::user()->id)->orderBy('id','DESC')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'sukses menampilkan data',
            'data' => $tes
        ]);
    }

    public function updateStatusTes(Request $request)
    {


        $rules = array(
            'status' => 'required',
            'laporan' => 'required',
        );
        $cek = Validator::make($request->all(),$rules);

        if($cek->fails()){
            $errorString = implode(",",$cek->messages()->all());
            return response()->json([
                'message' => $errorString
            ], 401);
        }else{
            $data = TesDiniyyah::where('user_id',$request->id)->first();
            $data->status = $request->status;
            $data->laporan = $request->laporan;
            $data->approved_by = Auth::user()->id;

            if($data->save()){
                return response()->json([
                    "status" => "success",
                    "message" => 'Berhasil Menyimpan Data'
                ]);
            }else{
                return response()->json([
                    "status" => "failed",
                    "message" => 'Gagal Menyimpan Data'
                ]);
            }
        }
    }

    public function updateKelulusan(Request $request, $id)
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

        $rules = array(
            'kelulusan' => 'required'
        );
        $cek = Validator::make($request->all(),$rules);

        if($cek->fails()){
            $errorString = implode(",",$cek->messages()->all());
            return response()->json([
                'message' => $errorString
            ], 401);
        }else{
            $data = TesDiniyyah::where('user_id',$id)->first();
            $data->kelulusan = $request->kelulusan;

            if($data->save()){
                if ($request->kelulusan == 1) {
                    $dtSiswa = calonSiswa::where('user_id',$id)->first();
                    $dtUser = User::where('id',$id)->first();
                    try {
                        $details = [
                            'name' => $dtSiswa->name_siswa,
                        ];
                        // Send Email
                        \Mail::to($dtUser->email)->send(new \App\Mail\kelulusan($details));

                        // Send WA
                        $wa = new WaControllers();
                        $message = "*Chat Otomatis PPDB SMK MQ (Jangan Dibalas)*
 بِسْمِ اللَّهِ
Pengumuman PPDB SMK MADINATULQURAN
Tahun Pelajaran 2025/2026

Berdasarkan Hasil tes dan wawancara yang telah dilaksanakan maka dengan ini kami menyatakan bahwa santri atas Nama $dtSiswa->name_siswa dinyatakan :

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
                        $wa->wablas($dtUser->phone,$message, false);
                    } catch (\Throwable $th) {
                        return response()->json([
                            'status'       => 'Failed',
                            'message'      => 'Email tidak di temukan'
                        ], 401);
                    }
                }

                return response()->json([
                    "status" => "success",
                    "message" => 'Berhasil Menyimpan Data'
                ]);
            }else{
                return response()->json([
                    "status" => "failed",
                    "message" => 'Gagal Menyimpan Data'
                ]);
            }
        }
    }

    public function jamTes(Request $request){

        $rules = array(
            'jam' => 'required',

        );
        $cek = Validator::make($request->all(),$rules);
        $user = User::find(Auth::user()->id);

        if($cek->fails()){
            $errorString = implode(",",$cek->messages()->all());
            return response()->json([
                'message' => $errorString
            ], 401);
        }else{
            $data = TesDiniyyah::where('user_id',$request->id)->first();

            $data->jam_tes = $request->jam;
            $data->dibuat_oleh = $user->name;


            if($data->save()){
                $dtTes = TesDiniyyah::where('user_id',$request->id)->first();
                $dtUser = User::where('id',$request->id)->first();
                $siswa  = calonSiswa::where('user_id',$request->id)->first();
                try {
                    $details = [
                        'tanggal' => $dtTes->tanggal,
                        'name' => $siswa->name_siswa,
                        'metode' => 'Online',
                        'jam_tes' => $dtTes->jam_tes,
                    ];
                    \Mail::to($dtUser->email)->send(new \App\Mail\konfirmasites($details));
                } catch (\Throwable $th) {
                    return response()->json([
                        'status'       => 'Failed',
                        'message'      => 'Email tidak di temukan'
                    ], 401);
                }
                return response()->json([
                    "status" => "success",
                    "message" => 'Berhasil Menyimpan Data'
                ]);
            }else{
                return response()->json([
                    "status" => "failed",
                    "message" => 'Gagal Menyimpan Data'
                ]);
            }
        }
    }

    public function batalTes(Request $request, $id)
    {
        $rules = array(
            'keterangan_batal' => 'required'
        );
        $cek = Validator::make($request->all(),$rules);

        if($cek->fails()){
            $errorString = implode(",",$cek->messages()->all());
            return response()->json([
                "status" => "failed",
                'message' => $errorString
            ], 401);
        }else{
            $data = TesDiniyyah::where('user_id',$id)->first();
            $data->is_batal = true;
            $data->keterangan_batal = $request->keterangan_batal;

            if($data->save()){
                return response()->json([
                    "status" => "success",
                    "message" => 'Berhasil Menyimpan Data'
                ]);
            }else{
                return response()->json([
                    "status" => "failed",
                    "message" => 'Gagal Menyimpan Data'
                ]);
            }
        }
    }
}
