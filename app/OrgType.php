<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrgType extends Model
{
    protected $table = 'org_types';

    public function organizations()
    {
    	return $this->hasMany('App\Organization');
    }
}
