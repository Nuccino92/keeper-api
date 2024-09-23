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
        'start',
        'end',
        'location',
        'event_type',
        'team_id',
        'created_by',
        'eventable_id',
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

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
