<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Sewa;
use Illuminate\Support\Facades\Auth;
use Validator;
use Hash;
use DB;
class registercontrol extends Controller
{
    
    public function daftar(Request $request){
    	$validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

         if($validator->fails()){
          return response()->json(['error'=>$validator->errors()], 401);      
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;

        return $this->sendResponse($success, 'User register successfully.');

    }

    public function postlogin(Request $request){
    	$cek = User::where('email',$request->email)->first();
        if($cek){
        	if(Hash::check($request->password, $cek->password)){
        		return response()->json([
        		'message' => ' email benar',
        	], 200);
        	}else {
        		return response()->json([
        		'message' => ' email salah',
        	], 200);
        	}
        	
        }else {
        	return response()->json([
        		'message' => ' email atau password salah',
        	], 401);
        }
    }

    public function getsewa(){
    	$data = DB::table('sewa')->get();
    	return response()->json([
    		'message' => 'data',
    		'pesan' => $data,
    	], 200);

    }

   public function ceksewa(Request $request, $domain){
   	$cek = DB::table('sewa')->where('key',$domain)->first();
  	 return response()->json([
   	   'data' => $cek,
   	], 200);
   	
   }


   public function ceklock(Request $request, $key){
    $cek = DB::table('sewa')->where('key',$key)->first();
     return response()->json([
       'data' => $cek,
    ], 200);
   }

   public function postdomain(Request $request){
    $validator = Validator::make($request->all(), [
      'domain' => 'required|max:100',
    ]);

    if($validator->fails()){
      return response()->json(['error'=>$validator->errors()], 401);      
    }


     $cek = DB::table('sewa')->where('domain',$request->domain)->count();
     if($cek < 1){
      $keydomain = str_replace("/","",$request->domain);
      $simpan = Sewa::create([
        'domain' => $request->domain,
        'harga' => 0,
        'hargax' => 0,
        'maxuser' => 30,
        'nope' =>  0,
        'email' => 'alman.bpp@gmail.com',
        'tglmulai' => Date('Y-m-d'),
        'tglselesai' => '2040-10-10',
        'ket' => 'Tidak Terdaftar',
        'key' => $keydomain,
        'face' => 'No',
        'wa' => 'on',
        'tele' => 'on',
        'lock' => 'Tidak Aktif',
      ]);
      if($simpan){
        return response()->json([
          'data' => 'Berhasil diupload',
        ], 200);
      }

    } else {
      return response()->json([
        'data' => 'terdaftar',
      ], 200);
    }
    
  }


public function postappconfig(Request $request){
  $update = DB::table('appconfig')->where('urlbase',$request->link)->update([
    'urlsplash' => $request->urlsplash,
    'durasisplash' => $request->durasisplash,
    'maintain' => $request->maintain,
    'info' => $request->info,
    'warna' => $request->warna
  ]);

  if($update){
    return response()->json([
          'data' => 'Berhasil diupdate',
        ], 200);
  }
  else {
     return response()->json([
        'data' => 'Gagal update',
      ], 200);
  }
}

public function getlock($domain){
 $base = 'https://'.$domain; 
$data = DB::table('appconfig')->where('urlbase',$base)->first();
  if($data){
    return response()->json([
        'message' => 'data',
        'pesan' => $data,
      ], 200);
  }else {
    return response()->json([
        'message' => 'data',
        'pesan' => 'tidak tersedia',
      ], 200);
  }
}



}
