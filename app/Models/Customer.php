<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;


class Customer extends Model
{
    protected $fillable = [
        'name',
        'email',
    ];
}
