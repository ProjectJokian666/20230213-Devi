<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
      <a class="nav-link " href="{{url('/')}}">
        <i class="bi bi-grid"></i>
        <span>Maps Gis</span>
      </a>
    </li>
    <!-- End Dashboard Nav -->
    @auth
    @if(Auth()->User()->role=='Admin')
    @include('layouts.sidebar-admin')
    @elseif(Auth()->User()->role=='Petugas')
    @include('layouts.sidebar-petugas')
    @endif
    @else
    @include('layouts.sidebar-guest')
    @endauth
  </ul>

</aside>