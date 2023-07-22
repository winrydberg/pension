<header class="main-header">

    <!-- Logo -->
    <a href="index2.html" class="logo" style="background-color: #00295B">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>U</b>PT</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>PCM</b>PLATFORM</span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" style="background-color: #00295B">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
        
          @if(Auth::check())
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-user-circle"></i>
              <span class="hidden-xs">{{Auth::user()->firstname.' '.Auth::user()->lastname}}</span>
            </a>
            <ul class="dropdown-menu">
              <li class="user-footer">
                <div class="pull-left">
                  {{-- <a href="#" class="btn btn-default btn-flat">Profile</a> --}}
                </div>
                <div class="pull-right">
                  <a href="#" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          @endif
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>

    </nav>
  </header>