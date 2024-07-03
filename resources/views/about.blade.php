@extends('layouts.main')

@section("container")
<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-md-1 mt-5">
            @if(auth()->check())
                @if(auth()->user()->role === 'admin')
                    <a href="/dashboardadmin" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                @else
                    <a href="/dashboard" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                @endif
            @else
                <a href="/" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            @endif
        </div>
        <div class="col-md-11 mt-5">
            <h2>{{ $title }}</h2>
        </div>
    </div>
    <div class="container p-3 mt-4" style="background-color: #253793; border-radius: 10px">
        <div class="img-container text-center mb-3">
            <img src="{{ asset('img/about.jpg') }}" class="img-fluid" alt="Bandung City View I">
        </div>
        <p class="text-white">
            Bandung City View I adalah perumahan modern yang terletak di jantung kota Bandung. Dikelilingi oleh fasilitas lengkap dan lingkungan yang asri, perumahan ini menawarkan kenyamanan dan keamanan bagi penghuninya. Setiap unit dilengkapi dengan teknologi terbaru untuk mendukung gaya hidup modern.
        </p>
    </div>
</div>

<style>
    .img-container {
        width: 100%;
        overflow: hidden;
    }

    .img-container img {
        width: 100%;
        max-height: 400px;
        object-fit: cover; 
    }

    nav.navbar {
        position: fixed;
        width: 100%;
        top: 0;
        z-index: 1000;
    }
</style>
@endsection
