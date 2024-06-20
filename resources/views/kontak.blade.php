@extends('layouts.main')

@section('container')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <h2>{{ $title }}</h2>
        <br><br>

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h5 class="welcome-message">Kontak Staffs Warga BCV I</h5>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Anta</h5>
                        <p class="card-text">+62 812 3451 7931</p>
                        <a href="#" class="btn btn-primary">Hubungi</a>
                    </div>
                    <div class="card-body">

                        <h5 class="card-title">Anti</h5>
                        <p class="card-text">+62 812 3451 7935</p>
                        <a href="#" class="btn btn-primary">Hubungi</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

 
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>

@endsection

