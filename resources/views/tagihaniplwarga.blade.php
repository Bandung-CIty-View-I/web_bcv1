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
                            <a class="nav-link {{ ($title === "Dashboard") ? 'active' : ''}}" href="/dashboard">Dashboard</a>
                            <a class="nav-link {{ ($title === "Tagihan IPL Warga") ? 'active' : ''}}" href="/detailtagihan">Detail Tagihan IPL</a>
                            <a class="nav-link {{ ($title === "Profile Warga") ? 'active' : ''}}" href="/profilewarga">Profile</a>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="mt-4">
                    <h1 class="fs-4">Selamat Datang, <span id="nama-user"></span></h1>
                    <h2 class="small text-muted fs-6" id="current-date"></h2>

                    <nav class="main-nav d-flex justify-content-between mt-5">
                        <div class="d-flex gap-4">
                            <button class="btn btn-light border" data-bs-toggle="modal" data-bs-target="#filterModal">
                                <div class="d-flex">
                                    <i class="bi bi-funnel me-2"></i>
                                    <span>Filter</span>
                                </div>
                            </button>
                            <button id="caraBayarBtn" class="btn btn-light border">
                                <div class="d-flex">
                                    <i class="bi bi-wallet me-2"></i>
                                    <span>Cara Bayar</span>
                                </div>
                            </button>
                        </div>
                    </nav>

                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table" id="billTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col">Tahun</th>
                                            <th scope="col">Bulan</th>
                                            <th scope="col">Meter Awal</th>
                                            <th scope="col">Meter Akhir</th>
                                            <th scope="col">Tagihan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="bill-table-body">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Modal for Filter -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">Filter Tagihan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="filterForm">
                    <div class="mb-3">
                        <label for="filterYear" class="form-label">Tahun</label>
                        <input type="number" class="form-control" id="filterYear" name="filterYear">
                    </div>
                    <div class="mb-3">
                        <label for="filterMonth" class="form-label">Bulan</label>
                        <select class="form-select" id="filterMonth" name="filterMonth">
                            <option value="">Pilih Bulan</option>
                            <option value="01">Januari</option>
                            <option value="02">Februari</option>
                            <option value="03">Maret</option>
                            <option value="04">April</option>
                            <option value="05">Mei</option>
                            <option value="06">Juni</option>
                            <option value="07">Juli</option>
                            <option value="08">Agustus</option>
                            <option value="09">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
                    <button type="button" class="btn btn-primary" id="applyFilterBtn">Apply Filter</button>
                    <button type="button" class="btn btn-primary" id="removeFilterBtn">Remove Filter</button>
                </form>
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
                    <p>Untuk pembayaran iuran IPL dan air dapat dilakukan melalui virtual account dengan kode (59044).</p>
                    <p>Atau melalui transfer ke BCA nomor 1377775678 a.n. CV. Bandung City View.</p>
                    <p>Bukti transfer dapat dikirim melalui nomor HP/WA: 082320462406</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <script>
        $(document).ready(function() {
            // Fetch user profile
            $.ajax({
                url: '/api/user/profile',
                type: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                },
                success: function(response) {
                    $('#nama-user-sidebar').text(response.nama);
                    $('#nama-user').text(response.nama);
                    $('#current-date').text(response.tanggal);
                },
                error: function(xhr, status, error) {
                    console.error('Failed to fetch profile data:', error);
                }
            });

            // Fetch bill data
            function fetchBillData(filters = {}) {
                $.ajax({
                    url: '/api/bills',
                    type: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('token')
                    },
                    data: filters,
                    success: function(response) {
                        var billTableBody = $('#bill-table-body');
                        billTableBody.empty(); 

                        if (response.length > 0) {
                            response.forEach(function(bill) {
                                var row = `
                                    <tr>
                                        <th scope="row">${bill.thn_bl.substring(0, 4)}</th>
                                        <td>${new Date(bill.thn_bl.substring(0, 4), bill.thn_bl.substring(4, 6) - 1).toLocaleString('default', { month: 'long' })}</td>
                                        <td>${bill.user.nama}</td>
                                        <td>${bill.user.nomor_kavling}</td>
                                        <td>${bill.meter_awal} M<sup>3</sup></td>
                                        <td>${bill.meter_akhir} M<sup>3</sup></td>
                                        <td>Rp${bill.total_tag.toLocaleString('id-ID')}</td>
                                    </tr>
                                `;
                                billTableBody.append(row);
                            });
                        } else {
                            billTableBody.append('<tr><td colspan="7" class="text-center">No data available</td></tr>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Failed to fetch bill data:', error);
                    }
                });
            }

            fetchBillData();

            // Apply filter function
            function applyFilter() {
                const year = $('#filterYear').val();
                let month = $('#filterMonth').val();

                // Validasi input tahun dan bulan
                if (!year || !month) {
                    alert('Kamu harus memasukkan bulan beserta tahunnya!');
                    return;
                }

                // Pastikan bulan selalu memiliki dua digit
                if (month.length === 1) {
                    month = '0' + month;
                }

                // Gabungkan menjadi format YYYYMM
                const yearMonth = year + month;

                const filters = {
                    thn_bl: yearMonth
                };

                fetchBillData(filters);
                $('#filterModal').modal('hide');
                $('.modal-backdrop').remove();   // Hapus elemen backdrop
            }

            // Apply filter on button click
            $('#applyFilterBtn').on('click', function() {
                applyFilter();
            });

            
            // Apply filter on Enter key press
            $('#filterYear, #filterMonth').on('keypress', function(e) {
                if (e.which === 13) { // Enter key code is 13
                    applyFilter();
                }
            });

            // Remove filter on button click
            $('#removeFilterBtn').on('click', function() {
                // Kosongkan nilai input tahun dan bulan
                $('#filterYear').val('');
                $('#filterMonth').val('');

                const filters = {};
                fetchBillData(filters);
                $('#filterModal').modal('hide');
                $('.modal-backdrop').remove(); 
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
@endsection
