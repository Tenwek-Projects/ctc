<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Support\PublicAssetUrl;

class TeamMember extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'credentials',
        'title',
        'team_group',
        'specialization',
        'bio',
        'photo',
        'sort_order',
        'is_visible',
        'show_on_homepage',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'show_on_homepage' => 'boolean',
    ];

    public function getPhotoUrlAttribute(): ?string
    {
        return PublicAssetUrl::toUrl($this->photo);
    }

    public function getTeamGroupLabelAttribute(): ?string
    {
        if (! filled($this->team_group)) {
            return null;
        }

        $groups = config('ctc.team_groups', []);

        return $groups[$this->team_group] ?? str_replace('_', ' ', ucwords($this->team_group, '_'));
    }

    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    public function scopeOnHomepage($query)
    {
        return $query->where('show_on_homepage', true);
    }

    public function scopeOrdered($query)
    {
        $groups = array_keys(config('ctc.team_groups', []));

        if ($groups !== []) {
            $cases = collect($groups)
                ->map(fn (string $key, int $index) => 'WHEN ? THEN '.$index)
                ->implode(' ');

            $query->orderByRaw(
                'CASE team_group '.$cases.' ELSE '.count($groups).' END',
                $groups
            );
        }

        return $query->orderBy('sort_order')->orderBy('name')->orderBy('id');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * @return array<int, string>
     */
    public static function teamGroupKeys(): array
    {
        return array_keys(config('ctc.team_groups', []));
    }
}
