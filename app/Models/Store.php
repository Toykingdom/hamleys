<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    protected $table = 'stores';
    protected $fillable = [
        'name', 'id'
    ];

    public function users() {
        return $this->belongsToMany(User::class, 'user_stores');
    }
}
