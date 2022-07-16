<?php

namespace App\Domain\Notifications\FirebaseDeviceToken\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FirebaseDeviceToken extends Model
{
    protected $table = 'firebase_device_tokens';

    use HasFactory;

    protected $fillable = [
        'user_id',
        'device_token',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
