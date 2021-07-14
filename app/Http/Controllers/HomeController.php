<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sewa;
use DataTables;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Crypt;
use App\Tokencekout;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
class HomeController extends Controller

{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      
        return view('home');
    }

     public function loadtabelsewa(){
        $data = DB::table('sewa');
        return Datatables::of($data)
        ->editColumn('sisa',function($data){
            $tanggal = Date('Y-m-d');
            $to = Carbon::createFromFormat('Y-m-d', $data->tglselesai);
            $from = Carbon::createFromFormat('Y-m-d', $tanggal);
            $sisa = $to->diffInDays($from);
            
                return '<span class="badge badge-secondary">'.$sisa.'<span>';
        })
        ->editColumn('tgl',function($data){
           $tgl = $data->tglmulai.' | '.$data->tglselesai;
            
                return $tgl;
        })
         ->editColumn('total',function($data){
          $total = $data->harga * $data->maxuser;
            
                return number_format($total, 0);;
        })
          ->editColumn('domain',function($data){
       
            
                return "<a href='$data->domain' target='_blank'>$data->domain</a>";
        })
        ->editColumn('face',function($data){
           
            $wa = ($data->face == 'on') ? "<span class='badge badge-success'>On</span>" : (($data->face <> 'on') ? '<span class="badge badge-dark">No</span>' : '');




                $tele = ($data->tele == 'on') ? "<span class='badge badge-success'>On</span>" : (($data->tele <> 'on') ? '<span class="badge badge-dark">No</span>' : '');

                $lock = ($data->lock == 'on') ? "<span class='badge badge-success'>Aktif</span>" : (($data->lock <> 'on') ? '<span class="badge badge-dark">No</span>' : '');

                return "<span class='badge badge-secondary'> Whatsapp :</span> $wa <br>
                <span class='badge badge-secondary'>Telegram :</span> $tele<br>
                <span class='badge badge-secondary'>Lock Domain :</span> $lock
                ";
        })
          ->addColumn('aksi',function($data){
            return "
             <button style='padding:4px 7px 4px 7px' class='far fa-edit btn btn-sm btn-success btn-sm mb-2' data-toggle='modal' data-target='#edit'
            data-txtid='$data->id'
            data-txtnama='$data->domain'
            data-txtharga='$data->harga'
            data-txthargax='$data->hargax'
             data-txtmax='$data->maxuser'
              data-txtnope='$data->nope'
              data-txtmulai='$data->tglmulai'
              data-txtselesai='$data->tglselesai'
              data-txtket='$data->ket'
              data-txtfacenya='$data->face'
              data-txttelenya='$data->tele'
              data-txtlocknya='$data->lock'
               data-email='$data->email'
          t
            >
            </button>
          
            <button class='fas fa-paper-plane btn btn-sm btn-primary btn-sm mb-2' data-toggle='modal' data-target='#push'
            data-txtid='$data->id'
            data-txtnama='$data->domain'
            >
            </button>


             <button class='far fa-trash-alt btn btn-sm btn-danger btn-sm' data-toggle='modal' data-target='#hapus'
            data-txtid=$data->id
            data-txtnama=$data->domain
            >
            </button>
           
            ";
         })
        ->rawColumns(['sisa','tgl','total','aksi','domain','face'])
        ->make(true);
        
    
    }

    public function postsewwa(Request $request){
    
        $face = $request->txtface ? : 'No';
        $tele = $request->txttele ? : 'No';
        $lock = $request->txtlock ? : 'Tidak Aktif';
       
        $key = str_replace("/","",$request->txtdomain);
        try {
             $simpan = Sewa::insert([
            'domain' => $request->txtdomain,
            'harga' =>  $request->txtharga,
            'hargax' => '0',
            'maxuser' =>  $request->txtmax,
            'nope' =>  $request->txtnope,
            'email' =>  $request->email,
            'tglmulai' =>  $request->txttgl1,
            'tglselesai' =>  $request->txttgl2,
            'ket' => $request->txtket,
            'key' => $key,
            'face' => $face,
            'tele' => $tele,
            'lock' => $lock,
        ]);
        
        return back()->with('sukses','Berhasil di tambahkan');
        }catch (Exception $e){
        dd($e);
        }
       

       
    }


    public function postkirimtagihan(Request $request){
      $tanggal = Date('Y-m-d');
      $data = Sewa::where('id', $request->txtid)->first();

        $to =  Carbon::createFromFormat('Y-m-d', $data->tglselesai);
         $from =  Carbon::createFromFormat('Y-m-d', $tanggal);
         $tampil = Carbon::parse($data->tglselesai)->format('d M Y');
         $left = $to->diffInDays($from);

          $hitung = $data->harga*$data->maxuser+$data->hargax;
          $total =  number_format($hitung, 0, ',', '.');
          
          $selesai = rawurlencode($tampil);

          $random =  rand();
          $nope = $data->nope;
          $id = $data->id;
          $selesai = $data->tglselesai;
          $link = $data->domain;

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

🔢 Invoice : *$simpantoken->orderid*
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

if($pesan){
return back()->with('sukses','Berhasil mengirimkan tagihan');
}           

            if($tanggal > $data->tglselesai){
           
         $update = Sewa::where('id',$request->txtid)->update(['lock' => 'on'])  ;

         }

      
    }

    public function hapusdatadomain(Request $request){
        $hapus = Sewa::where('id',$request->txtid)->delete();
        if($hapus){
            return back()->with('sukses','Berhasil dihapus');
        }
          return back()->with('gagal','Berhasil dihapus');
    }


    public function updatesewa(Request $request){
         $key = str_replace("/","",$request->txtnama);
         
        $tele = $request->txttele ? : 'No';
        $face = $request->txtface ? : 'No';
        $lock = $request->txtlock ? : 'Tidak Aktif';



       try {
         $update = Sewa::where('id',$request->txtid)->update([
            'domain' => $request->txtnama,
            'harga' => $request->txtharga,
            'maxuser' => $request->txtmax,
            'nope' => $request->txtnope,
            'email' => $request->email,
            'tglmulai' => $request->txtmulai,
            'tglselesai' => $request->txtselesai,
            'hargax' => $request->txthargax,
            'ket' => $request->txtket,
            'key' =>$key,
            'face' => $face,
            'tele' => $tele,
            'lock' => $lock,
        ]);
             return back()->with('sukses','Berhasil diupdate');
       }catch(Excpetion $e){
        dd($e);
       }

    }

    public function cronsewa(){
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
          if($left == 1 or $left == 2 or $left == 5 or $left == 8){
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

🔢 Invoice : *$simpantoken->orderid*
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
    
    public function kirimwa(){
$pesan = 'Mencoba Pesan
'.date('d M Y H:i:s');
$post = ['number' => '62895623663095', 'message' => $pesan];                                                                            
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




