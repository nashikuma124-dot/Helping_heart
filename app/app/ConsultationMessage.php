<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsultationMessage extends Model
{
    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
