 <!-- sidebar @s -->
 <div class="nk-sidebar nk-sidebar-fixed is-dark " data-content="sidebarMenu">
    <div class="nk-sidebar-element nk-sidebar-head">
        <div class="nk-menu-trigger">
            <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
            <a href="#" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
        </div>
        <div class="nk-sidebar-brand">
            <a href="{{url('/dashboard')}}" class="logo-link nk-sidebar-logo">
                <img class="logo-light logo-img" style="width: 100px" src="{{asset('assets/images/upt.jpeg')}}" srcset="{{asset('assets/images/upt.jpeg')}} 2x" alt="logo">
                <img class="logo-dark logo-img" style="width: 100px" src="{{asset('assets/images/upt.jpeg')}}" srcset="{{asset('assets/images/upt.jpeg')}} 2x" alt="logo-dark">
            </a>
        </div>
    </div><!-- .nk-sidebar-element -->
    <div class="nk-sidebar-element nk-sidebar-body">
        <div class="nk-sidebar-content">
            <div class="nk-sidebar-menu" data-simplebar>
                <ul class="nk-menu">
                    <li class="nk-menu-item">
                        <a href="{{url('/dashboard')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-dashboard"></em></span>
                            <span class="nk-menu-text">Dashboard</span>
                        </a>
                    </li><!-- .nk-menu-item -->
                    @hasanyrole('system-admin|claim-entry|front-desk')
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-calendar-booking"></em></span>
                            <span class="nk-menu-text">Claims</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{url('/new-claim')}}" class="nk-menu-link"><span class="nk-menu-text">New Claim</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{url('un-processed-claims')}}" class="nk-menu-link"><span class="nk-menu-text">Un-Processed Claims</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{url('invalid-claims')}}" class="nk-menu-link"><span class="nk-menu-text">In-Valid Claims</span></a>
                            </li>
                        </ul>
                    </li><!-- .nk-menu-item -->
                    @endhasanyrole
                    @hasanyrole('system-admin|audit')
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-home"></em></span>
                            <span class="nk-menu-text">Auditing</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{url('/pending-audit')}}" class="nk-menu-link"><span class="nk-menu-text">Pending Audit</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{url('audited-claims')}}" class="nk-menu-link"><span class="nk-menu-text">Audited Claims</span></a>
                            </li>
                        </ul>
                    </li><!-- .nk-menu-item -->
                    @endhasanyrole

                    @hasanyrole('system-admin|accounting')
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-reports"></em></span>
                            <span class="nk-menu-text">Scheme Admins</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{url('/assigned-schemes')}}" class="nk-menu-link"><span class="nk-menu-text">My Assigned Scheme(s)</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{url('/pending-receipt')}}" class="nk-menu-link"><span class="nk-menu-text">Pending Receipt</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{url('/received-claims')}}" class="nk-menu-link"><span class="nk-menu-text">Received Claims</span></a>
                            </li>
                            {{-- <li class="nk-menu-item">
                                <a href="{{url('/pending-payments')}}" class="nk-menu-link"><span class="nk-menu-text">Pending Payments</span></a>
                            </li> --}}
                        </ul>
                    </li><!-- .nk-menu-item -->
                    @endhasanyrole
                    <li class="nk-menu-item">
                        <a href="{{url('/search-claims')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-search"></em></span>
                            <span class="nk-menu-text">Search Claims</span>
                        </a>
                    </li>

                    {{-- <li class="nk-menu-item">
                        <a href="{{url('/notifications')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-bell"></em></span>
                            <span class="nk-menu-text">Notifications </span>  <span class="badge bg-danger">0</span>
                        </a>
                    </li> --}}
                    @hasanyrole('system-admin|claim-entry|front-desk')
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-menu"></em></span>
                            <span class="nk-menu-text">Extras</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{url('/new-scheme')}}" class="nk-menu-link"><span class="nk-menu-text">New Scheme</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{url('/new-company')}}" class="nk-menu-link"><span class="nk-menu-text">New Company</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{url('/claim-state')}}" class="nk-menu-link"><span class="nk-menu-text">Claim States</span></a>
                            </li>
                            {{-- <li class="nk-menu-item">
                                <a href="{{url('/banks')}}" class="nk-menu-link"><span class="nk-menu-text">Banks Info</span></a>
                            </li> --}}
                            {{-- <li class="nk-menu-item">
                                <a href="html/hotel/invoice-details.html" class="nk-menu-link"><span class="nk-menu-text">Invocie Details</span></a>
                            </li> --}}
                        </ul>
                    </li><!-- .nk-menu-item -->
                    @endhasanyrole

                    {{-- @hasanyrole('system-admin|claim-entry|front-desk') --}}
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-coins"></em></span>
                            <span class="nk-menu-text">Generate Reports</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{url('/report-by-company')}}" class="nk-menu-link"><span class="nk-menu-text">Report By Company</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{url('/report-by-scheme')}}" class="nk-menu-link"><span class="nk-menu-text">Report By Scheme</span></a>
                            </li>
                            
                            {{-- <li class="nk-menu-item">
                                <a href="html/hotel/invoice-details.html" class="nk-menu-link"><span class="nk-menu-text">Invocie Details</span></a>
                            </li> --}}
                        </ul>
                    </li><!-- .nk-menu-item -->
                    {{-- @endhasanyrole --}}
                    {{-- <li class="nk-menu-item">
                        <a href="html/hotel/support.html" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-chat-circle-fill"></em></span>
                            <span class="nk-menu-text">Support</span>
                        </a>
                    </li> --}}
                    {{-- <li class="nk-menu-item">
                        <a href="html/hotel/settings.html" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-setting-alt-fill"></em></span>
                            <span class="nk-menu-text">Settings</span>
                        </a>
                    </li> --}}
                    
                    <li class="nk-menu-heading">
                        <h6 class="overline-title text-primary-alt">Accounts</h6>
                    </li><!-- .nk-menu-item -->
                    @role('system-admin')
                    <li class="nk-menu-item">
                        <a href="{{url('new-staff')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-dashlite-alt"></em></span>
                            <span class="nk-menu-text">New Staff</span>
                        </a>
                    </li><!-- .nk-menu-item -->
                    <li class="nk-menu-item">
                        <a href="{{url('all-staffs')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-users"></em></span>
                            <span class="nk-menu-text">All Staffs</span>
                        </a>
                    </li><!-- .nk-menu-item -->
                    @endrole
                    <li class="nk-menu-item">
                        <a href="{{url('logout')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-signout"></em></span>
                            <span class="nk-menu-text">Logout</span>
                        </a>
                    </li><!-- .nk-menu-item -->
                </ul><!-- .nk-menu -->
            </div><!-- .nk-sidebar-menu -->
        </div><!-- .nk-sidebar-content -->
    </div><!-- .nk-sidebar-element -->
</div>
<!-- sidebar @e -->