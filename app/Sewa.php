<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sewa extends Model
{
   protected $table = 'sewa';

   protected $fillable = ['domain','harga','hargax','maxuser','nope','email','tglmulai','tglselesai','ket','key','face','tele','lock'];

    public function tokencekout(){
        return $this->hasMany(Tokencekout::class);
    }
}
