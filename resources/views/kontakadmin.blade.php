@extends('layouts.main')

@section('container')
<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-md-1">
            <a href="/dashboardadmin" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
        <div class="col-md-11">
            <h2>{{ $title }}</h2>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="welcome-message">Kontak Staffs Warga BCV I</h5>
                </div>
                <div class="card-body">
                    <div id="contacts-container">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Tambah Kontak Baru</h5>
                </div>
                <div class="card-body">
                    <form id="add-contact-form">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="nomor">Nomor Telepon</label>
                            <input type="text" class="form-control" id="nomor" name="nomor" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="jenis">Jenis</label>
                            <select class="form-control" id="jenis" name="jenis" required>
                                <option value="Staff">Staff</option>
                                <option value="Security">Security</option>
                                <option value="Maintenance">Maintenance</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Tambah Kontak</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editContactModal" tabindex="-1" aria-labelledby="editContactModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editContactModalLabel">Edit Kontak</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-contact-form">
                        @csrf
                        <input type="hidden" id="edit-contact-id">
                        <div class="form-group mb-3">
                            <label for="edit-nama">Nama</label>
                            <input type="text" class="form-control" id="edit-nama" name="nama" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="edit-nomor">Nomor Telepon</label>
                            <input type="text" class="form-control" id="edit-nomor" name="nomor" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="edit-jenis">Jenis</label>
                            <select class="form-control" id="edit-jenis" name="jenis" required>
                                <option value="Staff">Staff</option>
                                <option value="Security">Security</option>
                                <option value="Maintenance">Maintenance</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Kontak</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        function fetchContacts() {
            $.ajax({
                url: '/api/contacts',
                type: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                },
                success: function(response) {
                    var contactsContainer = $('#contacts-container');
                    contactsContainer.empty();
                    response.forEach(function(contact) {
                        contactsContainer.append(`
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">${contact.nama}</h5>
                                    <p class="card-text">${contact.nomor}</p>
                                    <p class="card-text"><small class="text-muted">${contact.jenis}</small></p>
                                    <a href="tel:${contact.nomor}" class="btn btn-primary">Hubungi</a>
                                    <button class="btn btn-warning edit-contact-btn" data-id="${contact.id}" data-nama="${contact.nama}" data-nomor="${contact.nomor}" data-jenis="${contact.jenis}">Edit</button>
                                    <button class="btn btn-danger delete-contact-btn" data-id="${contact.id}">Delete</button>
                                </div>
                            </div>
                        `);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Failed to fetch contacts:', error);
                }
            });
        }

        $('#add-contact-form').on('submit', function(e) {
            e.preventDefault();
            var formData = {
                nama: $('#nama').val(),
                nomor: $('#nomor').val(),
                jenis: $('#jenis').val()
            };
            $.ajax({
                url: '/api/contacts',
                type: 'POST',
                data: formData,
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                },
                success: function(response) {
                    alert('Kontak berhasil ditambahkan!');
                    fetchContacts();
                    $('#add-contact-form')[0].reset();
                },
                error: function(xhr, status, error) {
                    console.error('Failed to add contact:', error);
                }
            });
        });

        $(document).on('click', '.delete-contact-btn', function() {
            var contactId = $(this).data('id');
            if (confirm('Apakah Anda yakin ingin menghapus kontak ini?')) {
                $.ajax({
                    url: '/api/contacts/' + contactId,
                    type: 'DELETE',
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('token')
                    },
                    success: function(response) {
                        alert('Kontak berhasil dihapus!');
                        fetchContacts();
                    },
                    error: function(xhr, status, error) {
                        console.error('Failed to delete contact:', error);
                    }
                });
            }
        });

        $(document).on('click', '.edit-contact-btn', function() {
            var contactId = $(this).data('id');
            var nama = $(this).data('nama');
            var nomor = $(this).data('nomor');
            var jenis = $(this).data('jenis');

            $('#edit-contact-id').val(contactId);
            $('#edit-nama').val(nama);
            $('#edit-nomor').val(nomor);
            $('#edit-jenis').val(jenis);

            $('#editContactModal').modal('show');
        });

        $('#edit-contact-form').on('submit', function(e) {
            e.preventDefault();
            var contactId = $('#edit-contact-id').val();
            var formData = {
                nama: $('#edit-nama').val(),
                nomor: $('#edit-nomor').val(),
                jenis: $('#edit-jenis').val()
            };
            $.ajax({
                url: '/api/contacts/' + contactId,
                type: 'PUT',
                data: formData,
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                },
                success: function(response) {
                    alert('Kontak berhasil diupdate!');
                    fetchContacts();
                    $('#editContactModal').modal('hide');
                },
                error: function(xhr, status, error) {
                    console.error('Failed to update contact:', error);
                }
            });
        });
        fetchContacts();
    });
</script>
@endsection
