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

@if (!empty($ogImage))
    @section('og_image', $ogImage)
    @section('twitter_image', $ogImage)
@endif

@if (!empty($schemaJsonLd))
    @section('schema_json_ld')
        {!! json_encode($schemaJsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    @endsection
@endif

@section('content')
    {{-- Aqui va el header y dentro el navegador ya modificado --}}
    @include('components.main')
@endsection