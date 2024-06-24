@extends('layouts.main')

@section('container')
    <div class="container-fluid">
        <div class="container-fluid mt-5">
            <div class="row">
                <div class="col-md-3">
                    <div class="d-flex justify-content-center">
                        <nav style="--bs-breadcrumb-divider: '>'" aria-current="page">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">Home</li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="p-3 mb-2 sidebar-card card" style="background-color: #394E69; border-radius: 10px">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('img/Profile.png') }}" class="img-fluid mr-2" style="max-height : 100px; border-radius: 40px; padding : 10px">
                        <h5 class="mb-0 text-white" id="nama-user"></h5>
                    </div>
                    <hr style="border-top: 2px solid #000000;">
                    <div class="p-2 mb-2">
                        <nav class="nav flex-column">
                            <a class="nav-link {{ ($title === "Dashboard") ? 'active' : ''}}" href="/dashboardadmin">Dashboard</a>
                            <a class="nav-link {{ ($title === "Lihat Tagihan IPL") ? 'active' : ''}}" href="/tagihanipladmin">Lihat Tagihan IPL</a>
                            <a class="nav-link {{ ($title === "Input Tagihan IPL") ? 'active' : ''}}" href="/tagihan">Input Tagihan IPL</a>
                            <a class="nav-link {{ ($title === "Kondisi Air dan Alat") ? 'active' : ''}}" href="/kondisi">Kondisi Air dan Alat</a>
                            <a class="nav-link {{ ($title === "Daftar Akun Warga") ? 'active' : ''}}" href="/daftarwarga">Daftar Akun Warga</a>
                            <a class="nav-link {{ ($title === "Profile Admin") ? 'active' : ''}}" href="/profileadmin">Profile</a>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card">
                    <div class="card-body" style="background-color: #394E69; border-radius: 10px; color: white;">
                        <h3 class="text-center">Masukkan Data Warga</h3>
                        <form id="register-warga-form">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama</label>
                                        <input type="text" class="form-control input-custom" id="nama" placeholder="Masukkan nama warga" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="blok" class="form-label">Blok</label>
                                        <select class="form-select input-custom" id="blok" required>
                                            <option selected>Pilih blok tempat tinggal warga</option>
                                            <option value="Daytona">Daytona</option>
                                            <option value="Estoril">Estoril</option>
                                            <option value="Imola">Imola</option>
                                            <option value="Indiana Polis">Indiana Polis</option>
                                            <option value="Interlagos">Interlagos</option>
                                            <option value="Laguna Seca">Laguna Seca</option>
                                            <option value="Le Mans">Le Mans</option>
                                            <option value="Monaco">Monaco</option>
                                            <option value="Monza">Monza</option>
                                            <option value="Silverstone">Silverstone</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nomorKavling" class="form-label">Nomor Kavling</label>
                                        <input type="text" class="form-control input-custom" id="nomorKavling" placeholder="Masukkan Nomor Kavling" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="noHP" class="form-label">No. HP</label>
                                        <input type="text" class="form-control input-custom" id="noHP" placeholder="Masukkan nomor HP warga" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control input-custom" id="email" placeholder="Masukkan email warga" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="idPelangganOnline" class="form-label">ID Pelanggan Online</label>
                                        <input type="text" class="form-control input-custom" id="idPelangganOnline" placeholder="Masukkan ID Pelanggan Online" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control input-custom" id="password" placeholder="Masukkan password warga" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                        <input type="password" class="form-control input-custom" id="password_confirmation" placeholder="Konfirmasi password warga" required>
                                    </div>
                                    <button type="submit" class="mt-4 btn btn-custom" style="background-color: #28a745; border: none;">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $.ajax({
                url: '/api/user/profile',
                type: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                },
                success: function(response) {
                    $('#nama-user').text(response.nama);
                },
                error: function(xhr, status, error) {
                    console.error('Failed to fetch profile data:', error);
                }
            });

            $('#register-warga-form').on('submit', function(e) {
                e.preventDefault();
                const data = {
                    nama: $('#nama').val(),
                    blok_cluster: $('#blok').val(),
                    nomor_kavling: $('#nomorKavling').val(),
                    no_hp: $('#noHP').val(),
                    email: $('#email').val(),
                    id_pelanggan_online: $('#idPelangganOnline').val(),
                    password: $('#password').val(),
                    password_confirmation: $('#password_confirmation').val()
                };

                $.ajax({
                    url: '/api/admin/daftarwarga',
                    type: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('token')
                    },
                    data: data,
                    success: function(response) {
                        alert('Warga berhasil didaftarkan');
                        $('#register-warga-form')[0].reset();
                    },
                    error: function(xhr, status, error) {
                        console.error('Failed to register warga:', error);
                        alert('Pendaftaran warga gagal');
                    }
                });
            });
        });
    </script>
@endsection
