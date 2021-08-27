<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Validator;

class PendaftaranController extends Controller
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
        $users = pendaftaran::where('no_pendaftaran', 'like', '%'.strtolower($request->keywords)."%")->orderBy("created_at", 'desc')->paginate($request->perpage, [
            'pendaftaran.no_pendaftaran',
            'pendaftaran.no_peserta',
            'pendaftaran.jadwal_tes',
            'pendaftaran.jenis_tes'
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
            'jadwal_tes => required',
            'jenis_tes => required',
        );

        $cek = Validator::make($request->all(),$rules);

        if($cek->fails()){
            $errorString = implode(",",$cek->messages()->all());
            return response()->json([
                'message' => $errorString
            ], 401);
        }else{
            $jumlah = pendaftaran::count();
            return $jumlah;
            // $time = strtotime($request->jadwal_tes);
            // $tanggal = date('Y-m-d',$time);
            // $pendaftaran = pendaftaran::create([
            //     'no_pendaftaran' => $request->no_pendaftaran,
            //     'no_peserta' => $request->no_peserta,
            //     'jadwal_tes' => $tanggal,
            //     'jenis_tes' => $request->jenis_tes,
            // ]);
    
            // return response()->json([
            //     "status" => "success",
            //     "message" => 'Berhasil Menyimpan Data'
            // ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\pendidikanSebelumnya  $pendidikanSebelumnya
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pendaftaran = pendaftaran::where('no_pendaftaran', $id)->first(); 

        return response()->json([
            'status' => 'success',
            'message' => 'sukses menampilkan data',
            'data' => $pendaftaran
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\pendidikanSebelumnya  $pendidikanSebelumnya
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pendaftaran = pendaftaran::where('no_pendaftaran', $id)->first(); 

        return response()->json([
            'status' => 'success',
            'message' => 'sukses menampilkan data',
            'data' => $pendaftaran
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
            'no_peserta => required',
            'jadwal_tes => required',
            'jenis_tes => required',
        );

        $cek = Validator::make($request->all(),$rules);

        if($cek->fails()){
            $errorString = implode(",",$cek->messages()->all());
            return response()->json([
                'message' => $errorString
            ], 401);
        }else{
            $time = strtotime($request->tanggal_lahir_ayah);
            $tanggal = date('Y-m-d',$time);
            $pendaftaran = pendaftaran::where('no_pendaftaran',$id)->first();
            $pendaftaran->no_pendaftaran = $request->no_pendaftaran;
            $pendaftaran->no_peserta = $request->no_peserta;
            $pendaftaran->jadwal_tes = $tanggal;
            $pendaftaran->jenis_tes = $request->jenis_tes;

            if($pendaftaran->save()){
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
           for($i = 0 ; $i < count($request->no_pendaftaran) ; $i++){
            
            $delete = pendaftaran::find($request->no_pendaftaran[$i]);
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
                "message" => 'nomor pendaftaran tidak ditemukan'
            ]);
        }
    }
}
