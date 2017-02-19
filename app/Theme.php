<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    /**
	* @var string
	*/
	protected $table = 'themes';
	public $timestamps = false;

	public function plans()
    {
        return $this->hasMany('App\AttackPlan');
    }
}
