<?php

namespace App\Http\Controllers;

use App\Models\ResourceDownload;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ResourceDownloadController extends Controller
{
    public function download(string $slug): BinaryFileResponse
    {
        $resource = ResourceDownload::findBySlug($slug);

        abort_if(! $resource, 404);
        abort_unless($resource->existsOnDisk(), 404);

        $resource->recordDownload();

        $downloadName = $resource->download_name ?: basename($resource->file_path);

        return response()->download($resource->absolutePath(), $downloadName, [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
