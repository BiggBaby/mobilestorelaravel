<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customer extends Model
{
    use HasFactory;
    protected $table = "person";
    public function bill(){
        return $this->hasMany('app\bill', 'id_person','id');
    }
}
