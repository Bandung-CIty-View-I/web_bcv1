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
            <div class="p-3 mb-2" style="background-color: #394E69; border-radius: 10px">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('img/Profile.png') }}" class="img-fluid mr-2" style="max-height: 100px; border-radius: 40px; padding: 10px">
                    <h5 class="mb-0 text-white" id="nama-user"></h5>
                </div>
                <hr style="border-top: 2px solid #000000;">
                <div class="p-2 mb-2">
                    <nav class="nav flex-column">
                        <a class="nav-link {{ ($title === "Dashboard") ? 'active' : '' }}" href="/dashboardadmin">Dashboard</a>
                        <a class="nav-link {{ ($title === "Lihat Tagihan IPL") ? 'active' : '' }}" href="/tagihanipladmin">Lihat Tagihan IPL</a>
                        <a class="nav-link {{ ($title === "Input Tagihan IPL") ? 'active' : '' }}" href="/tagihan">Input Tagihan IPL</a>
                        <a class="nav-link {{ ($title === "Kondisi Air dan Alat") ? 'active' : '' }}" href="/kondisi">Kondisi Air dan Alat</a>
                        <a class="nav-link {{ ($title === "Daftar Akun Warga") ? 'active' : '' }}" href="/daftarwarga">Daftar Akun Warga</a>
                        <a class="nav-link {{ ($title === "Profile Admin") ? 'active' : '' }}" href="/profileadmin">Profile</a>
                    </nav>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card card-tagihan-ipl">
                <div class="card-title">
                    Masukan Tagihan IPL
                </div>
                <div class="card-body">
                    <form id="bill-form" action="/api/bills/add" method="POST">
                        @csrf
                        <input type="hidden" id="userIdInput" name="user_id" value="{{ auth()->user()->id }}" />
                        <input type="hidden" id="iplInput" name="ipl" value="50000" />
                        <input type="hidden" id="paidInput" name="paid" value="0" />
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="namaInput" name="nama" placeholder="Masukan nama" readonly required />
                                    <label for="namaInput">Nama</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="blokInput" name="blok" placeholder="Masukan blok" required />
                                    <label for="blokInput">Blok</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="noHomeInput" name="nomor_kavling" placeholder="Masukan nomor kavling" required />
                                    <label for="noHomeInput">Nomor Kavling</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tanggalInput" class="form-label">Tanggal</label>
                                    <input type="date" class="form-control form-date" id="tanggalInput" name="thn_bl" required />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="meterAwalInput">Meter Awal</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="meterAwalInput" name="meter_awal" placeholder="Masukan meter awal" aria-label="Meter Awal" required />
                                        <span class="input-group-text">M<sup>3</sup></span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="meterAkhirInput">Meter Akhir</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="meterAkhirInput" name="meter_akhir" placeholder="Masukan meter akhir" aria-label="Meter Akhir" required />
                                        <span class="input-group-text">M<sup>3</sup></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2 d-flex justify-content-center">
                            <button type="submit" class="btn btn-success btn-outline">Submit</button>
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
            url: '/api/admin/data',
            type: 'POST',
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('token')
            },
            success: function(response) {
                $('#nama-user').text(response.nama);
            },
            error: function(xhr, status, error) {
                console.error('Failed to fetch admin data:', error);
            }
        });

        function fetchName() {
            const data = {
                nomor_kavling: $('#noHomeInput').val(),
                blok: $('#blokInput').val()
            };

            if (data.nomor_kavling && data.blok) {
                $.ajax({
                    url: '/api/admin/find-name',
                    type: 'POST',
                    data: data,
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('token')
                    },
                    success: function(response) {
                        console.log('Fetched user data:', response); // Log the fetched user data
                        $('#namaInput').val(response.nama);
                        $('#userIdInput').val(response.user_id); // Set user_id
                    },
                    error: function(xhr, status, error) {
                        $('#namaInput').val('');
                        $('#userIdInput').val(''); // Clear user_id
                        console.error('Failed to fetch name:', error);
                    }
                });
            }
        }

        $('#noHomeInput, #blokInput').on('blur', fetchName);

        $('#bill-form').on('submit', function(e) {
            e.preventDefault();

            const data = {
                user_id: $('#userIdInput').val(),
                nomor_kavling: $('#noHomeInput').val(),
                nama: $('#namaInput').val(),
                paid: $('#paidInput').val(),
                thn_bl: $('#tanggalInput').val().replace(/-/g, '').substring(0, 6),
                ipl: $('#iplInput').val(),
                meter_awal: $('#meterAwalInput').val(),
                meter_akhir: $('#meterAkhirInput').val(),
                tunggakan_1: 0,
                tunggakan_2: 0,
                tunggakan_3: 0,
            };

            console.log('Data to be submitted:', data); // Log data before submitting

            $.ajax({
                url: '/api/admin/bills/add',
                type: 'POST',
                data: data,
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                },
                success: function(response) {
                    alert('Tagihan berhasil ditambahkan!');
                    window.location.href = '/tagihanipladmin';
                },
                error: function(xhr, status, error) {
                    console.error('Failed to add bill:', error);
                    alert('Pendaftaran tagihan gagal');
                }
            });
        });
    });
</script>
@endsection
