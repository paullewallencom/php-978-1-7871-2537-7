<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Secret extends Model
{
    protected $table = 'secrets';

    protected $fillable = ['name', 'latitude', 'longitude', 'location_name'];
}
