<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'token',
        'number',
        'expire',
        'is_verified',
        'is_default',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'is_default'  => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
