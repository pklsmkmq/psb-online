<?php

namespace App\Http\Controllers;

use App\Models\dataAyah;
use Illuminate\Http\Request;
use Validator;
use Auth;
class DataAyahController extends Controller
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
        $users = dataAyah::where('name_ayah', 'like', '%'.strtolower($request->keywords)."%")->orderBy("created_at", 'desc')->paginate($request->perpage, [
            'data_ayah.nik_ayah',
            'data_ayah.nik_siswa',
            'data_ayah.name_ayah',
            'data_ayah.tempat_lahir_ayah',
            'data_ayah.tanggal_lahir_ayah',
            'data_ayah.pekerjaan_ayah',
            'data_ayah.nomor_telepon_ayah',
            'data_ayah.penghasilan_ayah',
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
            'nik_ayah' => 'unique:data_ayah,nik_ayah',
            'user_id' => 'unique:data_ayah,user_id',
            'name_ayah' => 'required|string|max:255',
            // 'tempat_lahir_ayah' => 'required|string|max:255',
            // 'tanggal_lahir_ayah' => 'required',
            // 'pekerjaan_ayah' => 'required|string|max:50',
            'nomor_telepon_ayah' => 'required',
            // 'penghasilan_ayah' => 'required|string',
        );
        $request["user_id"] = Auth::user()->id;
        $cek = Validator::make($request->all(),$rules);

        if($cek->fails()){
            $errorString = implode(",",$cek->messages()->all());
            return response()->json([
                'message' => $errorString
            ], 401);
        }else{
            $time = strtotime($request->tanggal_lahir_ayah);
            $tanggal = date('Y-m-d',$time);
            $dataAyah = dataAyah::create([
                'nik_ayah' => $request->nik_ayah,
                'user_id' => Auth::user()->id,
                'name_ayah' => $request->name_ayah,
                'tempat_lahir_ayah' => $request->tempat_lahir_ayah,
                'tanggal_lahir_ayah' => $tanggal,
                'pekerjaan_ayah' => $request->pekerjaan_ayah,
                'nomor_telepon_ayah' => $request->nomor_telepon_ayah,
                'penghasilan_ayah' => $request->penghasilan_ayah,
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
     * @param  \App\Models\pendidikanSebelumnya  $pendidikanSebelumnya
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dataAyah = dataAyah::where('nik_ayah', $id)->first(); 

        return response()->json([
            'status' => 'success',
            'message' => 'sukses menampilkan data',
            'data' => $dataAyah
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
        $dataAyah = dataAyah::where('nik_ayah', $id)->first(); 

        return response()->json([
            'status' => 'success',
            'message' => 'sukses menampilkan data',
            'data' => $dataAyah
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
            'nik_siswa' => 'required|numeric',
            'name_ayah' => 'required|string|max:255',
            'tempat_lahir_ayah' => 'required|string|max:255',
            'tanggal_lahir_ayah' => 'required',
            'pekerjaan_ayah' => 'required|string|max:50',
            'nomor_telepon_ayah' => 'required',
            'penghasilan_ayah' => 'required|numeric'
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
            $dataAyah = dataAyah::where('nik_ayah',$id)->first();
            $dataAyah->nik_siswa = $request->nik_siswa;
            $dataAyah->name_ayah = $request->name_ayah;
            $dataAyah->tempat_lahir_ayah = $request->tempat_lahir_ayah;
            $dataAyah->tanggal_lahir_ayah = $tanggal;
            $dataAyah->pekerjaan_ayah = $request->pekerjaan_ayah;
            $dataAyah->nomor_telepon_ayah = $request->nomor_telepon_ayah;
            $dataAyah->penghasilan_ayah = $request->penghasilan_ayah;

            if($dataAyah->save()){
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
           for($i = 0 ; $i < count($request->nik_ayah) ; $i++){
            
            $delete = dataAyah::find($request->nik_ayah[$i]);
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
                "message" => 'NIK Ayah tidak ditemukan'
            ]);
        }
    }
}
