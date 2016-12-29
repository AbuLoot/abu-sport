<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sport extends Model
{
    protected $table = 'sports';

   	public function areas()
   	{
   		return $this->hasMany('App\Area');
   	}
}
