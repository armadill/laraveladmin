<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Http\Controllers\Midtrans\ApiRequestor;
use App\Http\Controllers\Midtrans\CoreApi;
use App\Http\Controllers\Midtrans\Config;
use App\Http\Controllers\Midtrans\Sanitizer;
use App\Http\Controllers\Midtrans\Snap;
use App\Http\Controllers\Midtrans\SnapApiRequestor;
use App\Http\Controllers\Midtrans\Transaction;
use App\Sewa;
use App\Tokencekout;
use Carbon\Carbon;

class PaymentController extends Controller
{
    protected function getpayment(Request $request){
        try {
            $transaction = array(
                "payment_type" => "bank_transfer",
                "transaction_details" => [
                    "gross_amount" => 10000,
                    "order_id" => date('Y-m-dHis')
                ],
                "customer_details" => [
                    "email" => "budi.utomo@Midtrans.com",
                    "first_name" => "Azhar",
                    "last_name" => "Ogi",
                    "phone" => "+628948484848"
                ],
                "item_details" => array([
                    "id" => "1388998298204",
                    "price" => 5000,
                    "quantity" => 1,
                    "name" => "Panci Miako"
                ], [
                    "id" => "1388998298202",
                    "price" => 5000,
                    "quantity" => 1,
                    "name" => "Ayam Geprek"
                ]),
                "bank_transfer" => [
                    "bank" => "bca",
                    "va_number" => "111111",
                ]
            );
$charge = CoreApi::charge($transaction);
            if (!$charge) {
                return ['code' => 0, 'messgae' => 'Terjadi kesalahan'];
            }
            return ['code' => 1, 'messgae' => 'Success', 'result' => $charge];
        } catch (\Exception $e) {
            return ['code' => 0, 'messgae' => 'Terjadi kesalahan'];
        }
    }



    public function getSnapToken($id,$random){
        $caridata = Sewa::findOrFail($id);
        $total = $caridata->harga*$caridata->maxuser+$caridata->hargax;
        $item_list = array();
        $amount = 0;
        Config::$serverKey = 'Mid-server-i5XTf1SW2ypnvl-amR0Zs5pR';
        if (!isset(Config::$serverKey)) {
            return "Please set your payment server key";
        }
        Config::$isSanitized = true;

        // Enable 3D-Secure
        Config::$is3ds = true;
        
        // Required

         $item_list[] = [
                'id' => "111",
                'price' => $total,
                'quantity' => 1,
                'name' => $caridata->domain,
        ];

        $transaction_details = array(
            'order_id' => $random,
            'gross_amount' => $total, // no decimal allowed for creditcard
        );


        // Optional
        $item_details = $item_list;

    
        // Optional
        $customer_details = array(
            'first_name'    =>   $caridata->domain,
            // 'last_name'     => "Litani",
            'email'         => $caridata->email,
            'phone'         => $caridata->nope,
           // 'billing_address'  => $billing_address,
           // 'shipping_address' => $shipping_address
        );

        // Fill transaction details
        $transaction = array(
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
            'item_details' => $item_details,
        );
        // return $transaction;
        try {
            $snapToken = Snap::getSnapToken($transaction);
            return response()->json($snapToken);
            // return ['code' => 1 , 'message' => 'success' , 'result' => $snapToken];
        } catch (\Exception $e) {
            dd($e);
            return ['code' => 0 , 'message' => 'failed'];
        }

    }


    public function getpay($nope,$random,$id){
        $caridata = Sewa::where('id',$id)->where('nope',$nope)->first();
        $token =  Tokencekout::where('orderid',$random)->first();

        if($caridata == null){
            return view('status',['random' => '', 'status' => 'NOT FOUND']);
        }
       
        if($token->status == 'expire'){
            return view('status',['random' => $random, 'status' => 'Expired']);
        }

        if($token->status == 'settlement'){
            return view('status',['random' => $random, 'status' => 'Sukses']);
        }
         

        $client = new \GuzzleHttp\Client();
        try {
            $res = $client->request('GET', 'https://admin.absenpegawai.com/snap/'. $id.'/'.$random);
            $data = json_decode($res->getBody()->getContents());
            if($data == ''){
                return view('payment',['token'=> $token->token , 'data' => $caridata, 'random' => $random]);
            }else {
                 Tokencekout::where('orderid',$random)->update(['token' => $data->token]);
               return view('payment',['token'=> $data->token , 'data' => $caridata, 'random' => $random]);
            }

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function indexbayar(){
       $tanggal = Date('Y-m-d');
      $data = Sewa::where('lock','Tidak Aktif')->get();
      foreach ($data as $key ) {
        $to =  Carbon::createFromFormat('Y-m-d', $key->tglselesai);
         $from =  Carbon::createFromFormat('Y-m-d', $tanggal);
         $tampil = Carbon::parse($key->tglselesai)->format('d M Y');
         $left = $to->diffInDays($from);

          $hitung = $key->harga*$key->maxuser+$key->hargax;
          $total =  number_format($hitung, 0, ',', '.');
          
          $selesai = rawurlencode($tampil);
          if($left == 1 or $left == 2){
         // echo 'ada';
          $random =  rand();
          $nope = $key->nope;
          $id = $key->id;
          $selesai = $key->tglselesai;
          $link = $key->domain;

          $simpantoken = Tokencekout::create([
            'orderid' => $random,
            'sewa_id'=> $id,
            'tanggal' => date('Y-m-d'),
            'jumlah' => $hitung,
            'status' => 'none',
          ]);

       //  $linkbayar = 'http://admin.absenpegawai.com/bayar/'.$nope.'/'.$random.'/'.$id;
           $linkbayar = 'https://admin.absenpegawai.com/bayar/'.$nope.'/'.$simpantoken->orderid.'/'.$id;

           

  $pesan = "
📝 *Invoice*

Tagihan *$link*  telah di buat,

🔢 Invoice : $simpantoken->orderid
💷 Total tagihan : *Rp $total*
🗓️ Jatuh tempo  : *$tampil*
*Link Pembyaran*
$linkbayar

jika ada pertanyaan mengenai produk silahkan chat kami  😊"
  ;
$post = ['number' => $nope, 'message' => $pesan];                                                                            
$ch = curl_init();
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
curl_setopt($ch, CURLOPT_URL, 'https://whatsapp.absenpegawai.com/v2/send-message');
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
$result = curl_exec($ch);
curl_close($ch);

           }

            if($tanggal > $key->tglselesai){
           
         $update = Sewa::where('id',$key->id)->update(['lock' => 'on'])  ;

         }

         
}
}        
      


public function notif(Request $request){
 $orderid = $request->order_id;
 $status  = $request->transaction_status;
 $update  = Tokencekout::where('orderid',$request->order_id)->update([
                'status' => $request->transaction_status,
                'jenispay' => $request->payment_type,
                'tanggal' => $request->transaction_time,
            ]);

 $data = Tokencekout::where('orderid',$orderid)->first();
 $datasewa = Sewa::where('id',$data->sewa_id)->first();

if($request->transaction_status == 'pending'){
$pesan = "
👩‍💻 *Status Menunggu pembayaran*
Lakukan Pembayaran tagihan *INV-$request->order_id*. 
untuk detail dan petunjuk serta batas pembayaran silahkan buka link sesuai nomor invoice


jika ada pertanyaan mengenai produk silahkan chat kami  😊"
  ;
$post = ['number' => $datasewa->nope, 'message' => $pesan];                                                                            
$ch = curl_init();
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
curl_setopt($ch, CURLOPT_URL, 'https://whatsapp.absenpegawai.com/v2/send-message');
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
$result = curl_exec($ch);
curl_close($ch);

 }

 if($request->transaction_status == 'settlement'){
$date = Carbon::createFromFormat('Y-m-d', $datasewa->tglselesai)->addMonth();
 $nextmonth = $date->format('Y-m-d');
 Sewa::where('id',$data->sewa_id)->update([
 'tglselesai' => $nextmonth,
 ]);

$pesan = "
🆗 *Pembayaran berhasil*
Pembayaran tagihan *INV-$request->order_id* telah berhasil.


jika ada pertanyaan mengenai produk silahkan chat kami  😊"
  ;
$post = ['number' => $datasewa->nope, 'message' => $pesan];                                                                            
$ch = curl_init();
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
curl_setopt($ch, CURLOPT_URL, 'https://whatsapp.absenpegawai.com/v2/send-message');
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
$result = curl_exec($ch);
curl_close($ch);

 }     

if($request->transaction_status == 'expire'){

$pesan = "
🚫 *Invoice Expired*
Pembayaran tagihan *INV-$request->order_id* telah kadarluasa/expired,
mohon untuk tidak melanjutkan pembayaran  pada no invoice di atas.

jika ada pertanyaan mengenai produk silahkan chat kami  😊"
  ;
$post = ['number' => $datasewa->nope, 'message' => $pesan];                                                                            
$ch = curl_init();
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
curl_setopt($ch, CURLOPT_URL, 'https://whatsapp.absenpegawai.com/v2/send-message');
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
$result = curl_exec($ch);
curl_close($ch);

 }            
       


        }


public function anydata(){
  $data  = DB::table('appconfig')->get();
  return response()->json($data);
}
    
    

    
}
