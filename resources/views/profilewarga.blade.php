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
                    <h5 class="mb-0 text-white" id="nama-user">Nomor Rumah</h5>
                </div>
                <hr style="border-top: 2px solid #000000;">
                <div class="p-2 mb-2">
                    <nav class="nav flex-column">
                        <a class="nav-link {{ ($title === "Dashboard") ? 'active' : ''}}" href="/dashboard">Dashboard</a>
                        <a class="nav-link" href="/detailtagihan">Detail Tagihan IPL</a>
                        <a class="nav-link {{ ($title === "Profile Warga") ? 'active' : ''}}" href="/profilewarga">Profile</a>
                    </nav>
                </div>
            </div>
        </div>
        
        <div class="col-md-9">
            <div class="card">
                <div class="card-body" style="background-color: #253793; border-radius: 5px; color:white;">
                    Personal Data
                    <hr style="border-top: 2px solid #000000; margin-top: 20px; margin-bottom: 20px;">
                
                    <div class="container">
                        <div class="row">
                            <div class="col-2">
                                <div class="bg-white mt-3 p-3 rounded" style="width: 150px; margin-left: 20px">
                                    <img src="{{ asset('img/Profile.png') }}" class="img-fluid">
                                    <div class="text-center mt-3" style="color: #000000; background-color: white; border: 2px solid black; border-radius: 50px" id="user-blok">
                                        Blok 
                                    </div>
                                </div>
                            </div>
                            <div class="col d-flex flex-column" style="margin-left : 70px">
                                <div class="mt-3" style="font-weight: bold">
                                    <p>Ubah Data Pribadi</p>
                                    <hr style="border-top: 2px solid black; margin-bottom : 0px; margin-top: 0px">
                                </div>
                                <div class="mt-3" style="color : white;">
                                    <div class="d-flex">
                                        <div style="width : 200px;">
                                            <p>Nama</p>
                                            <p>Nomor Kavling</p>
                                            <p>No. HP</p>
                                            <p>Email</p>
                                        </div>
                                        <div style="flex: 1;">
                                            <p id="view-nama"></p>
                                            <p id="view-no-kavling"></p>
                                            <p id="view-no-hp"></p>
                                            <p id="view-email"></p>
                                            <form id="update-profile-form" class="d-none">
                                                <input type="text" id="edit-nama" class="form-control mb-2 form-control-transparent">
                                                <input type="text" id="edit-no-kavling" class="form-control mb-2 form-control-transparent" style="background-color: #aaaaaa;" readonly>
                                                <input type="text" id="edit-no-hp" class="form-control mb-2 form-control-transparent">
                                                <input type="email" id="edit-email" class="form-control mb-2 form-control-transparent">
                                                <button type="submit" class="btn btn-primary mt-2">Submit</button>
                                            </form>
                                            <!-- Form Ubah Password -->
                                            <form id="change-password-form" class="d-none mt-3">
                                                <div class="form-group">
                                                    <label for="current-password">Password Lama</label>
                                                    <input type="password" id="current-password" class="form-control mb-2" placeholder="Masukkan password lama" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="new-password">Password Baru</label>
                                                    <input type="password" id="new-password" name="new_password" class="form-control mb-2" placeholder="Masukkan password baru" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="confirm-password">Konfirmasi Password Baru</label>
                                                    <input type="password" id="confirm-password" name="new_password_confirmation" class="form-control mb-2" placeholder="Konfirmasi password baru" required>
                                                </div>
                                                <button type="submit" class="btn btn-primary mt-2">Ubah Password</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col d-flex flex-column">
                                    <div class="mt-1">
                                        <button class="btn btn-secondary mt-3" id="edit-profile-btn" style="color: black; font-weight: bold">Edit Profile</button>
                                        <button class="btn btn-secondary mt-3" id="edit-password-btn" style="color: black; font-weight: bold">Edit Password</button>
                                    </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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
            $('#view-nama').text(response.nama);
            $('#nama-user').text(response.nama);
            $('#view-no-kavling').text(response.nomor_kavling);
            $('#user-blok').append(response.blok_cluster);
            $('#view-no-hp').text(response.no_hp);
            $('#view-email').text(response.email);

            $('#edit-nama').val(response.nama);
            $('#edit-no-kavling').val(response.nomor_kavling);
            $('#edit-no-hp').val(response.no_hp);
            $('#edit-email').val(response.email);
        },
        error: function(xhr, status, error) {
            console.error('Failed to fetch profile data:', error);
        }
    });

    //Toggle Edit Profile
    $('#edit-profile-btn').on('click', function() {
        $('#view-nama, #view-no-kavling, #view-no-hp, #view-email').toggle();
        $('#update-profile-form').toggleClass('d-none');
        $('#edit-profile-btn').toggleClass('d-none');
    });

    // Toggle Edit Password
    $('#edit-password-btn').on('click', function() {
        $('#change-password-form').toggleClass('d-none');
        $('#update-profile-form').addClass('d-none');
    });

    // Change Profile                                                    
    $('#update-profile-form').on('submit', function(e) {
        e.preventDefault();
        const data = {
            nama: $('#edit-nama').val(),
            no_hp: $('#edit-no-hp').val(),
            email: $('#edit-email').val(),
        };

        $.ajax({
            url: '/api/user/update',
            type: 'POST',
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('token')
            },
            data: data,
            success: function(response) {
                alert('Profile updated successfully');

                $('#view-nama').text(response.nama);
                $('#view-no-kavling').text(response.nomor_kavling);
                $('#view-no-hp').text(response.no_hp);
                $('#view-email').text(response.email);

                $('#view-nama, #view-no-kavling, #view-no-hp, #view-email').toggle();
                $('#update-profile-form').toggleClass('d-none');
                $('#edit-profile-btn').toggleClass('d-none');
            },
            error: function(xhr, status, error) {
                console.error('Failed to update profile data:', error);
            }
        });
    });

    // Change Password
    $('#change-password-form').on('submit', function(e) {
        e.preventDefault();
        const data = {
            current_password: $('#current-password').val(),
            new_password: $('#new-password').val(),
            new_password_confirmation: $('#confirm-password').val(),
        };

        $.ajax({
            url: '/api/user/change-password',
            type: 'POST',
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('token')
            },
            data: data,
            success: function(response) {
                alert('Password berhasil diubah!');
                $('#change-password-form')[0].reset();
                $('#change-password-form').toggleClass('d-none');
            },
            error: function(xhr) {
                alert('Gagal mengubah password!');
            }
        });
    });
});
</script>
@endsection
