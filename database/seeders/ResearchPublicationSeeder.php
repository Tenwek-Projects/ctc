<?php

namespace Database\Seeders;

use App\Models\ResearchPublication;
use Illuminate\Database\Seeder;

class ResearchPublicationSeeder extends Seeder
{
    public function run(): void
    {
        $path = $this->resolveCsvPath();
        if ($path === null) {
            $this->command?->warn('Publications CSV not found — skipping ResearchPublicationSeeder.');

            return;
        }

        $handle = fopen($path, 'r');
        if ($handle === false) {
            $this->command?->error('Could not open publications CSV.');

            return;
        }

        // Row 1 = disclaimer note, row 2 = column headers.
        fgetcsv($handle);
        $headers = fgetcsv($handle);
        if (! is_array($headers)) {
            fclose($handle);
            $this->command?->error('Publications CSV is missing headers.');

            return;
        }

        $headers = array_map(fn ($h) => trim((string) $h), $headers);
        $sortOrder = 10;
        $imported = 0;

        while (($row = fgetcsv($handle)) !== false) {
            if ($this->isEmptyRow($row)) {
                continue;
            }

            $data = $this->mapRow($headers, $row);
            if ($data === null) {
                continue;
            }

            ResearchPublication::updateOrCreate(
                ['import_key' => $data['import_key']],
                array_merge($data, [
                    'sort_order' => $sortOrder,
                    'is_visible' => true,
                ])
            );

            $sortOrder += 10;
            $imported++;
        }

        fclose($handle);

        $this->command?->info("Imported {$imported} research publication(s) from CSV.");
    }

    private function resolveCsvPath(): ?string
    {
        foreach ([
            base_path('AGC Tenwek Publications - Publications.csv'),
            database_path('seeders/data/publications.csv'),
        ] as $path) {
            if (is_readable($path)) {
                return $path;
            }
        }

        return null;
    }

    /**
     * @param  array<int, string|null>  $headers
     * @param  array<int, string|null>  $row
     * @return array<string, mixed>|null
     */
    private function mapRow(array $headers, array $row): ?array
    {
        $values = [];
        foreach ($headers as $index => $header) {
            $values[$header] = trim((string) ($row[$index] ?? ''));
        }

        $title = $values['Title'] ?? '';
        $year = $values['Year'] ?? '';

        if ($title === '' || $year === '') {
            return null;
        }

        $doi = $this->normalizeDoi($values['DOI'] ?? '');
        $url = $values['Publisher URL'] ?? '';
        if ($url === '' && $doi !== '') {
            $url = str_starts_with($doi, 'http') ? $doi : 'https://doi.org/'.$doi;
        }

        $importKey = hash('sha256', mb_strtolower($year.'|'.$title.'|'.($doi ?: ($values['Full Citation'] ?? ''))));

        return [
            'import_key' => $importKey,
            'year' => mb_substr($year, 0, 4),
            'title' => $title,
            'authors' => $values['Authors as Published'] ?: null,
            'tenwek_authors' => $values['Tenwek Author(s) / Collaborator(s)'] ?: null,
            'journal' => $values['Journal / Source'] ?: null,
            'publication_type' => $values['Publication Type'] ?: null,
            'doi' => $doi ?: null,
            'pmid' => $values['PMID'] ?: null,
            'url' => $url ?: null,
            'specialty' => $this->normalizeSpecialty($values['Specialty'] ?? ''),
            'full_citation' => $values['Full Citation'] ?: null,
            'abstract' => null,
        ];
    }

    private function normalizeDoi(string $value): string
    {
        $value = trim($value);
        if ($value === '') {
            return '';
        }

        $value = preg_replace('#^https?://(dx\.)?doi\.org/#i', '', $value) ?? $value;
        $value = preg_replace('#^doi:\s*#i', '', $value) ?? $value;

        if (str_starts_with($value, 'ttps://')) {
            $value = 'h'.$value;
        }

        return trim($value);
    }

    private function normalizeSpecialty(string $value): ?string
    {
        $value = trim(preg_replace('/\s+/u', ' ', $value) ?? '');

        return $value !== '' ? $value : null;
    }

    /**
     * @param  array<int, string|null>  $row
     */
    private function isEmptyRow(array $row): bool
    {
        foreach ($row as $cell) {
            if (trim((string) $cell) !== '') {
                return false;
            }
        }

        return true;
    }
}
