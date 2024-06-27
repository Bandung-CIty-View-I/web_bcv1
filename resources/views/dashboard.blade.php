@extends('layouts.main')

@section('container')
<div class="container-fluid">
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-3">
                <div class="d-flex justify-content-center">
                    <nav style="--bs-breadcrumb-divider: '>'" aria-current="page">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                               Home
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                               {{ $title }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="p-3 mb-2 sidebar-card">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('img/Profile.png') }}" class="img-fluid profile-img" alt="User Profile">
                    <h5 class="mb-0 text-white" id="nama-user-sidebar"></h5>
                </div>
                <hr>
                <nav class="nav flex-column">
                    <a class="nav-link {{ ($title === "Dashboard") ? 'active' : ''}}" href="/dashboard">Dashboard</a>
                    <a class="nav-link {{ ($title === "Tagihan IPL Warga") ? 'active' : ''}}" href="/detailtagihan">Detail Tagihan IPL</a>
                    <a class="nav-link {{ ($title === "Profile Warga") ? 'active' : ''}}" href="/profilewarga">Profile</a>
                </nav>
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
                        <div class="col-md-6">
                            <div class="card-body info-card" style="position: relative;">
                                <div class="d-flex align-items-center">
                                    <div style="margin-right: 30px;">
                                        <img src="{{ asset('img/trash.png') }}" class="img-fluid" style="max-height: 100px; border-radius: 40px; padding: 5px">
                                    </div>
                                    <div style="padding-right: 10px;">
                                        <h5 class="card-title">Jadwal ambil sampah</h5>
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Hari</th>
                                                    <th>Waktu</th>
                                                </tr>
                                            </thead>
                                            <tbody id="schedule-list">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card-body info-card" style="position: relative;">
                                <div class="d-flex align-items-center">
                                    <div style="margin-right: 30px;">
                                        <img src="{{ asset('img/receipt.png') }}" class="img-fluid" style="max-height: 100px; border-radius: 40px; padding: 5px">
                                    </div>
                                    <div style="padding-right: 10px;">
                                        <h5 class="card-title">IPL Bulan Ini</h5>
                                        <p class="card-text" id="meter-awal">Meter Awal: </p>
                                        <p class="card-text" id="meter-akhir">Meter Akhir: </p>
                                        <p class="card-text" id="meter-tagihan">Meter Tagihan bulan ini: </p>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button id="caraBayarBtn" class="btn btn-light border" data-bs-toggle="modal" data-bs-target="#caraBayarModal">
                                        <div class="d-flex">
                                            <i class="bi bi-wallet me-2"></i>
                                            <span>Cara Bayar</span>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mx-3 mb-4">
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal Cara Bayar -->
        <div class="modal fade" id="caraBayarModal" tabindex="-1" aria-labelledby="caraBayarModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="caraBayarModalLabel">Cara Bayar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Total Tagihan Bulan Ini: <span id="totalTagihan"></span></p>
                        <p>ID Pelanggan Online: <span id="idPelangganOnline"></span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
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
                    var scheduleList = $('#schedule-list');
                    scheduleList.empty();

                    if (response.length > 0) {
                        response.forEach(function(schedule, index) {
                            var scheduleItem = `<tr><td>${index + 1}</td><td>${schedule.hari}</td><td>${schedule.waktu}</td></tr>`;
                            scheduleList.append(scheduleItem);
                        });
                    } else {
                        scheduleList.append('<tr><td colspan="3">No schedule available.</td></tr>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Failed to fetch schedules:', error);
                }
            });

            // Fetch bill data
            $.ajax({
                url: '/api/bills',
                type: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                },
                success: function(response) {
                    if (response.length > 0) {
                        var bill = response[0]; // Mengambil tagihan pertama (karena bisa ada lebih dari satu)
                        $('#meter-awal').append(bill.meter_awal + ' m³');
                        $('#meter-akhir').append(bill.meter_akhir + ' m³');
                        $('#meter-tagihan').append(formatRupiah(bill.tag_now));
                    } else {
                        $('#meter-awal').text('No Data');
                        $('#meter-akhir').text('No Data');
                        $('#meter-tagihan').text('No Data');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Failed to fetch bill data:', error);
                }
            });

            $('#caraBayarBtn').on('click', function() {
                // Fetch total tagihan bulan ini and ID pelanggan online
                $.ajax({
                    url: '/api/bills',
                    type: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('token')
                    },
                    success: function(response) {
                        if (response.length > 0) {
                            var totalTagihan = response[0].total_tag;
                            var idPelangganOnline = response[0].user.id_pelanggan_online;
                            $('#totalTagihan').text('Rp' + totalTagihan.toLocaleString('id-ID'));
                            $('#idPelangganOnline').text(idPelangganOnline);
                        } else {
                            $('#totalTagihan').text('Rp0');
                            $('#idPelangganOnline').text('N/A');
                        }
                        $('#caraBayarModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error('Failed to fetch bill data:', error);
                        $('#totalTagihan').text('Rp0');
                        $('#idPelangganOnline').text('N/A');
                        $('#caraBayarModal').modal('show');
                    }
                });
            });

        });
        </script>
    </div>
@endsection
