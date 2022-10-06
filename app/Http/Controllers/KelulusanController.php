<?php

namespace App\Http\Controllers;

use App\Models\Kelulusan;
use Illuminate\Http\Request;
use App\Http\Controllers\WaControllers;
use Auth;
use Validator;

class KelulusanController extends Controller
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
            'user_id' => 'required|unique:kelulusan',
            'kelulusan' => 'required'
        );
        $cek = Validator::make($request->all(),$rules);

        if($cek->fails()){
            $errorString = implode(",",$cek->messages()->all());
            return response()->json([
                'message' => $errorString
            ], 401);
        }else{
            $kelulusan = Kelulusan::create([
                'user_id' => $request->user_id,
                'kelulusan' => $request->kelulusan,
            ]);

            return response()->json([
                "status" => "success",
                "message" => 'Berhasil Menyimpan Nilai'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kelulusan  $kelulusan
     * @return \Illuminate\Http\Response
     */
    public function show(Kelulusan $kelulusan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kelulusan  $kelulusan
     * @return \Illuminate\Http\Response
     */
    public function edit(Kelulusan $kelulusan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kelulusan  $kelulusan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $rules = array(
            'user_id' => 'required',
            'kelulusan' => 'required'
        );
        $cek = Validator::make($request->all(),$rules);

        if($cek->fails()){
            $errorString = implode(",",$cek->messages()->all());
            return response()->json([
                'message' => $errorString
            ], 401);
        }else{
            $data = Kelulusan::where('user_id',$request->user_id)->first();
            $data->kelulusan = $request->kelulusan;

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kelulusan  $kelulusan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kelulusan $kelulusan)
    {
        //
    }
    
    public function fxas()
    {
        return "adjadaaaw";
    }
}
