<nav class="navbar align-items-stretch navbar-light flex-md-nowrap p-0">
  <form action="#" class="main-navbar__search w-100 d-none d-md-flex d-lg-flex">
  {{--   <div class="input-group input-group-seamless ml-3">
      <div class="input-group-prepend">
        <div class="input-group-text">
          <i class="fas fa-search"></i>
        </div>
      </div>
      <input class="navbar-search form-control" id="live_search_txt" type="text" placeholder="Search books library..." aria-label="Search" data-route="" data-library-route="">
    </div> --}}
  </form>
  <ul class="navbar-nav border-left flex-row ">
        <li class="nav-item border-right dropdown notifications">
          <a class="nav-link nav-link-icon text-center" href="{{ route('dashboard.messages.index') }}">
            <div class="nav-link-icon__wrapper">
              <i class="material-icons">chat</i>
              <span class="badge badge-pill badge-danger">{{ Auth::user()->getUnreadUserMessagesCount() }}</span>
            </div>
          </a>
        </li>
        @auth
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-nowrap px-3" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            <img class="user-avatar rounded-circle mr-2" src="{{ asset('irh_assets/images/avatar.png') }}" alt="User Avatar">
            <span class="d-none d-md-inline-block">{{ Auth::user()->username }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
          </a>
          <div class="dropdown-menu dropdown-menu-small">
            <a class="dropdown-item text-danger" href="{{ route('dashboard.password') }}"><i class="material-icons text-danger">fingerprint</i> Update Password</a>
            <a class="dropdown-item text-danger" href="{{ route('logout') }}"
              onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">
              <i class="material-icons text-danger">&#xE879;</i>
              {{ __('Logout') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>

          </div>
        </li>
        @else
        <li class="nav-item dropdown">
          <a class="nav-link text-nowrap px-3 pt-3" href="#">Go to Site</a>
        </li>
        @endauth
      </ul>
      <nav class="nav">
        <a href="#" class="nav-link nav-link-icon toggle-sidebar d-md-inline d-lg-none text-center border-left" data-toggle="collapse" data-target=".header-navbar" aria-expanded="false" aria-controls="header-navbar">
          <i class="material-icons">&#xE5D2;</i>
        </a>
      </nav>
    </nav>