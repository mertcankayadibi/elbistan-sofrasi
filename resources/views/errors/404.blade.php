@extends('layouts.app')

@php($seo = \App\Support\Seo::notFound())

@section('title', 'Sayfa bulunamadı')

@section('content')
    <section class="flex min-h-[60vh] items-center bg-krem py-20">
        <div class="container-page max-w-2xl">
            <p class="eyebrow mb-5">ELBİSTAN SOFRASI</p>
            <h1>Aradığınız sayfa bulunamadı.</h1>
            <p class="mt-6 max-w-xl text-base leading-7 text-fume/70">Bu sayfa taşınmış veya artık mevcut olmayabilir. Kilerimize dönüp yöresel lezzetleri keşfedebilirsiniz.</p>
            <a href="{{ route('home') }}" class="btn-primary mt-8">Ana sayfaya dön</a>
        </div>
    </section>
@endsection
