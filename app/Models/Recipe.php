<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Postimage;
use App\Models\Comment;
use App\Models\Favorite;
use App\Models\User;
use App\Models\Type;
use App\Models\Cuisine;
class Recipe extends Model
{
    use HasFactory;
    public function images() {
        return $this->hasMany(Postimage::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function comments() {
        return $this->hasMany(Comment::class);
    }
    public function favorites() {
        return $this->hasMany(Favorite::class);
    }
    public function cuisine() {
        return $this->belongsTo(Cuisine::class);
    }
    public function type() {
        return $this->belongsTo(Type::class);
    }
}
