<?php

namespace App\Http\Controllers;

use App\Models\TesDiniyyah;
use Illuminate\Http\Request;
use Auth;
use Validator;

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
              
                'metode' => 'required',
            );
            $request["user_id"] = Auth::user()->id;
            $cek = Validator::make($request->all(),$rules);
    
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
                    'catatan' => $request->catatan
                ]);
    
                // $details = [
                //     'name' => Auth::user()->name,
                //     'bukti' => $response
                // ];
    
                // \Mail::to("psbsmkmq@gmail.com")->send(new \App\Mail\BayarMail($details));
    
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
}
