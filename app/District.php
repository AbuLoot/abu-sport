<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = 'districts';

    public function city()
    {
        return $this->belongsTo('App\City', 'city_id');
    }

    public function organizations()
    {
        return $this->hasMany('App\Organization');
    }

    public function areas()
    {
        return $this->hasMany('App\Area');
    }
}
