@extends('layouts.main')

<link rel="stylesheet" href="/css/style.css">
<body style="background: linear-gradient(to right, #F8F2F0 50%, #253793 50%); margin:0; padding:0;">
  @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
  @endif
  <div class="container-fluid d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="row w-100">
      <div class="col-lg-6 d-flex flex-column align-items-center justify-content-center p-5" style="background-color: #F8F2F0;">
        <form class="form-signin w-100" id="user-login-form">
          <h1 class="h3 mt-3 text-center">Welcome!</h1>
          <p class="mt-3 text-center" style="color:#808080">Welcome back! Please enter your details</p>

          <!-- Tombol Toggle Email / Phone Number -->
          <div class="d-flex justify-content-center mb-3">
            <button type="button" id="toggle-login" class="btn btn-outline-secondary">Use Phone Number</button>
          </div>

          <div class="form-floating mb-3">
            <!-- Input Dinamis yang akan diubah oleh JavaScript -->
            <input type="email" class="form-control" id="identifier" placeholder="Enter your email" aria-label="Email">
            <label for="identifier" id="identifier-label">Enter your email</label>
          </div>
          <div class="form-floating mb-3">
            <input type="password" class="form-control" id="password" placeholder="Password">
            <label for="password">Password</label>
          </div>
          <button class="btn w-100 py-2" style="background: #FE8660; color: white" type="submit">Sign In</button>
          <button class="btn w-100 py-2 mt-2" style="background: #808080; color: white" onclick="window.location.href='/'">Back to Homepage</button>
          <div id="error-message" class="mt-3 text-danger"></div>
        </form>
      </div>
      <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center p-5" style="background-color: #253793;">
        <img src="img/login.png" alt="Image" class="img-fluid">
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    //Penanganan tombol login menggunakan email/phone number
    document.getElementById('toggle-login').addEventListener('click', function() {
      var identifierInput = document.getElementById('identifier');
      var identifierLabel = document.getElementById('identifier-label');
      var toggleButton = document.getElementById('toggle-login');

      // Check the current state and toggle between email and phone number
      if (identifierInput.getAttribute('type') === 'text') {
        identifierInput.setAttribute('type', 'email');
        identifierInput.setAttribute('placeholder', 'Enter your email');
        identifierLabel.innerText = 'Enter your email';
        toggleButton.innerText = 'Use Phone Number';
      } else {
        identifierInput.setAttribute('type', 'text'); // Gunakan type "text" untuk nomor telepon
        identifierInput.setAttribute('placeholder', 'Enter your phone number');
        identifierLabel.innerText = 'Enter your phone number';
        toggleButton.innerText = 'Use Email';
      }
    });

    $(document).ready(function() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
      });

      $('#user-login-form').on('submit', function(e) {
        e.preventDefault();
        var identifier = $('#identifier').val();
        var password = $('#password').val();

        $.ajax({
          url: '/api/auth/login',
          type: 'POST',
          data: {
            identifier: identifier,
            password: password
          },
          success: function(response) {
            localStorage.setItem('token', response.access_token);
            $.ajaxSetup({
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token'),
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            window.location.href = response.redirect_to;
          },
          error: function(xhr, status, error) {
            $('#error-message').text('Invalid credentials. Please try again.');
          }
        });
      });
    });
  </script>
</body>
