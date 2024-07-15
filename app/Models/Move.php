<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Move extends Model
{
    use HasFactory;

    protected $fillable = ['player_id', 'player', 'position'];

    public function game()
    {
        return $this->belongsTo(Player::class);
    }
}
