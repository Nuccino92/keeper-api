<?php

namespace App\Models\Event;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start', //TIMESTAMPTZ
        'end', //TIMESTAMPTZ
        'location',
        'event_type',
        'season_team_id', // ref to season_team pk
        'created_by',
        'eventable_id', // ref to other table, like game
    ];

    public function eventable()
    {
        return $this->morphTo();
    }

    public function game()
    {
        if ($this->event_type === 'game') {
            return $this->belongsTo(Game::class, 'eventable_id');
        }

        return null;
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function season()
    {
        return $this->belongsTo(Season::class);
    }


    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
