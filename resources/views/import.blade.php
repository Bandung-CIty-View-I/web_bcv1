@extends('layouts.main')

@section('container')
    <h1>Import User Data</h1>
    <h3>Masukkan hanya file .xlsx</h3>

    @if(session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="color: red;">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('user.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="file">Upload File Excel</label>
        <input type="file" name="file" id="file" accept=".xlsx, .xls, .csv" required>
        <button type="submit">Import</button>
    </form>
    <a href="{{ route('download.template') }}" class="mt-4 btn btn-custom" style="background-color: #007bff; border: none;">Download Template</a>

@endsection
