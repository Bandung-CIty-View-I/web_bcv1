@extends('layouts.main')
<body style="background: linear-gradient(to bottom right, #253793 45%, #F4D772); margin: 0; padding: 0;">
@section('container')
<div class="container">
    <div class="row align-items-center" style="min-height: 60vh;">
        <div class="col-12 text-center mt-5">
            <h1 class="display-1 text-white">{{ $name }}</h1>
            <h5 class="text-white">Perumahan Bandung City View I</h5>
            <p class="text-white">Tempat tinggal nyaman dan aman dengan fasilitas modern dan lingkungan yang asri.</p>
        </div>
        <div class="col-12 text-center">
            <a href="/about" class="btn btn-warning">Learn More</a>
        </div>
    </div>
</div>
@endsection
