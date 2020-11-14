<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;
    protected $table = "product";
    public function type_product(){
        return $this->belongTo('app\type_product', 'id_type', 'id');
        // ID: ID product
    }
    public function detail_bill(){
        return $this->hasMany('app\detail_bill', 'id_product','id');
    }
}
