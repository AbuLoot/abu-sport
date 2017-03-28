<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

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
		    $matchs=Match::select( DB::raw('CONCAT(date," ",end_time) as date_time'))->where('field_id', '=', $field->id)->where('date','>=',date('Y-m-d'))->where('status','=',1)->get();	
			foreach($matchs as $match){
			   if(strtotime($match->date_time)>=strtotime(date('Y-m-d H:i'))){
				$matches++;	
			   }
			}	
	   }
        return $matches;
    }
}