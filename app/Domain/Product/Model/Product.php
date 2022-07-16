<?php

namespace App\Domain\Product\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	protected $table = 'products';

    protected $fillable = [
    	'name',
        'description',
        'image',
        'user_id',
	];

    public function getImageAttribute(){
        if(!isset($this->attributes['image'])) return null;
        return str_starts_with($this->attributes['image'], 'http')
                ? $this->attributes['image']
                : url('storage') . '/' . $this->attributes['image'];
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
