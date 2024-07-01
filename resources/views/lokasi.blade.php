@extends('layouts.main')

@section("container")
<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-md-1">
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
        <div class="col-md-11">
            <h2>{{ $title }}</h2>
        </div>
    </div>
    <div class="container p-3 mt-4" style="background-color: #253793; border-radius: 10px">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6856.682199129488!2d107.67244013310278!3d-6.897411577166335!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68dd647441eafd%3A0xf999867608e97747!2sBandung%20City%20View%20Residence!5e0!3m2!1sen!2sid!4v1716364235108!5m2!1sen!2sid" width="100%" height="700px" style="border:5px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
@endsection
