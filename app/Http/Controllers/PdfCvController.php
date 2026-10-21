<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PdfCvController extends Controller
{
    public function __invoke(Request $request, string $language): BinaryFileResponse
    {
        $filename = match ($language) {
            'english' => 'RogerioLucas-cv-English.pdf',
            'spanish' => 'RogerioLucas-Spanish-cv.pdf',
            default => abort(404),
        };
        $path = resource_path('views/components/pdf-cv/'.$filename);
        abort_unless(is_file($path), 404);

        $response = response()->file($path, ['Content-Type' => 'application/pdf']);
        $response->setContentDisposition('inline', $filename);
        $response->setPublic()->setMaxAge(3600)->setAutoEtag();
        $response->isNotModified($request);

        return $response;
    }
}
