<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';

    public function country()
    {
        return $this->belongsTo('App\Country', 'country_id');
    }

    public function districts()
    {
        return $this->hasMany('App\District');
    }

    public function organizations()
    {
        return $this->hasMany('App\Organization');
    }

    public function areas()
    {
        return $this->hasMany('App\Area');
    }

    public function profiles()
    {
        return $this->hasMany('App\Profile');
    }
}
