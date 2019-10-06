 <aside class="main-sidebar col-12 col-md-3 col-lg-2 px-0">
          <div class="main-navbar">
            <nav class="navbar align-items-stretch navbar-light bg-white flex-md-nowrap border-bottom p-0">
              <a class="navbar-brand w-100 mr-0" href="{{ url('/') }}" style="line-height: 25px;">
                <div class="d-table ml-3">
                  <span class="d-none d-md-inline ml-1"><img src="{{ asset('irh_assets/images/adminlogo.png') }}" alt="" width="120px"></span>
                </div>
              </a>
              <a class="toggle-sidebar d-sm-inline d-md-none d-lg-none">
                <i class="material-icons">&#xE5C4;</i>
              </a>
            </nav>
          </div>
          <div class="nav-wrapper">
            @role('admin')
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link {{ (\Request::route()->getName() == 'dashboard.index') ? 'active' : '' }}" href="{{ route('dashboard.index') }}">
                  <i class="material-icons">edit</i>
                  <span>Dashboard</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ (\Request::route()->getName() == 'dashboard.resources.upload') ? 'active' : '' }}" href="{{ route('dashboard.resources.upload') }}">
                  <i class="material-icons">cloud_upload</i>
                  <span>Upload New Resource</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ (\Request::route()->getName() == 'dashboard.resources.index') ? 'active' : '' }}" href="{{ route('dashboard.resources.index') }}">
                  <i class="material-icons">speaker_notes</i>
                  <span>All Resources</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ (\Request::route()->getName() == 'dashboard.resources.categories.index') ? 'active' : '' }}" href="{{ route('dashboard.resources.categories.index') }}">
                  <i class="material-icons">list</i>
                  <span>Resource Categories</span>
                </a>
              </li>
             <li class="nav-item">
                <a class="nav-link {{ (\Request::route()->getName() == 'dashboard.resources.tags.index') ? 'active' : '' }}" href="{{ route('dashboard.resources.tags.index') }}">
                  <i class="material-icons">loyalty</i>
                  <span>Resource Tags</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ (\Request::route()->getName() == 'dashboard.resources.flagged') ? 'active' : '' }}" href="{{ route('dashboard.resources.flagged') }}">
                  <i class="material-icons">flag</i>
                  <span>Flagged Resources</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ (\Request::route()->getName() == 'dashboard.users.index') ? 'active' : '' }}" href="{{ route('dashboard.users.index') }}">
                  <i class="material-icons">supervisor_account</i>
                  <span>Users</span>
                </a>
              </li>
              
              <li class="nav-item">
                <a class="nav-link {{ (\Request::route()->getName() == 'dashboard.subscribers') ? 'active' : '' }}" href="{{ route('dashboard.subscribers') }}">
                  <i class="material-icons">supervisor_account</i>
                  <span>Subscribers</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ (\Request::route()->getName() == 'dashboard.donations') ? 'active' : '' }}" href="{{ route('dashboard.donations') }}">
                  <i class="material-icons">money</i>
                  <span>Donations</span>
                </a>
              </li>
            </ul>
            @endrole
            @role('user')
             <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link {{ (\Request::route()->getName() == 'dashboard.index') ? 'active' : '' }}" href="{{ route('dashboard.index') }}">
                  <i class="material-icons">edit</i>
                  <span>Dashboard</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ (\Request::route()->getName() == 'dashboard.resources.upload') ? 'active' : '' }}" href="{{ route('dashboard.resources.upload') }}">
                  <i class="material-icons">cloud_upload</i>
                  <span>Upload New Resource</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ (\Request::route()->getName() == 'dashboard.resources.user') ? 'active' : '' }}" href="{{ route('dashboard.resources.user') }}">
                  <i class="material-icons">speaker_notes</i>
                  <span>My Resources</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ (\Request::route()->getName() == 'dashboard.user.profile') ? 'active' : '' }}" href="{{ route('dashboard.user.profile') }}">
                  <i class="material-icons">account_circle</i>
                  <span>My Profile</span>
                </a>
              </li>
            </ul>
            @endrole
          </div>
        </aside>