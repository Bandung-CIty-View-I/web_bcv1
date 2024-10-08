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
            <div class="p-3 mb-2" style="background-color: #253793; border-radius: 10px">
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
                <div class="card-header text-center">
                    <strong>Masukkan Tagihan IPL</strong>
                </div>
                <div class="card-body">
                    <form id="bill-form" action="/api/admin/bills/add" method="POST">
                        @csrf
                        <input type="hidden" id="userIdInput" name="user_id" value="{{ auth()->user()->id }}" />
                        <input type="hidden" id="paidInput" name="paid" value="0" />
                        <input type="hidden" id="tunggakan1Input" name="tunggakan_1" />
                        <input type="hidden" id="tunggakan2Input" name="tunggakan_2" />
                        <input type="hidden" id="tunggakan3Input" name="tunggakan_3" />
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="namaInput">Nama</label>
                                    <input type="text" class="form-control" id="namaInput" name="nama" placeholder="Nama akan keluar otomatis" readonly required />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="blokInput">Blok</label>
                                    <select class="form-control selectpicker" id="blokInput" name="blok" data-live-search="true" required>
                                        <option value="" disabled selected>Pilih Blok</option>
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
                                    <label class="form-label" for="noHomeInput">Nomor Kavling</label>
                                    <input oninput="this.value = this.value.toUpperCase()" type="text" class="form-control" id="noHomeInput" name="nomor_kavling" placeholder="Masukan nomor kavling" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- <div class="mb-3">
                                    <label for="tanggalInput" class="form-label">Tanggal</label>
                                    <input type="date" class="form-control form-date" id="tanggalInput" name="thn_bl" required />
                                </div> -->
                                <div class="mb-3">
                                    <label class="form-label" for="meterAwalInput">Meter Awal</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="meterAwalInput" name="meter_awal" placeholder="Masukan meter awal" readonly required />
                                        <span class="input-group-text">M<sup>3</sup></span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="meterAkhirInput">Meter Akhir</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="meterAkhirInput" name="meter_akhir" placeholder="Masukan meter akhir" required />
                                        <span class="input-group-text">M<sup>3</sup></span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="iplInput">IPL</label>
                                    <input type="number" class="form-control" id="iplInput" name="ipl" placeholder="IPL akan keluar otomatis" readonly required />
                                </div>
                            </div>
                        </div>
                        <div class="mt-2 d-flex justify-content-center">
                            <p>Tagihan ini akan diinputkan untuk bulan: <span id="monthName"></span></p>
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
    document.addEventListener("DOMContentLoaded", function() {
        function generateMonth() {
            const listMonthName = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
            const d = new Date();
            
            // Dapatkan nama bulan saat ini
            const currentMonthName = listMonthName[d.getMonth()+1];

            // Cetak ke konsol (untuk debugging)

            // Tampilkan nama bulan di elemen HTML dengan id "monthName"
            document.getElementById('monthName').textContent = currentMonthName;
        }

        // Panggil fungsi setelah konten dimuat
        generateMonth();
    });

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
                console.error('Failed to fetch admin data:');
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
                        $('#namaInput').val(response.nama);
                        $('#userIdInput').val(response.user_id);
                        $('#iplInput').val(response.ipl);
                        fetchMeterAwal(response.user_id); 
                    },
                    error: function(xhr, status, error) {
                        $('#namaInput').val('');
                        $('#userIdInput').val(''); 
                        $('#meterAwalInput').val('');
                        $('#iplInput').val('');
                        console.error('Failed to fetch name:');
                    }
                });
            }
        }

        function generateMonthYear(){
            const d = new Date();
            let nextMonthFinal;
            let year = d.getFullYear().toString();
            let month = d.getMonth();
            let nextMonthRealValue = (month+2).toString();
            if (nextMonthRealValue.length == 1){
                nextMonthFinal = '0' + nextMonthRealValue;
            } else {
                nextMonthFinal = nextMonthRealValue;
            }
            
            let thn_bl = year+nextMonthFinal;
            return thn_bl;
        }

        function fetchMeterAwal(user_id) {
            $.ajax({
                url: '/api/admin/get-meter-akhir',
                type: 'POST',
                data: { user_id: user_id },
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                },
                success: function(response) {
                    $('#meterAwalInput').val(response.meter_akhir); 
                },
                error: function(xhr, status, error) {
                    $('#meterAwalInput').val(''); 
                    console.error('Failed to fetch meter awal:');
                }
            });
        }

        $('#noHomeInput, #blokInput').on('blur', fetchName);

        $('#bill-form').on('submit', function(e) {
            e.preventDefault();

            const data = {
                user_id: $('#userIdInput').val(),
                nomor_kavling: $('#noHomeInput').val(),
                nama: $('#namaInput').val(),
                paid: $('#paidInput').val(),
                thn_bl: generateMonthYear(),
                meter_awal: $('#meterAwalInput').val(),
                meter_akhir: $('#meterAkhirInput').val(),
                tunggakan_1: 0,
                tunggakan_2: 0,
                tunggakan_3: 0,
            };

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
                    alert('Pendaftaran tagihan gagal');
                }
            });
        });
    });
</script>
@endsection
