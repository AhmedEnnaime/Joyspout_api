<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'user_id',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function medias()
    {
        return $this->hasMany(Media::class);
    }
}
