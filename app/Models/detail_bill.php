<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory;
    protected $table = "detail_bill";
    public function product(){
        return $this->belongTo('app\product', 'id_product','id');
    }
    public function bill(){
        return $this->belongTo('app\bill', 'id_bill','id');
    }
}
