@extends('layouts.main')

@section('container')
<div class="container-fluid mt-5">
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-1">
                <a href="/dashboard" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>
            <div class="col-md-11">
                <h2>{{ $title }}</h2>
            </div>
        </div>
                </div>
                <div class="card-body">
                    <div id="contact-list" class="row row-cols-1 row-cols-md-2 g-4">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        $.ajax({
            url: '/api/contacts',
            type: 'GET',
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('token')
            },
            success: function(response) {
                var contactList = $('#contact-list');
                contactList.empty();

                response.forEach(function(contact) {
                    var contactCard = `
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">${contact.nama}</h5>
                                    <p class="card-text">${contact.nomor}</p>
                                    <a href="tel:${contact.nomor}" class="btn btn-primary">Hubungi</a>
                                </div>
                            </div>
                        </div>
                    `;
                    contactList.append(contactCard);
                });
            },
            error: function(xhr, status, error) {
                console.error('Failed to fetch contacts:', error);
            }
        });
    });
</script>
@endsection
