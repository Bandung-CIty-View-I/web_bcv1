@extends('layouts.main')
<body style="background: linear-gradient(to bottom right, #394E69 45%, #F4D772); margin: 0; padding: 0;">
@section('container')
<div class="container">
    <div class="row align-items-center" style="min-height: 60vh;">
        <div class="col-md-6">
            <h1 class="display-1 text-white">{{ $name }}</h1>
            <h5 class="text-white">Perumahan Bandung City View I</h5>
            <p class="text-white">Tempat tinggal nyaman dan aman dengan fasilitas modern dan lingkungan yang asri.</p>
        </div>
        <div class="col-md-6 d-flex flex-column align-items-center">
            <div id="cardCarousel" class="carousel slide w-100" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="card mb-4 shadow-sm">
                            <img src="{{ asset('img/ornament.jpg') }}" class="card-img-top" alt="Ornament 1">
                            <div class="card-body">
                                <h5 class="card-title">Fasilitas Modern</h5>
                                <p class="card-text">Bandung City View I menyediakan fasilitas modern yang dapat menunjang kehidupan Anda.</p>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="card mb-4 shadow-sm">
                            <img src="{{ asset('img/ornament2.jpg') }}" class="card-img-top" alt="Ornament 2">
                            <div class="card-body">
                                <h5 class="card-title">Lingkungan Asri</h5>
                                <p class="card-text">Menikmati lingkungan yang asri dan sejuk di Bandung City View I.</p>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="card mb-4 shadow-sm">
                            <img src="{{ asset('img/ornament3.jpg') }}" class="card-img-top" alt="Ornament 3">
                            <div class="card-body">
                                <h5 class="card-title">Keamanan Terjamin</h5>
                                <p class="card-text">Dengan sistem keamanan yang terjamin, Anda dapat tinggal dengan nyaman dan aman.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#cardCarousel" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </a>
                <a class="carousel-control-next" href="#cardCarousel" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection



