@extends('components.app')

@section('title', $pageTitle ?? ('RogerLab | Desarrollador Web Freelance en ' . config('seo.city')))

@section('meta_description', $pageMetaDescription ?? ('Desarrollo web profesional en ' . config('seo.city') . ' y ' . config('seo.region') . '. Especialista en paginas web, landing pages y aplicaciones web a medida para negocios.'))

@section('robots_meta', $robotsMeta ?? 'index,follow')

@section('og_title', $pageTitle ?? ('RogerLab | Desarrollador Web Freelance en ' . config('seo.city')))

@section('og_description', $pageMetaDescription ?? ('Desarrollo web profesional en ' . config('seo.city') . ' y ' . config('seo.region') . '. Especialista en paginas web, landing pages y aplicaciones web a medida para negocios.'))

@section('twitter_title', $pageTitle ?? ('RogerLab | Desarrollador Web Freelance en ' . config('seo.city')))

@section('twitter_description', $pageMetaDescription ?? ('Desarrollo web profesional en ' . config('seo.city') . ' y ' . config('seo.region') . '. Especialista en paginas web, landing pages y aplicaciones web a medida para negocios.'))

@section('content')

    @include('components.main')
@endsection