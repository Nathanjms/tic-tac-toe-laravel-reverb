<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'player_one_id',
        'player_two_id',
        'state',
    ];

    protected $casts = [
        'state' => 'array',
    ];

    protected $appends = [
        'human_timestamp',
    ];

    public function playerOne(): BelongsTo
    {
        return $this->belongsTo(User::class, 'player_one_id');
    }

    public function playerTwo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'player_two_id');
    }

    public function getHumanTimestampAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }
}
