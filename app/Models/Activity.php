<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = [];

    protected $dates = [
        'activity_start',
        'activity_end'
    ];

    public function getValid()
    {
        return $this->activity_start < now() && $this->activity_end > now();
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
