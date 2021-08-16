<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Hash;

class AuthController extends Controller
{
    
    
    public function register(Request $request)
    {
        $rules = array(
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'phone' => 'required|string|unique:users,phone',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|max:1',
        );

        $cek = Validator::make($request->all(),$rules);

        if($cek->fails()){
            $errorString = implode(",",$cek->messages()->all());
            return response()->json([
                'message' => $errorString
            ], 401);
        }else{
            $user = User::create([
                'name' => $request->name,
                'password' => bcrypt($request->password),
                'email' => $request->email,
                'phone' => $request->phone
            ]);
            
            if($request->role == 1){
                $user->assignRole('admin');
            }elseif ($request->role == 2) {
                $user->assignRole('user');
            }elseif ($request->role == 3) {
                $user->assignRole('marketing & cs');
            }else {
                $user->assignRole('keuangan');
            }
            
            $token = $user->createToken('token-name')->plainTextToken;

            return response()->json([
                'message'   => 'Success',
                'token'      => $token
            ], 200);
        }
    }

    public function login(Request $request)
    {
        $rules = array(
            'email' => 'required|string|email|',
            'password' => 'required|string|min:6'
        );

        $cek = Validator::make($request->all(),$rules);

        if($cek->fails()){
            $errorString = implode(",",$cek->messages()->all());
            return response()->json([
                'message' => $errorString
            ], 401);
        }else{
            $user = User::where('email',$request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'message' => 'Unaouthorized'
                ], 401);
            }
            
            $token = $user->createToken('token-name')->plainTextToken;
            $roles = $user->getRoleNames();
          
            // if($user->id == 1 | 2 | 5  |6 ){
            //     $guru = ManagemenGuru::where('user_id' , '=', $user->id)->first();
        
            //     if($guru == ""){
            //         $identias = "belum terisi";
            //     }else{
            //         $identias ="terisi";
                  
            //     }
              
            // }
            // if($user->id == 3 ){
            //     $siswa = ManagemenSiswa::where('user_id' , '=', $user->id)->first();
        
            //     if($siswa == ""){
            //         $identias = "belum terisi";
            //     }else{
            //         $identias ="terisi";
                  
            //     }
              
            // }
            // if($user->id == 3 ){
            //     $wali = ManagemenSiswa::where('user_id' , '=', $user->id)->first();
        
            //     if($wali == ""){
            //         $identias = "belum terisi";
            //     }else{
            //         $identias ="terisi";
                  
            //     }
              
            // }if($user->id == 4 ){
            //     $siswa = ManagemenWali::where('user_id' , '=', $user->id)->first();
        
            //     if($siswa == ""){
            //         $identias = "belum terisi";
            //     }else{
            //         $identias ="terisi";
                  
            //     }
              
            // }
          
            return response()->json([
                'message'   => 'Success',
                'user'      => $user,
                'role'      => $roles,
                'token'      => $token,
                // 'identias' => $identias
            ], 200);
        }
    }

    public function nyoba(Request $request)
    {
        $rules = array(
            'nama_user' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|max:1',
            'status' => 'required|max:1'
        );

        $cek = Validator::make($request->all(),$rules);

        if($cek->fails()){
            $errorString = implode(",",$cek->messages()->all());
            return response()->json([
                'message' => $errorString
            ], 401);
        }else{
            $user = User::create([
                'nama_user' => $request->nama_user,
                'password' => bcrypt($request->password),
                'email' => $request->email,
                'role' => $request->role,
                'status' => $request->status
            ]);

            $user->assignRole('guru');
    
            return "sukses";
        }
    }

    public function authMe(Request $request)
    {
        // $request->user()->currentAccessToken()->delete();
        // $token= $request->user()->createToken('token-name')->plainTextToken;
        // $user = $request->user();
        // $roles = $user->getRoleNames();
          
        //     if($user->id == 1 | 2 | 5  |6 ){
        //         $guru = ManagemenGuru::where('user_id' , '=', $user->id)->first();
        
        //         if($guru == ""){
        //             $identias = "belum terisi";
        //         }else{
        //             $identias ="terisi";
                  
        //         }
              
        //     }
        //     if($user->id == 3 ){
        //         $siswa = ManagemenSiswa::where('user_id' , '=', $user->id)->first();
        
        //         if($siswa == ""){
        //             $identias = "belum terisi";
        //         }else{
        //             $identias ="terisi";
                  
        //         }
              
        //     }
        //     if($user->id == 3 ){
        //         $wali = ManagemenSiswa::where('user_id' , '=', $user->id)->first();
        
        //         if($wali == ""){
        //             $identias = "belum terisi";
        //         }else{
        //             $identias ="terisi";
                  
        //         }
              
        //     }if($user->id == 4 ){
        //         $siswa = ManagemenWali::where('user_id' , '=', $user->id)->first();
        
        //         if($siswa == ""){
        //             $identias = "belum terisi";
        //         }else{
        //             $identias ="terisi";
                  
        //         }
              
        //     }
       
        // return response()->json([
        //     'message'   => 'Success',
        //     'user'      => $user,
        //     'token'      => $token,
        //     'identias' => $identias
        // ], 200);
    }

    
}
