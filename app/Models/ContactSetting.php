<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ContactSetting extends Model
{
    public const CACHE_KEY = 'contact_setting.current';

    protected $fillable = [
        'address',
        'phone',
        'email',
        'emergency_phone',
        'appointments_phone',
        'whatsapp',
        'fax',
        'map_embed_url',
    ];

    protected static function booted(): void
    {
        static::saved(fn () => self::forgetCache());
        static::deleted(fn () => self::forgetCache());
    }

    public static function current(): self
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            return self::query()->first() ?? self::query()->create([
                'address' => config('ctc.contact.address'),
                'phone' => config('ctc.contact.phone'),
                'email' => config('ctc.contact.email'),
                'emergency_phone' => config('ctc.contact.emergency'),
                'map_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d255328.57190435287!2d35.412123193156454!3d-0.713531316170022!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182b99e773d0b419%3A0x9a894bffe3e322cd!2sAGC%20Tenwek%20Cardiothoracic%20Centre!5e0!3m2!1sen!2ske!4v1778251323615!5m2!1sen!2ske',
            ]);
        });
    }

    public static function forgetCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}

