<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Amount extends Model
{
    protected $table = 'amount'; // ← テーブル名

    public $timestamps = false;

    protected $fillable = [
        'value',
        'sort_order',
    ];
}
