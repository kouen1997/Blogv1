<header class="main-header">
    <!-- Logo -->
    <a href="{{ url('/admin/dashboard') }}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>B</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Blogv1</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              @if(empty(Auth::user()->avatar))
                  <img src="{{ URL::asset('avatar/dummy-avatar.png') }}" class="user-image" alt="Avatar">
              @else
                  @if(file_exists(public_path('avatar/'.Auth::user()->avatar))) 

                      <img src="{{ URL::asset('avatar/'.Auth::user()->avatar) }}" class="user-image" alt="Avatar"> 

                  @else

                      <img src="{{ URL::asset('avatar/dummy-avatar.png') }}" class="user-image" alt="Avatar">

                  @endif
              @endif
              <span class="hidden-xs">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- Avatar -->
              <li class="user-header">
                @if(empty(Auth::user()->avatar))
                    <img src="{{ URL::asset('avatar/dummy-avatar.png') }}" class="img-circle" alt="Avatar">
                @else

                    @if(file_exists(public_path('avatar/'.Auth::user()->avatar))) 

                        <img src="{{ URL::asset('avatar/'.Auth::user()->avatar) }}" class="img-circle" alt="Avatar"> 

                    @else

                        <img src="{{ URL::asset('avatar/dummy-avatar.png') }}" class="img-circle" alt="Avatar">

                    @endif
                @endif
                <p>
                  {{ Auth::user()->name }}
                </p>
              </li>
              
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{ url('/admin/dashboard') }}" class="btn btn-default btn-flat">Dashboard</a>
                </div>
                <div class="pull-right">
                  <a href="{{ url('/logout') }}" class="btn btn-default btn-flat">Logout</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>