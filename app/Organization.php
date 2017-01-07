<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $table = 'organizations';

    public function users()
    {
    	return $this->belongsToMany('App\User');
    }

    public function areas()
    {
    	return $this->hasMany('App\Area');
    }

    public function country()
    {
        return $this->belongsTo('App\Country', 'country_id');
    }

    public function city()
    {
        return $this->belongsTo('App\City', 'city_id');
    }

    public function district()
    {
        return $this->belongsTo('App\District', 'district_id');
    }

    public function org_type()
    {
    	return $this->belongsTo('App\OrgType', 'org_type_id');
    }
}
