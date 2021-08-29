<?php

namespace App\Http\Controllers;

use App\Models\bukti;
use Illuminate\Http\Request;
use Validator;
use Auth;

class BuktiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request->keywords;
        $request->page;
        $request->role;
        $users = bukti::where('user_id', 'like', '%'.strtolower($request->keywords)."%")->orderBy("created_at", 'desc')->paginate($request->perpage, [
            'bukti.user_id',
            'bukti.url_img',
            'bukti.status'
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
            // 'user_id' => 'unique:bukti,user_id',
            'url_img' => 'required|mimes:png,jpg,jpeg,pdf|max:2048',
        );
        $request["user_id"] = Auth::user()->id;
        $cek = Validator::make($request->all(),$rules);

        if($cek->fails()){
            $errorString = implode(",",$cek->messages()->all());
            return response()->json([
                'message' => $errorString
            ], 401);
        }else{
            if (!$request->status) {
                $request->status = 0;
            }
            $gambar = $request->file('url_img');
            $response = cloudinary()->upload($gambar->path())->getSecurePath();
            $bukti = bukti::create([
                'user_id' => Auth::user()->id,
                'url_img' => $response,
                'status' => $request->status,
                'upload_ulang' => 0,
            ]);

            $details = [
                'name' => Auth::user()->name,
                'bukti' => $response
            ];

            \Mail::to("psbsmkmq@gmail.com")->send(new \App\Mail\BayarMail($details));

            return response()->json([
                "status" => "success",
                "message" => 'Berhasil Menyimpan Data'
            ]);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\bukti  $bukti
     * @return \Illuminate\Http\Response
     */
    public function show(bukti $bukti)
    {
        $bukti = bukti::where('user_id', Auth::user()->id)->first(); 

        return response()->json([
            'status' => 'success',
            'message' => 'sukses menampilkan data',
            'data' => $bukti
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\bukti  $bukti
     * @return \Illuminate\Http\Response
     */
    public function edit(bukti $bukti)
    {
        $bukti = bukti::where('user_id', Auth::user()->id)->first(); 

        return response()->json([
            'status' => 'success',
            'message' => 'sukses menampilkan data',
            'data' => $bukti
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\bukti  $bukti
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $rules = array(
            'status' => 'required',
        );
        $cek = Validator::make($request->all(),$rules);

        if($cek->fails()){
            $errorString = implode(",",$cek->messages()->all());
            return response()->json([
                'message' => $errorString
            ], 401);
        }else{
            $bukti = bukti::where('user_id', Auth::user()->id)->first(); 
            if ($request->file('url_img')) {
                $gambar = $request->file('url_img');
                $response = cloudinary()->upload($gambar->path())->getSecurePath();    
            }else{
                $response = $bukti->url_img;
            }
            
            $bukti->user_id = Auth::user()->id;
            $bukti->url_img = $response;
            $bukti->status = $request->status;

            if($bukti->save()){
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

    public function updateStatus()
    {
        $bukti = bukti::where('user_id', Auth::user()->id)->first(); 
        if ($bukti->status == 0 || $bukti->status == false) {
            $bukti->status = 1;

            if($bukti->save()){
                return response()->json([
                    "status" => "success",
                    "message" => 'Berhasil Merubah Status'
                ]);
            }else{
                return response()->json([
                    "status" => "failed",
                    "message" => 'Gagal Merubah Status'
                ]);
            }
        }
        return response()->json([
            "status" => "success",
            "message" => 'Data Sudah Terubah'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\bukti  $bukti
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            for($i = 0 ; $i < count($request->id) ; $i++){
             
             $delete = bukti::find($request->id[$i]);
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
