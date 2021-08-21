<?php

namespace App\Http\Controllers;

use App\Models\calonSiswa;
use Illuminate\Http\Request;
use Validator;

class CalonSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->keywords;
        $request->page;
        $request->role;
        $users = calonSiswa::where('name_siswa', 'like', '%'.strtolower($request->keywords)."%")->orderBy("created_at", 'desc')->paginate($request->perpage, [
            'calon_siswa.nik_siswa',
            'calon_siswa.name_siswa',
            'calon_siswa.user_id',
            'calon_siswa.tempat_lahir_siswa',
            'calon_siswa.tanggal_lahir_siswa',
            'calon_siswa.jenis_kelamin',
            'calon_siswa.agama',
            'calon_siswa.golongan_darah',
            'calon_siswa.alamat_siswa',
            'calon_siswa.nomor_telepon_siswa',
            'calon_siswa.pihak_yg_dihubungi',
            'calon_siswa.tinggi_badan',
            'calon_siswa.berat_badan',
            'calon_siswa.ukuran_baju',
            'calon_siswa.cita_cita',
        ]);

        return response()->json([
            'status' => 'success',
            'perpage' => $request->perpage,
            'role' => $request->role,
            'message' => 'sukses menampilkan data',
            'data' => $users 
        ]);
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
    public function store(Request $request)
    {
        $rules = array(
            'nik_siswa' => 'required|numeric|unique:calon_siswa,nik_siswa',
            'name_siswa' => 'required|string|max:255',
            'user_id' => 'required|unique:calon_siswa,user_id',
            'tempat_lahir_siswa' => 'required|string|max:255',
            'tanggal_lahir_siswa' => 'required',
            'jenis_kelamin' => 'string|max:30',
            'agama' => 'required|string|max:30',
            'golongan_darah' => 'string|max:2',
            'alamat_siswa' => 'required|string',
            'nomor_telepon_siswa' => 'required',
            'pihak_yg_dihubungi' => 'required|string|max:30',
            'tinggi_badan' => 'integer',
            'berat_badan' => 'integer',
            'ukuran_baju' => 'string|max:30',
            'cita_cita' => 'string|max:30',
        );

        $cek = Validator::make($request->all(),$rules);

        if($cek->fails()){
            $errorString = implode(",",$cek->messages()->all());
            return response()->json([
                'message' => $errorString
            ], 401);
        }else{
            $time = strtotime($request->tanggal_lahir_siswa);
            $tanggal = date('Y-m-d',$time);
            $calonSiswa = calonSiswa::create([
                'nik_siswa' => $request->nik_siswa,
                'name_siswa' => $request->name_siswa,
                'user_id' => $request->user_id,
                'tempat_lahir_siswa' => $request->tempat_lahir_siswa,
                'tanggal_lahir_siswa' => $tanggal,
                'jenis_kelamin' => $request->jenis_kelamin,
                'agama' => $request->agama,
                'golongan_darah' => $request->golongan_darah,
                'alamat_siswa' => $request->alamat_siswa,
                'nomor_telepon_siswa' => $request->nomor_telepon_siswa,
                'pihak_yg_dihubungi' => $request->pihak_yg_dihubungi,
                'tinggi_badan' => $request->tinggi_badan,
                'berat_badan' => $request->berat_badan,
                'ukuran_baju' => $request->ukuran_baju,
                'cita_cita' => $request->cita_cita,
            ]);
    
            return response()->json([
                "status" => "success",
                "message" => 'Berhasil Menyimpan Data'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\calonSiswa  $calonSiswa
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $siswa = calonSiswa::where('nik_siswa', $id)->first(); 

        return response()->json([
            'status' => 'success',
            'message' => 'sukses menampilkan data',
            'data' => $siswa
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\calonSiswa  $calonSiswa
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $siswa = calonSiswa::where('nik_siswa', $id)->first(); 

        return response()->json([
            'status' => 'success',
            'message' => 'sukses menampilkan data',
            'data' => $siswa
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\calonSiswa  $calonSiswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = array(
            'name_siswa' => 'required|string|max:255',
            'tempat_lahir_siswa' => 'required|string|max:255',
            'tanggal_lahir_siswa' => 'required',
            'jenis_kelamin' => 'string|max:30',
            'agama' => 'required|string|max:30',
            'golongan_darah' => 'string|max:2',
            'alamat_siswa' => 'required|string',
            'nomor_telepon_siswa' => 'required',
            'pihak_yg_dihubungi' => 'required|string|max:30',
            'tinggi_badan' => 'integer',
            'berat_badan' => 'integer',
            'ukuran_baju' => 'string|max:30',
            'cita_cita' => 'string|max:30',
        );

        $cek = Validator::make($request->all(),$rules);

        if($cek->fails()){
            $errorString = implode(",",$cek->messages()->all());
            return response()->json([
                'message' => $errorString
            ], 401);
        }else{
            $time = strtotime($request->tanggal_lahir_siswa);
            $tanggal = date('Y-m-d',$time);
            $calonSiswa = calonSiswa::where('nik_siswa',$id)->first();
            $calonSiswa->name_siswa = $request->name_siswa;
            $calonSiswa->user_id = $request->user_id;
            $calonSiswa->tempat_lahir_siswa = $request->tempat_lahir_siswa;
            $calonSiswa->tanggal_lahir_siswa = $tanggal;
            $calonSiswa->jenis_kelamin = $request->jenis_kelamin;
            $calonSiswa->agama = $request->agama;
            $calonSiswa->golongan_darah = $request->golongan_darah;
            $calonSiswa->alamat_siswa = $request->alamat_siswa;
            $calonSiswa->nomor_telepon_siswa = $request->nomor_telepon_siswa;
            $calonSiswa->pihak_yg_dihubungi = $request->pihak_yg_dihubungi;
            $calonSiswa->tinggi_badan = $request->tinggi_badan;
            $calonSiswa->berat_badan = $request->berat_badan;
            $calonSiswa->ukuran_baju = $request->ukuran_baju;
            $calonSiswa->cita_cita = $request->cita_cita;
    
            if($calonSiswa->save()){
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\calonSiswa  $calonSiswa
     * @return \Illuminate\Http\Response
     */

    public function destroy(Request $request)
    {
        try {
           for($i = 0 ; $i < count($request->nik_siswa) ; $i++){
            
            $delete = calonSiswa::find($request->nik_siswa[$i]);
            $delete -> delete();
           }
           return response()->json([
            "status" => "success",
            "message" => 'Berhasil Menghapus Data'
           ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                "status" => "failed",
                "message" => 'NIK Siswa tidak ditemukan'
            ]);
        }
    }
}
