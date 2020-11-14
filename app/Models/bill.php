<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bill extends Model
{
    use HasFactory;
    protected $table = "bill";
    public function detail_bill(){
        return $this->hasMany('app\detail_bill', 'id_bill','id');
    }
    public function bill(){
        return $this->belongTo('app\person', 'id_person','id');
    }
}
