<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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
        // Priority: cardiac / cardiothoracic / perfusion first, then endoscopy / GI, then everything else.
        return $query
            ->orderByRaw("
                CASE
                    WHEN specialty LIKE '%Cardiothoracic%'
                      OR specialty LIKE '%Cardiology%'
                      OR specialty LIKE '%Perfusion%'
                      OR title LIKE '%cardiac%'
                      OR title LIKE '%cardio%'
                      OR title LIKE '%heart%'
                      OR title LIKE '%valve%'
                      OR title LIKE '%CABG%'
                      OR title LIKE '%congenital%'
                    THEN 0
                    WHEN specialty LIKE '%Endoscopy%'
                      OR specialty LIKE '%Gastroenterology%'
                      OR title LIKE '%endoscop%'
                      OR title LIKE '%oesophag%'
                      OR title LIKE '%esophag%'
                      OR title LIKE '%colonoscop%'
                      OR title LIKE '%bronchoscop%'
                    THEN 1
                    ELSE 2
                END
            ")
            ->orderByDesc('year')
            ->orderBy('sort_order')
            ->orderBy('title');
    }

    /**
     * Specialty labels sorted with cardiac & endoscopy groups first (for filter UI).
     *
     * @param  \Illuminate\Support\Collection<int, string>  $specialties
     * @return \Illuminate\Support\Collection<int, string>
     */
    public static function prioritizeSpecialtyLabels($specialties)
    {
        return $specialties->sortBy(function (string $specialty) {
            $s = mb_strtolower($specialty);
            if (str_contains($s, 'cardiothoracic') || str_contains($s, 'cardiology') || str_contains($s, 'perfusion')) {
                return '0-'.$specialty;
            }
            if (str_contains($s, 'endoscopy') || str_contains($s, 'gastroenterology')) {
                return '1-'.$specialty;
            }

            return '2-'.$specialty;
        })->values();
    }

    /**
     * @param  Builder<self>  $query
     */
    public function scopeFiltered($query, ?string $search, ?string $year, ?string $specialty, ?string $type): Builder
    {
        if (filled($search)) {
            $term = '%'.addcslashes(trim($search), '%_\\').'%';
            $query->where(function (Builder $inner) use ($term) {
                $inner->where('title', 'like', $term)
                    ->orWhere('authors', 'like', $term)
                    ->orWhere('tenwek_authors', 'like', $term)
                    ->orWhere('journal', 'like', $term)
                    ->orWhere('specialty', 'like', $term)
                    ->orWhere('full_citation', 'like', $term);
            });
        }

        if (filled($year)) {
            $query->where('year', $year);
        }

        if (filled($specialty)) {
            $query->where('specialty', $specialty);
        }

        if (filled($type)) {
            $query->where('publication_type', $type);
        }

        return $query;
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

    public function doiUrl(): ?string
    {
        if (! filled($this->doi)) {
            return null;
        }

        return str_starts_with($this->doi, 'http') ? $this->doi : 'https://doi.org/'.$this->doi;
    }

    public function pubmedUrl(): ?string
    {
        if (! filled($this->pmid)) {
            return null;
        }

        return 'https://pubmed.ncbi.nlm.nih.gov/'.preg_replace('/\D/', '', $this->pmid).'/';
    }
}
