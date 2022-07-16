<?php

namespace App\Domain\General\Coordinate\Model;

use Illuminate\Database\Eloquent\Model;

class Coordinate extends Model
{
	protected $table = 'coordinates';

    protected $fillable = [
    	'longitude',
	    'latitude',
	    'user_id',
	];
    
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
