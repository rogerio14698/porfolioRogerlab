@extends('components.app')

@section('title', $pageTitle ?? 'RogerLab | Desarrollador Full Stack titulado en DAW')

@section('meta_description', $pageMetaDescription ?? 'Portfolio de Rogério Lucas, desarrollador Full Stack titulado en DAW. Proyectos con Laravel, PHP, JavaScript, bases de datos, Docker y AWS orientados a código mantenible y trabajo en equipo.')

@section('robots_meta', $robotsMeta ?? 'index,follow')

@section('og_title', $pageTitle ?? 'RogerLab | Desarrollador Full Stack titulado en DAW')

@section('og_description', $pageMetaDescription ?? 'Portfolio de Rogério Lucas, desarrollador Full Stack titulado en DAW. Proyectos con Laravel, PHP, JavaScript, bases de datos, Docker y AWS orientados a código mantenible y trabajo en equipo.')

@section('twitter_title', $pageTitle ?? 'RogerLab | Desarrollador Full Stack titulado en DAW')

@section('twitter_description', $pageMetaDescription ?? 'Portfolio de Rogério Lucas, desarrollador Full Stack titulado en DAW. Proyectos con Laravel, PHP, JavaScript, bases de datos, Docker y AWS orientados a código mantenible y trabajo en equipo.')

@section('content')
    {{-- Aqui va el header y dentro el navegador ya modificado --}}
    @include('components.main')
@endsection