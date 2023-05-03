<header id="header" class="header fixed-top d-flex align-items-center">

  <div class="d-flex align-items-center justify-content-between">
    <a href="{{url('')}}" class="logo d-flex align-items-center">
      <img src="{{asset('NiceAdmin/assets/img/logo.png')}}" alt="">
      <span class="d-none d-lg-block">NiceAdmin</span>
    </a>
    <i class="bi bi-list toggle-sidebar-btn"></i>
  </div><!-- End Logo -->

  <nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center">
      @auth
      <li class="nav-item dropdown pe-3">
        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
          <!-- {{Auth()->User()->foto}} -->
          @if(Auth()->User()->foto!=null)
          <img src="{{asset('Img')}}/{{Auth()->User()->foto}}" alt="Profile" class="rounded-circle">
          @else
          <i class="bi bi-person"></i>
          @endif
          <span class="d-none d-md-block dropdown-toggle ps-2">{{Auth()->User()->name}}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
          <li class="dropdown-header">
            <h6>{{Auth()->User()->name}}</h6>
            <span>{{Auth()->User()->role}}</span>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li>
            <a class="dropdown-item d-flex align-items-center" href="{{url('profil')}}">
              <i class="bi bi-person"></i>
              <span>PROFIL</span>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li>
            <a class="dropdown-item d-flex align-items-center" href="{{url('logout')}}">
              <i class="bi bi-box-arrow-right"></i>
              <span>KELUAR</span>
            </a>
          </li>
        </ul>
      </li>      
      @else
      <li class="nav-item dropdown pe-3">
        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="{{url('login')}}">
          <i class="bi bi-box-arrow-in-right"></i>
          <span class="d-none d-md-block ps-2">MASUK</span>
        </a>
      </li>
      @endauth
    </ul>
  </nav>
  <!-- End Icons Navigation -->

</header>