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
    protected $apitoken;
    protected $link;
    protected $pesan;
    protected $sender;


    public function __construct($nope,$apitoken,$link,$pesan,$sender)
    {
        $this->nope = $nope;
        $this->apitoken = $apitoken;
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
        
        $data = [
            'api_key' => $this->apitoken,
            'sender' => $this->sender,
            'number' => $this->nope,
            'message' => $this->pesan,
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
          DB::table('wablast')->whereIn('nope', [$nomor])->update([
            'status' => 'done',
            'tgl' => date('d-m-Y')
          ]);
       }
    }
}
