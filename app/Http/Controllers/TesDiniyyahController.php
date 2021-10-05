<?php

namespace App\Http\Controllers;

use App\Models\TesDiniyyah;
use App\Models\calonSiswa;
use App\Models\User;
use Illuminate\Http\Request;
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
                        \Mail::to($dtUser->email)->send(new \App\Mail\kelulusan($details));
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
                $tgl = \Carbon\Carbon::createFromFormat('Y-m-d', $dtTes->tanggal)->format('d M Y') ;
                try {
                    $details = [
                        'tanggal' => $tgl,
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
}
