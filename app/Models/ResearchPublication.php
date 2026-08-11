<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResearchPublication extends Model
{
    protected $fillable = [
        'import_key',
        'title',
        'authors',
        'tenwek_authors',
        'journal',
        'publication_type',
        'doi',
        'pmid',
        'specialty',
        'full_citation',
        'year',
        'url',
        'abstract',
        'sort_order',
        'is_visible',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
    ];

    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    public function scopeOrdered($query)
    {
        return $query
            ->orderByDesc('year')
            ->orderBy('sort_order')
            ->orderBy('title');
    }

    public function publisherUrl(): ?string
    {
        if (filled($this->url)) {
            return $this->url;
        }

        if (filled($this->doi)) {
            $doi = $this->doi;

            return str_starts_with($doi, 'http') ? $doi : 'https://doi.org/'.$doi;
        }

        if (filled($this->pmid)) {
            return 'https://pubmed.ncbi.nlm.nih.gov/'.preg_replace('/\D/', '', $this->pmid).'/';
        }

        return null;
    }
}
