<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftRedemption extends Model
{
    use HasFactory;
    protected $table = 'gift_redemptions';
    protected $fillable = [
        'cost', 'user_id', 'child_id', 'gift_id'
    ];

    public function gift() {
        return $this->belongsTo(Gift::class);
    }

    public function child() {
        return $this->belongsTo(Child::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
