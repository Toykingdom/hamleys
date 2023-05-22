<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    use HasFactory;
    protected $table = 'gifts';
    protected $fillable = [
        'name', 'type', 'cost'
    ];

    public function redemptions()
    {
        return $this->hasMany(GiftRedemption::class);
    }
}
