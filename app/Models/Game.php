<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = ['player1_id', 'board', 'winner_id', 'player2_win'];

    public function player1()
    {
        return $this->belongsTo(User::class, 'player1_id');
    }

    public function winner()
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    public function moves()
    {
        return $this->hasMany(Move::class);
    }
}
