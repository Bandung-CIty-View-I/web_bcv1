<nav class="navbar navbar-expand-lg navbar-dark">
  @php
    $exceptions1 = ["Dashboard", "Admin Dashboard", "Profile Warga", "Profile Admin", "Input Tagihan IPL", "Lihat Tagihan IPL", "Kondisi Air dan Alat", "Tagihan IPL Warga", "Daftar Akun Warga"];
    $loggedIn = Auth::check(); 
    $userRole = Auth::check() ? Auth::user()->role : null; 
  @endphp
  <div class="container">
    <a class="navbar-brand" style="padding-right: 120px" href="/">BCV I</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        @if(!$loggedIn)
          <li class="nav-item">
            <a class="nav-link {{ ($title === "Home") ? 'active' : ''}}" href="/" style="padding-right: 50px">Home</a>
          </li>
        @endif
        <li class="nav-item">
          <a class="nav-link {{ ($title === "Lokasi") ? 'active' : ''}}" href="/lokasi" style="padding-right: 50px">Lokasi</a>
        </li>
        @if($loggedIn)
          <li class="nav-item">
            @if($userRole === 'admin')
              <a class="nav-link {{ ($title === "Kontak Admin") ? 'active' : ''}}" href="/kontakadmin" style="padding-right: 50px">Kontak</a>
            @else
              <a class="nav-link {{ ($title === "Kontak") ? 'active' : ''}}" href="/kontak" style="padding-right: 50px">Kontak</a>
            @endif
          </li>
        @endif
      </ul>
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          @unless (in_array($title, $exceptions1))
            @if(!$loggedIn)
            <a href="/login" class="btn" type="submit" style="color: black; background: #FE8660; border-radius: 15px;">Sign In</a>
            @endif
          @endunless
        </li>
        <li class="nav-item">
          @if($loggedIn)
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
              @csrf
              <button type="submit" class="btn" style="color: black; background: #FE8660; border-radius: 15px;">Logout</button>
            </form>
          @endif
        </li>
      </ul>
    </div>
  </div>
</nav>

<script>
  document.getElementById('logout-form')?.addEventListener('submit', function(event) {
    event.preventDefault(); 
    
    localStorage.removeItem('token');
    
    this.submit();
  });
</script>
