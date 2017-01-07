<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'areas';

    public function city()
    {
        return $this->belongsTo('App\City', 'city_id');
    }

    public function district()
    {
        return $this->belongsTo('App\District', 'district_id');
    }

    public function sport()
    {
        return $this->belongsTo('App\Sport', 'sport_id');
    }

    public function organization()
    {
        return $this->belongsTo('App\Organization', 'org_id');
    }

    public function fields()
    {
        return $this->hasMany('App\Field');
    }

    public function getFieldsMatchesCountAttribute()
    {
        $matches = 0;

        foreach ($this->fields as $field)
        {
            $matches += $field->matches->where('date', '>=', date('Y-m-d'))->count();
        }

        return $matches;
    }
}