<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
