<?php

namespace App\Http\Controllers;

use App\Models\prestasiBelajar;
use Illuminate\Http\Request;
use Validator;

class PrestasiBelajarController extends Controller
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
        $users = prestasiBelajar::where('mata_pelajaran', 'like', '%'.strtolower($request->keywords)."%")->orderBy("created_at", 'desc')->paginate($request->perpage, [
            'prestasi_belajar.id',
            'prestasi_belajar.nik_siswa',
            'prestasi_belajar.mata_pelajaran',
            'prestasi_belajar.nilai_kelas1_semester1',
            'prestasi_belajar.nilai_kelas1_semester2',
            'prestasi_belajar.nilai_kelas2_semester1',
            'prestasi_belajar.nilai_kelas2_semester2',
            'prestasi_belajar.nilai_kelas3_semester1'
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
            'nik_siswa' => 'required|numeric',
            'mata_pelajaran' => 'required|string|max:255',
            'nilai_kelas1_semester1' => 'required|numeric',
            'nilai_kelas1_semester2' => 'required|numeric',
            'nilai_kelas2_semester1' => 'required|numeric',
            'nilai_kelas2_semester2' => 'required|numeric',
            'nilai_kelas3_semester1' => 'required|numeric',
        );

        $cek = Validator::make($request->all(),$rules);

        if($cek->fails()){
            $errorString = implode(",",$cek->messages()->all());
            return response()->json([
                'message' => $errorString
            ], 401);
        }else{
            $prestasiBelajar = prestasiBelajar::create([
                'nik_siswa' => $request->nik_siswa,
                'mata_pelajaran' => $request->mata_pelajaran,
                'nilai_kelas1_semester1' => $request->nilai_kelas1_semester1,
                'nilai_kelas1_semester2' => $request->nilai_kelas1_semester2,
                'nilai_kelas2_semester1' => $request->nilai_kelas2_semester1,
                'nilai_kelas2_semester2' => $request->nilai_kelas2_semester2,
                'nilai_kelas3_semester1' => $request->nilai_kelas3_semester1
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
        $prestasiBelajar = prestasiBelajar::where('id', $id)->first(); 

        return response()->json([
            'status' => 'success',
            'message' => 'sukses menampilkan data',
            'data' => $prestasiBelajar
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
        $prestasiBelajar = prestasiBelajar::where('id', $id)->first(); 

        return response()->json([
            'status' => 'success',
            'message' => 'sukses menampilkan data',
            'data' => $prestasiBelajar
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
            'mata_pelajaran' => 'required|string|max:255',
            'nilai_kelas1_semester1' => 'required|numeric',
            'nilai_kelas1_semester2' => 'required|numeric',
            'nilai_kelas2_semester1' => 'required|numeric',
            'nilai_kelas2_semester2' => 'required|numeric',
            'nilai_kelas3_semester1' => 'required|numeric',
        );

        $cek = Validator::make($request->all(),$rules);

        if($cek->fails()){
            $errorString = implode(",",$cek->messages()->all());
            return response()->json([
                'message' => $errorString
            ], 401);
        }else{
            $prestasiBelajar = prestasiBelajar::where('id',$id)->first();
            $prestasiBelajar->nik_siswa = $request->nik_siswa;
            $prestasiBelajar->mata_pelajaran = $request->mata_pelajaran;
            $prestasiBelajar->nilai_kelas1_semester1 = $request->nilai_kelas1_semester1;
            $prestasiBelajar->nilai_kelas1_semester2 = $request->nilai_kelas1_semester2;
            $prestasiBelajar->nilai_kelas2_semester1 = $request->nilai_kelas2_semester1;
            $prestasiBelajar->nilai_kelas2_semester2 = $request->nilai_kelas2_semester2;
            $prestasiBelajar->nilai_kelas3_semester1 = $request->nilai_kelas3_semester1;

            if($prestasiBelajar->save()){
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
           for($i = 0 ; $i < count($request->id) ; $i++){
            
            $delete = prestasiBelajar::find($request->id[$i]);
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
                "message" => 'ID tidak ditemukan'
            ]);
        }
    }
}
