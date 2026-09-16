<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Blog::latest()->get();

        return renderSection(
            'blog',
            'Artículos y reflexiones técnicas | RogerLab',
            'Notas sobre aprendizaje técnico, mantenimiento, código heredado y desarrollo web desde una perspectiva profesional y honesta.',
            200,
            null,
            compact('articles')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        $title = $blog->seo_title ?: $blog->title;
        $description = $blog->seo_description ?: Str::limit(strip_tags($blog->content), 155);
        $image = $blog->image ? asset($blog->image) : asset(config('seo.profile.image'));
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $blog->title,
            'description' => $description,
            'url' => route('blog.show', $blog),
            'image' => [$image],
            'author' => [
                '@type' => 'Person',
                'name' => config('seo.profile.name'),
            ],
            'datePublished' => $blog->created_at?->toIso8601String(),
            'dateModified' => $blog->updated_at?->toIso8601String(),
        ];

        return renderSection(
            'blog',
            $title,
            $description,
            200,
            null,
            [
                'article' => $blog,
                'metaKeywords' => $blog->seo_keywords,
                'ogImage' => $image,
                'schemaJsonLd' => $schema,
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        //
    }
}
