<nav class="navbar navbar-expand-sm" style="background-color: #eee;">
  <div class="container">
    <a class="navbar-brand col-4" href="{{url('/')}}">GIS</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse col-4 justify-content-center" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="{{url('/')}}">HOME</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{url('grafik')}}">GRAFIK</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{url('informasi')}}">INFORMASI</a>
        </li>
      </ul>
    </div>
    @auth
    <div class="col-4">
      <ul class="navbar-nav justify-content-end">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle justify-content-end" href="#" data-bs-toggle="dropdown" aria-expanded="false">{{Auth()->User()->name}}</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{url('profil')}}">Profil</a></li>
            <li>
              <form action="{{url('logout')}}" method="POST">
                @csrf
                <button class="dropdown-item">Keluar</button>
              </form>
            </li>
          </ul>
        </li>
      </ul>
    </div>
    @else
    <div class="col-4">
      <ul class="navbar-nav justify-content-end">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle justify-content-end" href="#" data-bs-toggle="dropdown" aria-expanded="false">AUTH</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{url('login')}}">Masuk</a></li>
            <li><a class="dropdown-item" href="{{url('register')}}">Daftar</a></li>
          </ul>
        </li>
      </ul>
    </div>
    @endauth


  </div>
</nav>