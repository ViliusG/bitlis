<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortURL extends Model
{
    use HasFactory;

    protected $table = 'short_urls';

    protected $fillable = ['user_id', 'original_url', 'short_url', 'expires_at'];
}
