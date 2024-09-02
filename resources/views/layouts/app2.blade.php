
<!doctype html>
<html lang="en">

<head>
<title>Mooli | Home</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="description" content="KCCA CHISp 4x admin is super flexible, powerful, clean &amp; modern responsive admin dashboard with unlimited possibilities.">
<meta name="Baylor-Uganda" content="Developed with support from Baylor-Uganda">

<link rel="icon" href="favicon.ico" type="image/x-icon">
<!-- VENDOR CSS -->
<link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}">
<link href="{{ asset('assets/vendor/font-awesome/css/font-awesome.min.css')}}">
<link href="{{ asset('assets/vendor/animate-css/vivify.min.css')}}">

<link href="{{ asset('assets/vendor/chartist/css/chartist.min.css')}}">
<link href="{{ asset('assets/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.css')}}">
<link href="{{ asset('assets/vendor/c3/c3.min.css')}}"/>
<link href="{{ asset('assets/vendor/toastr/toastr.min.css')}}">
<link href="{{ asset('assets/vendor/jvectormap/jquery-jvectormap-2.0.3.min.css')}}"/>

<!-- MAIN CSS -->
<link href="{{ asset('assets/css/mooli.min.css')}}">

</head>
<body>
    
<div id="body" class="theme-green">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="mt-3"><img src="assets/images/icon.svg" width="40" height="40" alt="Mooli"></div>
            <p>Please wait...</p>        
        </div>
    </div>

    <!-- Theme Setting -->
    <div class="themesetting">
        <a href="javascript:void(0);" class="theme_btn"><i class="fa fa-gear fa-spin"></i></a>
        <ul class="list-group">
            <li class="list-group-item">
                <ul class="choose-skin list-unstyled mb-0">
                    <li data-theme="green" class="active"><div class="green"></div></li>
                    <li data-theme="orange"><div class="orange"></div></li>
                    <li data-theme="blush"><div class="blush"></div></li>
                    <li data-theme="cyan"><div class="cyan"></div></li>
                    <li data-theme="timber"><div class="timber"></div></li>
                    <li data-theme="blue"><div class="blue"></div></li>
                    <li data-theme="amethyst"><div class="amethyst"></div></li>
                </ul>
            </li>
            <li class="list-group-item d-flex align-items-center justify-content-between">
                <span>Light Sidebar</span>
                <label class="switch sidebar_light">
                    <input type="checkbox" checked="">
                    <span class="slider round"></span>
                </label>
            </li>
            <li class="list-group-item d-flex align-items-center justify-content-between">
                <span>Gradient</span>
                <label class="switch gradient_mode">
                    <input type="checkbox" checked="">
                    <span class="slider round"></span>
                </label>
            </li>
            <li class="list-group-item d-flex align-items-center justify-content-between">
                <span>Dark Mode</span>
                <label class="switch dark_mode">
                    <input type="checkbox">
                    <span class="slider round"></span>
                </label>
            </li>
            <li class="list-group-item d-flex align-items-center justify-content-between">
                <span>RTL version</span>
                <label class="switch rtl_mode">
                    <input type="checkbox">
                    <span class="slider round"></span>
                </label>
            </li>
        </ul>
        <hr>
        <div>
            <a href="https://themeforest.net/user/puffintheme/portfolio" class="btn btn-dark btn-block" target="_blank">Buy this item</a>
            <a href="https://themeforest.net/user/puffintheme/portfolio" target="_blank" class="btn btn-primary theme-bg gradient btn-block">View Portfolio</a>
        </div>
    </div>

    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>

    <div id="wrapper">

        <!-- Page top navbar -->
        <livewire:layouts.partials.header-component />
        <!-- Main left sidebar menu -->
        <livewire:layouts.partials.sidebar-navigation-component />
        <!--end sidebar wrapper -->

        <!-- Right bar chat  -->
        <div id="rightbar" class="rightbar">
            <div class="slim_scroll">
                <div class="chat_list">
                    <form>
                        <div class="input-group c_input_group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="icon-magnifier"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="Search...">
                        </div>
                    </form>
                    <div class="body">
                        <ul class="nav nav-tabs3 white mt-3 d-flex text-center">
                            <li class="nav-item flex-fill"><a class="nav-link active show" data-toggle="tab" href="#chat-Users">Chat</a></li>
                            <li class="nav-item flex-fill"><a class="nav-link" data-toggle="tab" href="#chat-Groups">Groups</a></li>
                            <li class="nav-item flex-fill"><a class="nav-link mr-0" data-toggle="tab" href="#chat-Contact">Contact</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane vivify fadeIn active show" id="chat-Users">
                                <ul class="right_chat list-unstyled mb-0 animation-li-delay">
                                    <li class="online">
                                        <a href="javascript:void(0);" class="media">
                                            <img class="media-object" src="assets/images/xs/avatar4.jpg" alt="">
                                            <div class="media-body">
                                                <span class="name">Louis Henry <small class="text-muted font-12">10 min</small></span>
                                                <span class="message">How do you do?</span>
                                                <span class="badge badge-outline status"></span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="online">
                                        <a href="javascript:void(0);" class="media">
                                            <img class="media-object " src="assets/images/xs/avatar5.jpg" alt="">
                                            <div class="media-body">
                                                <span class="name">Debra Stewart <small class="text-muted font-12">15 min</small></span>
                                                <span class="message">I was wondering...</span>
                                                <span class="badge badge-outline status"></span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="offline">
                                        <a href="javascript:void(0);" class="media">
                                            <img class="media-object " src="assets/images/xs/avatar2.jpg" alt="">
                                            <div class="media-body">
                                                <span class="name">Lisa Garett <small class="text-muted font-12">18 min</small></span>
                                                <span class="message">I've forgotten how it felt before</span>
                                                <span class="badge badge-outline status"></span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="offline">
                                        <a href="javascript:void(0);" class="media">
                                            <img class="media-object " src="assets/images/xs/avatar1.jpg" alt="">
                                            <div class="media-body">
                                                <span class="name">Folisise Chosielie <small class="text-muted font-12">23 min</small></span>
                                                <span class="message">Wasup for the third time like...</span>
                                                <span class="badge badge-outline status"></span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="online">
                                        <a href="javascript:void(0);" class="media">
                                            <img class="media-object " src="assets/images/xs/avatar3.jpg" alt="">
                                            <div class="media-body">
                                                <span class="name">Marshall Nichols <small class="text-muted font-12">27 min</small></span>
                                                <span class="message">But we’re probably gonna need a new carpet.</span>
                                                <span class="badge badge-outline status"></span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="online">
                                        <a href="javascript:void(0);" class="media">
                                            <img class="media-object " src="assets/images/xs/avatar5.jpg" alt="">
                                            <div class="media-body">
                                                <span class="name">Debra Stewart <small class="text-muted font-12">38 min</small></span>
                                                <span class="message">It’s not that bad...</span>
                                                <span class="badge badge-outline status"></span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="offline">
                                        <a href="javascript:void(0);" class="media">
                                            <img class="media-object " src="assets/images/xs/avatar2.jpg" alt="">
                                            <div class="media-body">
                                                <span class="name">Lisa Garett <small class="text-muted font-12">45 min</small></span>
                                                <span class="message">How do you do?</span>
                                                <span class="badge badge-outline status"></span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-pane vivify fadeIn" id="chat-Groups">
                                <ul class="right_chat list-unstyled mb-0 animation-li-delay">
                                    <li class="online">
                                        <a href="javascript:void(0);" class="media">
                                            <img class="media-object" src="assets/images/xs/avatar4.jpg" alt="">
                                            <div class="media-body">
                                                <span class="name">Apolog Hospital<small class="text-muted font-12">10 min</small></span>
                                                <span class="message">How do you do?</span>
                                                <span class="badge badge-outline status"></span>
                                            </div>
                                        </a>                            
                                    </li>
                                    <li class="offline">
                                        <a href="javascript:void(0);" class="media">
                                            <img class="media-object " src="assets/images/xs/avatar2.jpg" alt="">
                                            <div class="media-body">
                                                <span class="name">Family Groups <small class="text-muted font-12">18 min</small></span>
                                                <span class="message">I've forgotten how it felt before</span>
                                                <span class="badge badge-outline status"></span>
                                            </div>
                                        </a>                            
                                    </li>
                                    <li class="offline">
                                        <a href="javascript:void(0);" class="media">
                                            <img class="media-object " src="assets/images/xs/avatar1.jpg" alt="">
                                            <div class="media-body">
                                                <span class="name">Friends holic <small class="text-muted font-12">23 min</small></span>
                                                <span class="message">Wasup for the third time like...</span>
                                                <span class="badge badge-outline status"></span>
                                            </div>
                                        </a>                            
                                    </li>
                                    <li class="offline">
                                        <a href="javascript:void(0);" class="media">
                                            <img class="media-object " src="assets/images/xs/avatar2.jpg" alt="">
                                            <div class="media-body">
                                                <span class="name">New Hospital <small class="text-muted font-12">45 min</small></span>
                                                <span class="message">How do you do?</span>
                                                <span class="badge badge-outline status"></span>
                                            </div>
                                        </a>                            
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-pane vivify fadeIn" id="chat-Contact">
                                <ul class="right_chat list-unstyled mb-0 animation-li-delay">
                                    <li class="offline">
                                        <a href="javascript:void(0);" class="media">
                                            <img class="media-object " src="assets/images/xs/avatar2.jpg" alt="">
                                            <div class="media-body">
                                                <span class="name">Dr. John Smith <small class="text-muted"><i class="fa fa-star"></i></small></span>
                                                <span class="message">johnsmith@info.com</span>
                                                <span class="badge badge-outline status"></span>
                                            </div>
                                        </a>                            
                                    </li>
                                    <li class="offline">
                                        <a href="javascript:void(0);" class="media">
                                            <img class="media-object " src="assets/images/xs/avatar1.jpg" alt="">
                                            <div class="media-body">
                                                <span class="name">Merri Diamond <small class="text-muted"><i class="fa fa-heart"></i></small></span>
                                                <span class="message">hermanbeck@info.com</span>
                                                <span class="badge badge-outline status"></span>
                                            </div>
                                        </a>                            
                                    </li>
                                    <li class="online">
                                        <a href="javascript:void(0);" class="media">
                                            <img class="media-object" src="assets/images/xs/avatar4.jpg" alt="">
                                            <div class="media-body">
                                                <span class="name">Dr. Louis Henry <small class="text-muted"><i class="fa fa-star"></i></small></span>
                                                <span class="message">maryadams@info.com</span>
                                                <span class="badge badge-outline status"></span>
                                            </div>
                                        </a>                            
                                    </li>
                                    <li class="online">
                                        <a href="javascript:void(0);" class="media">
                                            <img class="media-object " src="assets/images/xs/avatar5.jpg" alt="">
                                            <div class="media-body">
                                                <span class="name">Andrew Patrick <small class="text-muted"><i class="fa fa-star"></i></small></span>
                                                <span class="message">mikethimas@info.com</span>
                                                <span class="badge badge-outline status"></span>
                                            </div>
                                        </a>                            
                                    </li>
                                    <li class="online">
                                        <a href="javascript:void(0);" class="media">
                                            <img class="media-object " src="assets/images/xs/avatar3.jpg" alt="">
                                            <div class="media-body">
                                                <span class="name">Claire Peters <small class="text-muted"><i class="fa fa-heart"></i></small></span>
                                                <span class="message">clairepeters@info.com</span>
                                                <span class="badge badge-outline status"></span>
                                            </div>
                                        </a>                            
                                    </li>
                                    <li class="online">
                                        <a href="javascript:void(0);" class="media">
                                            <img class="media-object " src="assets/images/xs/avatar5.jpg" alt="">
                                            <div class="media-body">
                                                <span class="name">Pro. Debra Stewart <small class="text-muted"><i class="fa fa-star"></i></small></span>
                                                <span class="message">It’s not that bad...</span>
                                                <span class="badge badge-outline status"></span>
                                            </div>
                                        </a>                            
                                    </li>
                                    <li class="offline">
                                        <a href="javascript:void(0);" class="media">
                                            <img class="media-object " src="assets/images/xs/avatar2.jpg" alt="">
                                            <div class="media-body">
                                                <span class="name">Dr. Lisa Garett <small class="text-muted"><i class="fa fa-star"></i></small></span>
                                                <span class="message">eringonzales@info.com</span>
                                                <span class="badge badge-outline status"></span>
                                            </div>
                                        </a>                            
                                    </li>
                                    <li class="online">
                                        <a href="javascript:void(0);" class="media">
                                            <img class="media-object" src="assets/images/xs/avatar4.jpg" alt="">
                                            <div class="media-body">
                                                <span class="name">MD. Louis Henry <small class="text-muted"><i class="fa fa-star"></i></small></span>
                                                <span class="message">susiewillis@info.com</span>
                                                <span class="badge badge-outline status"></span>
                                            </div>
                                        </a>                            
                                    </li>
                                    <li class="online">
                                        <a href="javascript:void(0);" class="media">
                                            <img class="media-object " src="assets/images/xs/avatar5.jpg" alt="">
                                            <div class="media-body">
                                                <span class="name">Debra Stewart <small class="text-muted"><i class="fa fa-star"></i></small></span>
                                                <span class="message">johnsmith@info.com</span>
                                                <span class="badge badge-outline status"></span>
                                            </div>
                                        </a>                            
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
        
        <!-- Main body part  -->
        <div id="main-content">
            <div class="container-fluid">
                {{$slot}}
            </div>
        </div>
        
    </div>
</div>

<!-- Javascript -->
 <script src="{{ asset('assets/bundles/libscripts.bundle.js')}}"></script>
 <script src="{{ asset('assets/bundles/vendorscripts.bundle.js')}}"></script>

<!-- Vedor js file and create bundle with grunt  --> 
 <script src="{{ asset('assets/bundles/flotscripts.bundle.js')}}"></script><!-- flot charts Plugin Js -->
 <script src="{{ asset('assets/bundles/c3.bundle.js')}}"></script>
 <script src="{{ asset('assets/bundles/apexcharts.bundle.js')}}"></script>
 <script src="{{ asset('assets/bundles/jvectormap.bundle.js')}}"></script>
 <script src="{{ asset('assets/vendor/toastr/toastr.js')}}"></script>

<!-- Project core js file minify with grunt --> 
 <script src="{{ asset('assets/bundles/mainscripts.bundle.js')}}"></script>
<script src="{{ asset('assets/js/index.js')}}"></script>
</body>
</html>
