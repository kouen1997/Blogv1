<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          @if(empty(Auth::user()->avatar))
              <img src="{{ URL::asset('avatar/dummy-avatar.png') }}" class="img-circle" alt="Avatar">
          @else

              @if(file_exists(public_path('avatar/'.Auth::user()->avatar))) 

                  <img src="{{ URL::asset('avatar/'.Auth::user()->avatar) }}" class="img-circle" alt="Avatar"> 

              @else

                  <img src="{{ URL::asset('avatar/dummy-avatar.png') }}" class="img-circle" alt="Avatar">

              @endif
          @endif
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->name }}</p>
          <a href=""><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="{{ url('search') }}" method="get" class="sidebar-form">
        <div class="input-group">
          <input name="search" type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li>
          <a href="{{ url('/admin/dashboard') }}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-wrench"></i> <span>Manage</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <a href="#">
                <i class="fa fa-user"></i> Profile
              </a>
            </li>
            <li>
              <a href="{{ url('/admin/blog') }}">
                <i class="fa fa-newspaper-o"></i> Blog
              </a>
            </li>
            <li>
              <a href="{{ url('/admin/todo') }}">
                <i class="fa fa-list"></i> To do
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>