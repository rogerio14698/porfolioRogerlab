@extends('components.app')

@php
    $profile = config('seo.profile');
    $defaultTitle = "{$profile['name']} | {$profile['job_title']} en Gijón";
    $defaultDescription = $profile['description'];
@endphp

@section('title', $pageTitle ?? $defaultTitle)

@section('meta_description', $pageMetaDescription ?? $defaultDescription)

@if (!empty($metaKeywords))
    @section('meta_keywords', $metaKeywords)
@endif

@section('robots_meta', $robotsMeta ?? 'index,follow')

@section('og_title', $pageTitle ?? $defaultTitle)

@section('og_description', $pageMetaDescription ?? $defaultDescription)

@section('twitter_title', $pageTitle ?? $defaultTitle)

@section('twitter_description', $pageMetaDescription ?? $defaultDescription)

@if (!empty($canonicalUrl))
    @section('canonical', $canonicalUrl)
    @section('og_url', $canonicalUrl)
    @section('twitter_url', $canonicalUrl)
@endif

@section('og_type', $ogType ?? 'website')

@if (!empty($ogImage))
    @section('og_image', $ogImage)
    @section('twitter_image', $ogImage)
@endif

@if (!empty($schemaJsonLd))
    @section('schema_json_ld')
        <script type="application/ld+json">{!! json_encode($schemaJsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>
    @endsection
@endif

@section('content')
    {{-- Aqui va el header y dentro el navegador ya modificado --}}
    @include('components.main')
@endsection