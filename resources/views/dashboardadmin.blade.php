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
            <div class="card">
                <div class="card-body" style="background-color: #253793; border-radius: 5px">
                    <div class="card-body mx-3 mb-4" style="background-color: #D9D9D9; border-radius: 15px">
                        <h5 class="card-title" style="text-align: center">Selamat Datang, <span id="nama-user"></span></h5>
                    </div>
                    <div class="mx-3 mb-4">
                        <div class="card-body" style="background-color: #D9D9D9; border-radius: 15px; position: relative;">
                            <div class="d-flex align-items-center">
                                <div style="margin-right: 30px;">
                                    <img src="{{ asset('img/trash.png') }}" class="img-fluid" style="max-height: 100px; border-radius: 40px; padding: 5px">
                                </div>
                                <div style="padding-right: 10px;">
                                    <h5 class="card-title">Jadwal ambil sampah</h5>
                                    <table class="table table-striped">
                                        <tbody id="schedule-list">
                                            <tr>
                                                <td>Waktu</td>
                                                <td id="senin-waktu"></td>
                                                <td id="selasa-waktu"></td>
                                                <td id="rabu-waktu"></td>
                                                <td id="kamis-waktu"></td>
                                                <td id="jumat-waktu"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mx-3 mb-4">
                        <div class="card-body" style="background-color: #D9D9D9; border-radius: 15px; position: relative;">
                            <div class="row">
                                <div class="col-md-6 d-flex align-items-center">
                                    <div style="margin-right: 30px;">
                                        <img id="gambar-reservoir-atas" src="{{ asset('img/cylinder-off.png') }}" class="img-fluid" style="max-height: 100px; border-radius: 40px; padding: 5px">
                                    </div>
                                    <div style="padding-right: 10px;">
                                        <h5 class="card-title">Reservoir Atas</h5>
                                    </div>
                                </div>
                                <div class="col-md-6 d-flex align-items-center">
                                    <div style="margin-right: 30px;">
                                        <img id="gambar-sumbersible-besar" src="{{ asset('img/lightbulb-off.png') }}" class="img-fluid" style="max-height: 100px; border-radius: 40px; padding: 5px">
                                    </div>
                                    <div style="padding-right: 10px;">
                                        <h5 class="card-title">Submersible Besar</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mx-3 mb-4">
                        <div class="card-body" style="background-color: #D9D9D9; border-radius: 15px; position: relative;">
                            <div class="row">
                                <div class="col-md-6 d-flex align-items-center">
                                    <div style="margin-right: 30px;">
                                        <img id="gambar-reservoir-bawah" src="{{ asset('img/cylinder-off.png') }}" class="img-fluid" style="max-height: 100px; border-radius: 40px; padding: 5px">
                                    </div>
                                    <div style="padding-right: 10px;">
                                        <h5 class="card-title">Reservoir Bawah</h5>
                                    </div>
                                </div>
                                <div class="col-md-6 d-flex align-items-center">
                                    <div style="margin-right: 30px;">
                                        <img id="gambar-sumbersible-kecil" src="{{ asset('img/lightbulb-off.png') }}" class="img-fluid" style="max-height: 100px; border-radius: 40px; padding: 5px">
                                    </div>
                                    <div style="padding-right: 10px;">
                                        <h5 class="card-title">Submersible Kecil</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/9.0.0/firebase-app.js";
        import { getDatabase, ref, set, onValue } from "https://www.gstatic.com/firebasejs/9.0.0/firebase-database.js";

        const firebaseConfig = {
                apiKey: "AIzaSyBrFK8HL0bBK7QaVm5dsQJ9Gk9Nm5-LmlU",
                authDomain: "bcv1-f450b.firebaseapp.com",
                databaseURL: "https://bcv1-f450b-default-rtdb.asia-southeast1.firebasedatabase.app",
                projectId: "bcv1-f450b",
                storageBucket: "bcv1-f450b",
                messagingSenderId: "632085793199",
                appId: "1:632085793199:web:64563abd2d0d8faad2c75a",
            };

        const app = initializeApp(firebaseConfig);
        const database = getDatabase(app);

        function updateImageBasedOnFirebaseValue(elementId, imageId, value) {
            const img = document.getElementById(imageId);
            const onImage = '{{ asset('img/lightbulb-on.png') }}';
            const offImage = '{{ asset('img/lightbulb-off.png') }}';
            img.src = value === 1 ? onImage : offImage;
        }

        function updateCylinderImageBasedOnFirebaseValue(imageId, value) {
            const img = document.getElementById(imageId);
            const onImage = '{{ asset('img/cylinder.png') }}';
            const offImage = '{{ asset('img/cylinder-off.png') }}';
            img.src = value === 1 ? onImage : offImage;
        }

        function listenFirebase(path, callback) {
            const dbRef = ref(database, path);
            onValue(dbRef, (snapshot) => {
                const data = snapshot.val();
                callback(data);
            });
        }

        listenFirebase('ControlSystem/Reservoir1/Radar', (data) => {
            updateCylinderImageBasedOnFirebaseValue('gambar-reservoir-atas', data);
        });

        listenFirebase('ControlSystem/Reservoir2/RadarPompa3', (data) => {
            updateCylinderImageBasedOnFirebaseValue('gambar-reservoir-bawah', data);
        });

        listenFirebase('ControlSystem/Reservoir2/Relay1', (data) => {
            updateImageBasedOnFirebaseValue('sumbersible-besar', 'gambar-sumbersible-besar', data);
        });

        listenFirebase('ControlSystem/Reservoir2/Relay2', (data) => {
            updateImageBasedOnFirebaseValue('sumbersible-kecil', 'gambar-sumbersible-kecil', data);
        });

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
                        // Initialize empty arrays for days and times
                        let days = ["Hari"];
                        let times = ["Waktu"];

                        response.forEach(function(schedule) {
                            days.push(schedule.hari);
                            times.push(schedule.waktu);
                        });

                        // Create rows for days and times
                        let daysRow = "<tr>";
                        days.forEach(function(day) {
                            daysRow += "<td>" + day + "</td>";
                        });
                        daysRow += "</tr>";

                        let timesRow = "<tr>";
                        times.forEach(function(time) {
                            timesRow += "<td>" + time + "</td>";
                        });
                        timesRow += "</tr>";

                        // Append the rows to the schedule list
                        scheduleList.append(daysRow);
                        scheduleList.append(timesRow);
                    } else {
                        scheduleList.append('<tr><td colspan="3">No schedule available.</td></tr>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Failed to fetch schedules:', error);
                }
            });
        });
    </script>
</div>
@endsection
