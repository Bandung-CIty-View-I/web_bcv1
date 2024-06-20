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

            <div class="p-3 mb-2" style="background-color: #394E69; border-radius: 10px">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('img/Profile.png') }}" class="img-fluid mr-2" style="max-height: 100px; border-radius: 40px; padding: 10px">
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
            <div class="mt-4">
                <h1 class="fs-4" id="admin-name">Selamat Datang</h1>
                <h2 class="small text-muted fs-6" id="current-date">*Hari, Tanggal Bulan Tahun</h2>

                <nav class="main-nav d-flex justify-content-between mt-5">
                    <div class="input-group border">
                        <button class="btn search-btn" type="button" id="buttonSearchTable">
                            <i class="bi bi-search"></i>
                        </button>
                        <input type="text" class="form-control search-input" id="searchName" placeholder="Search ..." aria-label="Example text with button addon" aria-describedby="buttonSearchTable">
                    </div>
                    <div class="d-flex gap-4">
                        <button class="btn btn-light border" data-bs-toggle="modal" data-bs-target="#filterModal">
                            <div class="d-flex">
                                <i class="bi bi-funnel me-2"></i>
                                <span>Filter</span>
                            </div>
                        </button>
                        <button class="btn btn-light border" id="exportBtn">
                            <div class="d-flex">
                                <i class="bi bi-box-arrow-up me-2"></i>
                                <span>Export</span>
                            </div>
                        </button>
                    </div>
                </nav>

                <div class="card mt-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="billTable">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">Tahun</th>
                                        <th scope="col">Bulan</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Nomor Kavling</th>
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
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
<script>
$(document).ready(function() {
    // Fetch admin data
    $.ajax({
        url: '/api/admin/data',
        type: 'POST',
        headers: {
            'Authorization': 'Bearer ' + localStorage.getItem('token')
        },
        success: function(response) {
            $('#admin-name').text('Selamat Datang, ' + response.nama);
            $('#current-date').text(response.tanggal);
            $('#nama-user').text(response.nama);
        },
        error: function(xhr, status, error) {
            console.error('Failed to fetch admin data:', error);
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

    // Initial fetch
    fetchBillData();

    // Apply filter function
    function applyFilter() {
        const filters = {
            year: $('#filterYear').val(),
            month: $('#filterMonth').val()
        };
        fetchBillData(filters);
        $('#filterModal').modal('hide');
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

    // Handle Enter key for search
    $('#searchName').on('keypress', function(e) {
        if (e.which === 13) { // Enter key code is 13
            const searchName = $(this).val();
            const filters = {
                name: searchName
            };
            fetchBillData(filters);
        }
    });

    // Search by name
    $('#buttonSearchTable').on('click', function() {
        const searchName = $('#searchName').val();
        const filters = {
            name: searchName
        };
        fetchBillData(filters);
    });

    // Export to Excel
    $('#exportBtn').on('click', function() {
        var table = document.getElementById('billTable');
        var wb = XLSX.utils.table_to_book(table, {sheet: "Tagihan IPL"});
        var ws = wb.Sheets["Tagihan IPL"];

        // Mengambil range dari sheet
        var range = XLSX.utils.decode_range(ws['!ref']);

        // Menambahkan style bold pada header
        for(var C = range.s.c; C <= range.e.c; ++C) {
            var cell_address = XLSX.utils.encode_cell({c:C, r:0});
            if(!ws[cell_address]) continue;
        }

        // Menambahkan format tabel
        ws['!autofilter'] = { ref: XLSX.utils.encode_range(range) };

        XLSX.writeFile(wb, "Tagihan_IPL.xlsx");
    });
});


</script>
@endsection
