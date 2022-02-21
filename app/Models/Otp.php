<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    use HasFactory;

    protected $fillable = [
        'otp',
        'is_used',
        'expires_at'
        ];
        protected $casts = [
            'expires_at' => 'datetime',
            'is_used' => 'boolean'
        ];
        protected $hidden = [
            'otp'
        ];
        
        public function user() {
            return $this->belongsTo(User::class);
        }
        
}
