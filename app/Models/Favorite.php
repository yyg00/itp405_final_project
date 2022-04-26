<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;
    protected $table = 'favorites_by_users';
    public function user() 
    {
        return $this->belongsTo(User::class);
    }
    public function recipe() 
    {
        return $this->belongsTo(Recipe::class);
    }
}
