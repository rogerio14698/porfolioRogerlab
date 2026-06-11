<?php

use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;

if (! function_exists('renderSection')) {
    /**
     * Render a section page with SEO metadata.
     */
    function renderSection(
        string $section,
        ?string $pageTitle = null,
        ?string $pageMetaDescription = null,
        int $status = 200,
        ?string $robotsMeta = null
    ): Response {
        $view = view('index', compact(
            'section',
            'pageTitle',
            'pageMetaDescription',
            'robotsMeta'
        ));

        return response($view, $status);
    }
}
