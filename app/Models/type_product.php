<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class type_product extends Model
{
    use HasFactory;
    protected $table = "type_product";
    public function product(){
        return $this->hasMany('app\product','id_type','id');
        // ID: ID type_product
    }
}
