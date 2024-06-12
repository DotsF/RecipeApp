<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;


    public function recipe()
    { //追加テスト
        return $this->belongsTo(Recipe::class);
    }
}
