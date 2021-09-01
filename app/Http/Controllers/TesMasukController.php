<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TesMasuk;
use Auth;
use Validator;

class TesMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'kode_mapel' => 'required',
            'nilai' => 'required',
        );
        $request->user_id = Auth::user()->id;
        $cek = Validator::make($request->all(),$rules);

        if($cek->fails()){
            $errorString = implode(",",$cek->messages()->all());
            return response()->json([
                'message' => $errorString
            ], 401);
        }else{
            $cekData = TesMasuk::where('user_id',Auth::user()->id)
                        ->where('kode_mapel',$request->kode_mapel)
                        ->count();
            if ($cekData == 0) {
                $tesMasuk = TesMasuk::create([
                    'user_id' => Auth::user()->id,
                    'kode_mapel' => $request->kode_mapel,
                    'ulangi' => 0,
                    'nilai' => $request->nilai,
                ]);

                return response()->json([
                    "status" => "success",
                    "message" => 'Berhasil Menyimpan Nilai'
                ]);
            }else{
                return response()->json([
                    "status" => "success",
                    "message" => 'Sudah mengikuti tes ini'
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function cekTesSantri($code){
        
        $data = TesMasuk::where('user_id',Auth::user()->id)->where("kode_mapel" , $code)->orderBy('id' , 'desc')->get();
        if(count($data) === 0){
            return response()->json([
                'status' => 'success',
                'message' => 'Santri belum tes',
               
            ]);
        }
       if($data[0]->ulangi === 0){
        return response()->json([
            'status' => 'success',
            'message' => 'Sudah mengikuti tes ini',
           
        ]);
       }
       return response()->json([
        'status' => 'success',
        'message' => 'Santri belum tes',
       
    ]);
     
    }

    public function cekTes()
    {
        $sudah = [];
        $data = TesMasuk::where('user_id',Auth::user()->id);
        $jumlah = $data->count();
        if ($jumlah > 0) {
            $data = $data->get();
            foreach ($data as $key) {
                if ($key->kode_mapel == "TES001") {
                    array_push($sudah,"TES001");
                }elseif ($key->kode_mapel == "TES002") {
                    array_push($sudah,"TES002");
                }else{
                    array_push($sudah,"TES003");
                }
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'sukses menampilkan data',
            'sudahTes' => $sudah
        ]);
    }

    
}
