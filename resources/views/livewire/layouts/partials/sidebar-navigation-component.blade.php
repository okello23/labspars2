<div id="left-sidebar" class="sidebar light_active">

  <a href="javascript:void(0);" class="menu_toggle"><i class="fa fa-angle-left"></i></a>
  <div class="navbar-brand" style="text-align: center;">
    <a href="{{ route('home') }}"><img src="{{ asset('/images/moh.png') }}" width="100px" alt="Genomics"></a>
    <h6 style="text-align:center" title="CPHL Genomics Laboratory Information Management System">Ministry Of Health<br>Lab SPARS</h6><hr>
    <button type="button" class="btn-toggle-offcanvas btn btn-sm float-right"><i class="fa fa-close"></i></button>
  </div>
  <div class="sidebar-scroll" style="overflow-y: auto;">
    <div class="user-account">
      <div class="user_div">
        <img src="{{ asset('assets/images/user.jpg') }}" class="user-photo" alt="User Profile Picture">
      </div>
      <div class="dropdown">
        <span>Karibu!</span>
        <a href="javascript:void(0);" class="dropdown-toggle user-name"
        data-toggle="dropdown"><strong>{{ \Auth::user()->first_name }} {{\Auth::user()->surname}} </strong></a>
        <ul class="dropdown-menu dropdown-menu-right account vivify flipInY">
          <li><a href="{{ route('profile') }}"><i class="fa fa-user"></i>My Profile</a></li>
          <li class="divider"></li>
          <li><a href="{{ route('logout') }}"
            onclick="event.preventDefault();
            document.getElementById('logout-form').submit();"><i
            class="fa fa-power-off"></i>Logout</a></li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              {{ csrf_field() }}
            </form>
          </ul>
        </div>
      </div>

      <nav id="left-sidebar-nav" class="sidebar-nav sidebar-scrollable">
        <div class="sidebar-scrollable-content">
          <ul id="main-menu" class="metismenu animation-li-delay">
            <!-- <li class="header">Management</li> -->

            <li>
              <a href="{{ route('home') }}" class="has-arrow">
              <i class="fa fa-dashboard"></i><span>Dashboard</span></a>
                <ul>
                  <li><a href="{{ route('home') }}">Main Dashboard</a></li>
                </ul>
              </li>

              <li>
                <a href="#Payments" class="has-arrow"><i class="fa fa-dot-circle-o"></i>
                  <span>LSS Data Entry</span></a>
                  <ul>
                    <li><a href="{{ route('facility-visits') }}">Facility Visits</a></li>
                    {{-- <li><a href="#">Submitted Forms</a></li> --}}
              </ul>
            </li>

            <li>
              <a href="#Payments" class="has-arrow"><i class="fa fa-bar-chart-o"></i>
                <span>Reports</span></a>
                <ul>
                  <li>
                    <a href="#scores" class="has-arrow">
                      <span>Scores</span></a>
                      <ul>
                        <li><a href="#">Survey Summary</a></li>
                        <li><a href="#">Scores Summary</a></li>
                        <li><a href="#">Extract By Indicator</a></li>
                      </ul>
                    </li>

                    <li><a href="#">League Table</a></li>
                    <li><a href="#">Facility Performance</a></li>
                  </ul>
                  <li>
                    <a href="#Room" class="has-arrow"><i class="fa fa-cog"></i><span>System Settings</span></a>
                    <ul>
                      <li><a href="{{ route('reagents')}}">Reagents</a></li>
                      <li><a href="{{ route('test-category')}}">Test Categories</a></li>
                      <li><a href="{{ route('store-types')}}">Storage Types</a></li>
                      <li><a href="{{ route('lab_platforms')}}">Lab Platforms</a></li>
                      <li><a href="{{ route('product-types')}}">Stock Products</a></li>
                      <li><a href="{{ route('districts') }}">Districts</a></li>
                      <li><a hr ef="{{ route('health-facilities') }}">Health Facilities</a></li>
                      <li><a href="{{ route('health-sub-districts') }}">Health Sub Districts</a></li>
                    </ul>
                  </li>
                </li>

                        @if (Auth::user()->hasPermission(['access_user_management']))
                        <li>
                          <a href="#Room" class="has-arrow"><i class="fa fa-users"></i><span>User Management</span></a>
                          <ul>
                            <li> <a href="{{ route('usermanagement') }}"><i
                              class="fa fa-right-arrow-alt"></i>{{ __('public.users') }}</a>
                            </li>
                            <li> <a href="{{ route('user-roles.index') }}"><i
                              class="fa fa-right-arrow-alt"></i>{{ __('public.roles') }}</a>
                            </li>
                            <li> <a href="{{ route('user-permissions.index') }}"><i
                              class="fa fa-right-arrow-alt"></i>{{ __('public.permissions') }}</a>
                            </li>
                            <li> <a href="{{ route('user-roles-assignment.index') }}"><i
                              class="fa fa-right-arrow-alt"></i>{{ __('public.roleassign') }}</a>
                            </li>
                            <li> <a href="{{ route('logs') }}"><i
                              class="fa fa-right-arrow-alt"></i>{{ __('public.loginactivity') }}</a>
                            </li>
                            <li> <a href="{{ route('useractivity') }}"><i
                              class="fa fa-right-arrow-alt"></i>{{ __('public.useractivity') }}</a>
                            </li>
                          </ul>
                        </li>
                        @endif

                      </ul>
                    </div>
                  </nav>
                </div>
              </div>
