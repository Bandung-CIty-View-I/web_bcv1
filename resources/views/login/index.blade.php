@extends('layouts.main')

<link rel="stylesheet" href="/css/style.css">
<body style="background: linear-gradient(to right, #F8F2F0 50%, #394E69 50%); margin:0; padding:0;">
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
          <div class="form-floating mb-3">
            <input type="email" class="form-control" id="email" placeholder="name@example.com">
            <label for="email">Enter your username</label>
          </div>
          <div class="form-floating mb-3">
            <input type="password" class="form-control" id="password" placeholder="Password">
            <label for="password">Password</label>
          </div>
          <button class="btn w-100 py-2" style="background: #FE8660; color: white" type="submit">Sign In</button>
          <div id="error-message" class="mt-3 text-danger"></div>
        </form>
      </div>
      <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center p-5" style="background-color: #394E69;">
        <img src="img/login.png" alt="Image" class="img-fluid">
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
      });

      $('#user-login-form').on('submit', function(e) {
        e.preventDefault();
        var email = $('#email').val();
        var password = $('#password').val();

        $.ajax({
          url: '/api/auth/login',
          type: 'POST',
          data: {
            email: email,
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
