<?php

namespace App;

use Auth;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    protected $table = 'matches';

    public function field()
    {
    	return $this->belongsTo('App\Field', 'field_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function users()
    {
    	return $this->belongsToMany('App\User');
    }

    public function chat()
    {
        return $this->hasMany('App\Chat');
    }

    public function getTimeFromToAttribute()
    {
        list($num_hour, $zeros) = explode(':', $this->end_time);

        $num_hour = ($num_hour == '23') ? '00' : ++$num_hour;

        return 'с ' . $this->start_time . ' до ' . $num_hour . ':' . $zeros;
    }

    public function getPriceForEachAttribute()
    {
        return ($this->price / $this->number_of_players) . ' тг';
    }

    public function getUsersCountAttribute()
    {
        return $this->users->count() + 1;
    }

    public function getMatchDateAttribute()
    {
        list($date['year'], $date['month'], $date['day']) = explode('-', $this->date);

        return $date['day'].' '.trans('data.month.'.$date['month']).'. '.$date['year'];
    }
}
