<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ResourceDownload extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'file_path',
        'download_name',
        'download_count',
    ];

    protected function casts(): array
    {
        return [
            'download_count' => 'integer',
        ];
    }

    public static function findBySlug(string $slug): ?self
    {
        return static::query()->where('slug', $slug)->first();
    }

    public function absolutePath(): string
    {
        return public_path($this->file_path);
    }

    public function existsOnDisk(): bool
    {
        return is_file($this->absolutePath());
    }

    public function recordDownload(): void
    {
        DB::table($this->getTable())
            ->where('id', $this->id)
            ->increment('download_count');

        $this->refresh();
    }
}
