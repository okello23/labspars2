<nav class="navbar navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-left">
            <div class="navbar-btn">
                <a href="index.html"><img src="{{ asset('/images/dna-hd.png') }}" alt="Genomics"
                        class="img-fluid logo"></a>
                <button type="button" class="btn-toggle-offcanvas"><i
                        class="fa fa-align-left"></i></button>
            </div>
            <!-- <form id="navbar-search" class="navbar-form search-form">
                <button type="button" class="btn btn-default"><i class="icon-magnifier"></i></button>
                <input value="" class="form-control" placeholder="Search here..." type="text">
            </form> -->
        </div>
        <div class="navbar-right">
            <div id="navbar-menu">
                <ul class="nav navbar-nav">
                  <?php
                  echo date('d-m-Y H:i'); ?>
                    <!-- <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle icon-menu"
                            data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <span class="notification-dot info">4</span>
                        </a>
                        <ul class="dropdown-menu feeds_widget mt-0 animation-li-delay">
                            <li class="header theme-bg gradient mt-0 text-light">You have 4 New
                                Notifications</li>

                            <li>
                                <a href="#">
                                    <div class="mr-4"><i class="fa fa-thumbs-o-up text-success"></i>
                                    </div>
                                    <div class="feeds-body">
                                        <h4 class="title text-success">2 New Feedback <small
                                                class="float-right text-muted font-12">9:22 AM</small></h4>
                                        <small>It will give a smart finishing to your site</small>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li> -->
                    <li class="hidden-xs"><a href="javascript:void(0);" id="btnFullscreen"
                            class="icon-menu"><i class="fa fa-arrows-alt"></i></a></li>
                    <li>
                        <a class="icon-menu"  href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();"  class="dropdown-item"><i class="fa fa-power-off"></i>
                        {{-- <span>Logout</span> --}}
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                     </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="recent_searche" style="display: none;">
            <div class="card mb-0">
                <div class="header">
                    <h2>Recent search result</h2>
                    <ul class="header-dropdown dropdown">
                        <li><a href="javascript:void(0);">Clear data</a></li>
                        <li><a href="page-search-results.html"><i class="fa fa-external-link"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <ul class="list-group list-group-flush">

                        <li class="list-group-item p-l-0 p-r-0">
                            <h6><a href="#">Qubes - Responsive Admin Dashboard Template</a></h6>
                            <p class="text-muted">Commodo excepteur non ut aliqua ex qui velit sed esse
                                consequat in </p>
                            <div class="text-muted font-13">
                                <ul class="list-inline">
                                    <li class="list-inline-item"><span
                                            class="badge badge-danger margin-0">Bootstrap</span></li>
                                    <li class="list-inline-item">Sep 27 2020</li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
