<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tokencekout extends Model
{
     protected $table = 'tokencekout';

   protected $fillable = ['orderid','sewa_id','tanggal','jumlah','status','jenispay','token','statuscron'];

    public function sewa(){
    	return $this->belongsto(Sewa::class);
    }
}
