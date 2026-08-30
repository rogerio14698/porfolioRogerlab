@extends('components.app')

@php
    $profile = config('seo.profile');
    $defaultTitle = "{$profile['name']} | {$profile['job_title']} en Gijón";
    $defaultDescription = $profile['description'];
@endphp

@section('title', $pageTitle ?? $defaultTitle)

@section('meta_description', $pageMetaDescription ?? $defaultDescription)

@section('robots_meta', $robotsMeta ?? 'index,follow')

@section('og_title', $pageTitle ?? $defaultTitle)

@section('og_description', $pageMetaDescription ?? $defaultDescription)

@section('twitter_title', $pageTitle ?? $defaultTitle)

@section('twitter_description', $pageMetaDescription ?? $defaultDescription)

@section('content')
    {{-- Aqui va el header y dentro el navegador ya modificado --}}
    @include('components.main')
@endsection