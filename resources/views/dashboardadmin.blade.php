@extends('layouts.main')

@section('container')
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

            <div class="p-3 mb-2" style="background-color: #253793; border-radius: 10px">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('img/Profile.png') }}" class="img-fluid mr-2" style="max-height: 100px; border-radius: 40px; padding: 10px">
                    <h5 class="mb-0 text-white" id="nama-user-sidebar"></h5>
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
            <div class="card main-card">
                <div class="card-body main-card-body">
                    <div class="card greeting-card mb-4">
                        <div class="card-body">
                            <h5 class="card-title text-center">Selamat Datang, <span id="nama-user"></span></h5>
                        </div>
                    </div>
                    <div class="row mx-3 mb-4">
                        <div class="col-md-12">
                            <div class="card-body" style="background-color: #D9D9D9; border-radius: 15px; position: relative;">
                                <h5 class="card-title">Informasi Kondisi Alat</h5>
                                <div class="row">
                                    <div class="col-md-3 d-flex align-items-center">
                                        <div style="margin-right: 10px;">
                                            <img id="gambar-reservoir-atas" src="{{ asset('img/cylinder-off.png') }}" class="img-fluid" style="max-height: 60px; border-radius: 30px; padding: 5px">
                                        </div>
                                        <div style="padding-right: 5px;">
                                            <h6 class="card-title">Reservoir Atas</h6>
                                        </div>
                                    </div>
                                    <div class="col-md-3 d-flex align-items-center">
                                        <div style="margin-right: 10px;">
                                            <img id="gambar-reservoir-bawah" src="{{ asset('img/cylinder-off.png') }}" class="img-fluid" style="max-height: 60px; border-radius: 30px; padding: 5px">
                                        </div>
                                        <div style="padding-right: 5px;">
                                            <h6 class="card-title">Reservoir Bawah</h6>
                                        </div>
                                    </div>
                                    <div class="col-md-3 d-flex align-items-center">
                                        <div style="margin-right: 10px;">
                                            <img id="gambar2" src="{{ asset('img/lightbulb-off.png') }}" class="img-fluid" style="max-height: 60px; border-radius: 30px; padding: 5px">
                                        </div>
                                        <div style="padding-right: 5px;">
                                            <h6 class="card-title">Summersible Besar</h6>
                                        </div>
                                    </div>
                                    <div class="col-md-3 d-flex align-items-center">
                                        <div style="margin-right: 10px;">
                                            <img id="gambar3" src="{{ asset('img/lightbulb-off.png') }}" class="img-fluid" style="max-height: 60px; border-radius: 30px; padding: 5px">
                                        </div>
                                        <div style="padding-right: 5px;">
                                            <h6 class="card-title">Summersible Kecil</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mx-3 mb-4">
                        <div class="col-md-6">
                            <div class="card-body" style="background-color: #D9D9D9; border-radius: 15px; position: relative;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 class="card-title">Edit Jadwal Ambil Sampah</h5>
                                        <form id="edit-schedule-form">
                                            <div class="form-group mb-3">
                                                <label for="hari">Hari</label>
                                                <select class="form-control" id="hari" name="hari">
                                                    <option value="Senin">Senin</option>
                                                    <option value="Selasa">Selasa</option>
                                                    <option value="Rabu">Rabu</option>
                                                    <option value="Kamis">Kamis</option>
                                                    <option value="Jumat">Jumat</option>
                                                    <option value="Sabtu">Sabtu</option>
                                                    <option value="Minggu">Minggu</option>
                                                </select>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="waktu">Waktu</label>
                                                <input type="time" class="form-control" id="waktu" name="waktu">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </form>
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="card-title">Hapus Jadwal Ambil Sampah</h5>
                                        <form id="delete-schedule-form">
                                            <div class="form-group mb-3">
                                                <label for="delete-hari">Hari</label>
                                                <select class="form-control" id="delete-hari" name="delete-hari">
                                                    <option value="Senin">Senin</option>
                                                    <option value="Selasa">Selasa</option>
                                                    <option value="Rabu">Rabu</option>
                                                    <option value="Kamis">Kamis</option>
                                                    <option value="Jumat">Jumat</option>
                                                    <option value="Sabtu">Sabtu</option>
                                                    <option value="Minggu">Minggu</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card-body" style="background-color: #D9D9D9; border-radius: 15px; position: relative;">
                                <h5 class="card-title">Jadwal Ambil Sampah</h5>
                                <div style="overflow-x: auto;">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Hari</th>
                                                <th>Senin</th>
                                                <th>Selasa</th>
                                                <th>Rabu</th>
                                                <th>Kamis</th>
                                                <th>Jumat</th>
                                                <th>Sabtu</th>
                                                <th>Minggu</th>
                                            </tr>
                                        </thead>
                                        <tbody id="schedule-list">
                                            <tr>
                                                <td>Waktu</td>
                                                <td id="senin-waktu"></td>
                                                <td id="selasa-waktu"></td>
                                                <td id="rabu-waktu"></td>
                                                <td id="kamis-waktu"></td>
                                                <td id="jumat-waktu"></td>
                                                <td id="sabtu-waktu"></td>
                                                <td id="minggu-waktu"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="module" src="{{ asset('js/firebase-config.js') }}"></script>
    <script type="module">
        $(document).ready(function() {
            function formatRupiah(angka) {
                return 'Rp' + angka.toLocaleString('id-ID');
            }

            $.ajax({
                url: '/api/user/profile',
                type: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                },
                success: function(response) {
                    $('#nama-user').text(response.nama);
                    $('#nama-user-sidebar').text(response.nama);
                },
                error: function(xhr, status, error) {
                    console.error('Failed to fetch profile data:', error);
                }
            });

            // Fetch all schedules
            $.ajax({
                url: '/api/schedule',
                type: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                },
                success: function(response) {
                    response.forEach(function(schedule) {
                        $('#' + schedule.hari.toLowerCase() + '-hari').text(schedule.hari);
                        $('#' + schedule.hari.toLowerCase() + '-waktu').text(schedule.waktu);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Failed to fetch schedules:', error);
                }
            });

            $('#edit-schedule-form').on('submit', function(e) {
                e.preventDefault();

                var hari = $('#hari').val();
                var waktu = $('#waktu').val();

                $.ajax({
                    url: '/api/schedule/add',
                    type: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('token')
                    },
                    data: {
                        hari: hari,
                        waktu: waktu
                    },
                    success: function(response) {
                        $('#' + hari.toLowerCase() + '-hari').text(hari);
                        $('#' + hari.toLowerCase() + '-waktu').text(waktu);
                        $('#waktu').val('--:--');
                    },
                    error: function(xhr, status, error) {
                        console.error('Failed to update schedule:', error);
                    }
                });
            });

            $('#delete-schedule-form').on('submit', function(e) {
                e.preventDefault();

                var hari = $('#delete-hari').val();

                $.ajax({
                    url: '/api/schedule/day',
                    type: 'DELETE',
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('token')
                    },
                    data: {
                        hari: hari
                    },
                    success: function(response) {
                        $('#' + hari.toLowerCase() + '-hari').text('');
                        $('#' + hari.toLowerCase() + '-waktu').text('');
                    },
                    error: function(xhr, status, error) {
                        console.error('Failed to delete schedule:', error);
                    }
                });
            });
        });
    </script>
</div>
@endsection
