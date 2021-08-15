<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use DB;

class Jobwablast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $nope;
    protected $token;
    protected $link;
    protected $pesan;
    protected $sender;


    public function __construct($nope,$token,$link,$pesan,$sende)
    {
        $this->nope = $nope;
        $this->token = $token;
        $this->link = $link;
        $this->pesan = $pesan;
        $this->sender = $sender;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $cariapikey = DB::table('modul')->where('kata', 'Apikeywa')->first();
        $apikeywa = $cariapikey->status ?? env('APIWA');
        $carinowa = DB::table('modul')->where('kata', 'Wanotif')->first();
        $nowa = $carinowa->status ?? env('WANUM');

        $data = [
            'api_key' => $token,
            'sender' => $sender,
            'number' => $nope,
            'message' => $pesan,
        ];

        $curl = curl_init();
        curl_setopt_array(
            $curl,
            [
                CURLOPT_URL => $link,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($data), ]
        );
        $response = curl_exec($curl);
        curl_close($curl);

       foreach ($nope as $key => $nomor) {
          DB::table('wablast')->whereIn([$nomor])->update([
            'status' => 'done'
          ]);
       }
    }
}
