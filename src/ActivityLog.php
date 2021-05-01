<?php

namespace hb\Activity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user',
        'ip_address',
        'model_name',
        'model_id',
        'payload',
        'action'
    ];
}
