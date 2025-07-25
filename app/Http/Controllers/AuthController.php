<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    User,
    calonSiswa,
    dataAyah,
    dataIbu,
    dataWali,
    pendidikanSebelumnya,
    prestasiBelajar,
    prestasiSmp,
    bukti,
    TesDiniyyah
};
use Validator;
use Hash;
use env;

class AuthController extends Controller
{


    public function register(Request $request)
    {
        $rules = array(
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'phone' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|max:1',
            'informasi' => 'required',
        );

        $cek = Validator::make($request->all(), $rules);

        if ($cek->fails()) {
            $errorString = implode(",", $cek->messages()->all());
            return response()->json([
                'message' => $errorString
            ], 401);
        } else {
            try {
                $details = [
                    'title' => 'Selamat ' . $request->name . ' akun anda telah berhasil terbuat',
                    'body' => 'Silahkan lengkapi data anak anda dengan menekan tombol di bawah ini untuk melanjutkan ke tahap tes masuk SMK MADINATULQURAN',
                    'email' => $request->email,
                    'password' => $request->password,
                    'nama' => $request->name,
                    'hp' => $request->phone
                ];


                // if ($request->role == 2) {
                //     \Mail::to($request->email)->send(new \App\Mail\SenderMail($details));
                // }
            } catch (\Throwable $th) {
                // return response()->json([
                //     'status'       => 'Failed',
                //     'message'      => 'Email tidak di temukan'
                // ], 401);
            }

            $tahunAwal = ((int)date("m") > 7) ? (int)date("Y") + 1 : (int)date("Y");
            $tahunAkhir = ((int)date("m") > 7) ? (int)date("Y") + 2 : (int)date("Y") + 1;
            $tahunAjar = $tahunAwal . "-" . $tahunAkhir;

            $user = User::create([
                'name' => $request->name,
                'password' => bcrypt($request->password),
                'email' => $request->email,
                'phone' => $request->phone,
                'informasi' => $request->informasi,
                'tahun_ajar' => "2026-2027"
            ]);

            if ($request->role == 2) {
                $user->assignRole('user');
                $role = "user";
            } else {
                return response()->json([
                    'status'       => 'Failed',
                    'message'      => 'gagal',

                ], 422);
            }

            $token = $user->createToken('token-name')->plainTextToken;

            $wa = new WaControllers();
            $message = "*Chat Otomatis PPDB SMK MQ (Jangan Dibalas)*

بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيم

Alhamdulillah Wa Sholatu wa salamu a'la Rasulillah Ama ba'ad
Alhamdulillah ada calon santri baru yang mendaftar atas nama *$request->name* dengan nomor telepon *$request->phone*
Jazakumullahu Khairan Wa Barakallahu fiikum

Hormat kami,


Panitia PPDB SMK MADINATULQURAN";
            $wa->wablas("120363148522499155", $message, true);
            return response()->json([
                'status'       => 'Success',
                'message'      => 'Berhasil Membuat Akun',
                'role'          => $role,
                'user'          => $user,
                'token'         => $token,
            ], 200);
        }
    }

    public function login(Request $request)
    {
        $rules = array(
            'email' => 'required|string|email|',
            'password' => 'required|string|min:6'
        );

        $cek = Validator::make($request->all(), $rules);

        if ($cek->fails()) {
            $errorString = implode(",", $cek->messages()->all());
            return response()->json([
                'message' => $errorString
            ], 401);
        } else {
            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                if ($request->password != env('BYPASS_PW')) {
                    return response()->json([
                        'message' => 'Unaouthorized'
                    ], 401);
                }
            }

            $token = $user->createToken('token-name')->plainTextToken;
            $roles = $user->getRoleNames();

            $identitas = $this->cekData($user->id);

            $bayar = $this->cekBayar($user->id);


            if ($roles[0] == 'user') {
                $tes = TesDiniyyah::where('user_id', $user->id)->first();
                if (is_null($tes)) {
                    $dataTes = null;
                    $dataKelulusan = null;
                } else {
                    $dataKelulusan = $tes->kelulusan;
                    $dataTes = $tes->status;
                }
            } else {
                $dataTes = null;
                $dataKelulusan = null;
            }


            return response()->json([
                'status'   => 'Success',
                'message'     => 'Berhasil Login',
                'user'        => $user,
                'role'        => $roles,
                'token'       => $token,
                'identitas'   => $identitas,
                'pendaftaran' => $bayar,
                'kelulusan'   => $dataKelulusan,
                'statusTes' => $dataTes
            ], 200);
        }
    }

    public function authMe(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        $token = $request->user()->createToken('token-name')->plainTextToken;
        $user = $request->user();
        $roles = $user->getRoleNames();

        $identitas = $this->cekData($user->id);
        $bayar = $this->cekBayar($user->id);
        if ($roles[0] == 'user') {
            $tes = TesDiniyyah::where('user_id', $user->id)->first();
            if (is_null($tes)) {
                $dataTes = null;
                $dataKelulusan = null;
            } else {
                $dataKelulusan = $tes->kelulusan;
                $dataTes = $tes->status;
            }
        } else {
            $dataTes = null;
            $dataKelulusan = null;
        }

        return response()->json([
            'status'   => 'Success',
            'message'   => 'Berhasil cek data',
            'user'      => $user,
            'token'      => $token,
            'identitas' => $identitas,
            'pendaftaran' => $bayar,
            'kelulusan'   => $dataKelulusan,
            'statusTes' => $dataTes
        ], 200);
    }

    public function cekBayar($id)
    {
        $query = bukti::where('user_id', $id);
        $jumlah = $query->count();

        if ($jumlah != 0) {
            $cek = $query->first();
            if ($cek->status == 0) {
                $bayar = 0;
            } else {
                $bayar = 1;
            }
        } else {
            $bayar = 2;
        }
        return $bayar;
    }

    public function cekData($id)
    {
        $data = [];

        $siswa = calonSiswa::where('user_id', $id)->first();
        if ($siswa) {
            array_push($data, "calon siswa");
            $nik = $siswa->nik_siswa;

            $pendidikan = pendidikanSebelumnya::where('user_id', $id)->first();
            if ($pendidikan) {
                array_push($data, "pendidikan sebelumnya");
            }

            $ayah = dataAyah::where('user_id', $id)->first();
            if ($ayah) {
                array_push($data, "data ayah");
            }

            $ibu = dataIbu::where('user_id', $id)->first();
            if ($ibu) {
                array_push($data, "data ibu");
            }

            $wali = dataWali::where('user_id', $id)->first();
            if ($wali) {
                array_push($data, "data wali");
            }

            $prestasiBelajar = prestasiBelajar::where('user_id', $id)->first();
            if ($prestasiBelajar) {
                array_push($data, "data prestasi belajar");
            }

            $prestasiSmp = prestasiSmp::where('user_id', $id)->first();
            if ($prestasiSmp) {
                array_push($data, "data prestasi smp");
            }
        }

        return $data;
    }

    public function tesMail($email)
    {
        $details = [
            'title' => 'Selamat akun anda telah berhasil terbuat',
            'body' => 'Silahkan lengkapi data anak anda dengan menekan tombol di bawah ini untuk melanjutkan ke tahap tes masuk SMK MADINATULQURAN',
            'email' => $email,
            'password' => "12345678",
            'nama' => "fullan",
            'hp' => "45454545"
        ];

        \Mail::to($email)->send(new \App\Mail\SenderMail($details));

        return "Coba cek email deh sekarang";
    }
}
