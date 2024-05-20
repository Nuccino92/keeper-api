<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

use App\Models\Cashier\Subscription;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class League extends Model
{
    use HasFactory, HasSlug;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    //TODO: need to add a hasWebsite property
    protected $fillable = [
        'owner_id',
        'name',
        'logo',
        'slug',
        'description',
        'primary_color',
        'secondary_color',
        'organization_id'
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(User::class, 'organization_id');
    }

    public function subscription(): HasOne
    {
        return $this->hasOne(Subscription::class, 'league_id');
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(50)
            ->usingSeparator('-');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function isOwner(User $user): bool
    {
        return $this->owner_id === $user->id;
    }
}
