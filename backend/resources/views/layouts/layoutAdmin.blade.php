<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png')}}">
  <link rel="icon" type="image/png" href="{{ asset('assets/img/AfiyahLogo.png')}}">
<title >@yield('title')</title>
  <!--     Fonts and icons     -->
@yield('style')
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <!-- Nucleo Icons -->
  <link href="{{ asset('assets/css/nucleo-icons.css')}}" rel="stylesheet" />
  <link href="{{ asset('assets/css/nucleo-svg.css')}}" rel="stylesheet" />
  <!-- Font Awesome Icons -->
    <!-- Include SweetAlert CSS and JS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <script src="https://api.opencagedata.com/geocode/v1/json?key="></script>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js">
</script>
  <!-- Material Icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
  <!-- CSS Files -->
  <link id="pagestyle" href="{{ asset('assets/css/material-dashboard.css?v=3.2.0') }}" rel="stylesheet" />
    <style>
        /* Make the dropdown pop to the left */
        .nav-item .dropdown-menu {
            left: -150px !important; /* Adjust this value to move the dropdown further left */
        }

        /* Remove the dropdown arrow (caret) */
        .nav-item .dropdown-toggle::after {
            display: none !important;
        }

    </style>
</head>

<body class="g-sidenav-show  bg-gray-100">
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2  bg-white my-2" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-1 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand px-4 py-1 m-0" href="  " target="_blank">
        <span class="d-flex justify-center text-sm text-dark"><img src="{{ asset('assets/img/AfiyahLogo.png') }}" class="" width="100" height="70" alt="main_logo">
        </span>
      </a>
    </div>
    <hr class="horizontal dark mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard.index') ? 'bg-gradient-dark' : 'text-dark' }}" href="{{ route('dashboard.index') }}">

            <i class="material-symbols-rounded opacity-5">dashboard</i>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('user.index') ? 'bg-gradient-dark' : 'text-dark' }}" href="{{ route('user.index') }}">
                <i class="material-symbols-rounded opacity-5">manage_accounts</i>
                <span class="nav-link-text ms-1">Users</span>
          </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('product.index') ? 'bg-gradient-dark' : 'text-dark' }}" href="{{ route('product.index') }}">
                <i class="material-symbols-rounded opacity-5">shopping_bag</i>
                <span class="nav-link-text ms-1">Products</span>
          </a>
        </li>
        <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('brand.index') ? 'bg-gradient-dark' : 'text-dark' }}" href="{{ route('brand.index') }}">
        <i class="material-symbols-rounded opacity-5">business</i>
        <span class="nav-link-text ms-1">Brands</span>
    </a>
</li>

          <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('store.index') ? 'bg-gradient-dark' : 'text-dark' }}" href="{{ route('store.index') }}">
                  <!-- Pharmacy-related Icon -->
        <i class="material-symbols-rounded opacity-5">local_pharmacy</i>
                  <span class="nav-link-text ms-1">Manage Pharmacies</span>
              </a>
          </li>
          <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('order.index') ? 'bg-gradient-dark' : 'text-dark' }}" href="{{ route('order.index') }}">
        <i class="material-symbols-rounded opacity-5">shopping_cart</i>
        <span class="nav-link-text ms-1">Manage Orders</span>
    </a>
</li>

          <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('blog.index') ? 'bg-gradient-dark' : 'text-dark' }}" href="{{ route('blog.index') }}">
                  <i class="material-symbols-rounded opacity-5">article</i>
                  <span class="nav-link-text ms-1">Manage Blogs</span>
              </a>
          </li>
          <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('review.index') ? 'bg-gradient-dark' : 'text-dark' }}" href="{{ route('review.index') }}">
                  <i class="material-symbols-rounded opacity-5">rate_review</i>
                  <span class="nav-link-text ms-1">Reviews</span>
              </a>
          </li>
          <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('comment.index') ? 'bg-gradient-dark' : 'text-dark' }}" href="{{ route('comment.index') }}">
                  <i class="material-symbols-rounded opacity-5">comment</i>
                  <span class="nav-link-text ms-1">Comments</span>
              </a>
          </li>


          <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('contact.index') ? 'bg-gradient-dark' : 'text-dark' }}" href="{{ route('contact.index') }}">
            <i class="material-symbols-rounded opacity-5">notifications</i>
            <span class="nav-link-text ms-1">Notifications</span>
          </a>
        </li>
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Account pages</h6>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('profile.edit') ? 'bg-gradient-dark' : 'text-dark' }}" href="{{ route('profile.edit') }}">
            <i class="material-symbols-rounded opacity-5">person</i>
            <span class="nav-link-text ms-1">Profile</span>
          </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="material-symbols-rounded opacity-5">logout</i>
            <span class="nav-link-text ms-1">Log Out</span>
          </a>
        </li>

      </ul>
    </div>

  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Dashboard</li>
          </ol>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <div class="input-group input-group-outline">
              <label class="form-label">Type here...</label>
              <input type="text" class="form-control">
            </div>
          </div>
          <ul class="navbar-nav d-flex align-items-center  justify-content-end">


            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </a>
            </li>
            <li class="nav-item px-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0">
                <i class="material-symbols-rounded fixed-plugin-button-nav">settings</i>
              </a>
            </li>

              <li class="nav-item d-flex align-items-center dropdown">
                  <a href="#" class="nav-link text-body font-weight-bold px-0 dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="material-symbols-rounded">account_circle</i>
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <li><a class="dropdown-item" href="{{route('profile.edit')}}">View Profile</a></li>
                      <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log Out</a></li>
                  </ul>

                  <!-- Hidden logout form -->
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                  </form>
              </li>


          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
   @yield('content')
  </main>
  <div class="fixed-plugin">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
      <i class="material-symbols-rounded py-2">settings</i>
    </a>
    <div class="card shadow-lg">
      <div class="card-header pb-0 pt-3">
        <div class="float-start">
          <h5 class="mt-3 mb-0">Material UI Configurator</h5>
          <p>See our dashboard options.</p>
        </div>
        <div class="float-end mt-4">
          <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
            <i class="material-symbols-rounded">clear</i>
          </button>
        </div>
        <!-- End Toggle Button -->
      </div>
      <hr class="horizontal dark my-1">
      <div class="card-body pt-sm-3 pt-0">
        <!-- Sidebar Backgrounds -->
        <div>
          <h6 class="mb-0">Sidebar Colors</h6>
        </div>
        <a href="javascript:void(0)" class="switch-trigger background-color">
          <div class="badge-colors my-2 text-start">
            <span class="badge filter bg-gradient-primary" data-color="primary" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-dark active" data-color="dark" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-info" data-color="info" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-success" data-color="success" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-warning" data-color="warning" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-danger" data-color="danger" onclick="sidebarColor(this)"></span>
          </div>
        </a>
        <!-- Sidenav Type -->
        <div class="mt-3">
          <h6 class="mb-0">Sidenav Type</h6>
          <p class="text-sm">Choose between different sidenav types.</p>
        </div>
        <div class="d-flex">
          <button class="btn bg-gradient-dark px-3 mb-2" data-class="bg-gradient-dark" onclick="sidebarType(this)">Dark</button>
          <button class="btn bg-gradient-dark px-3 mb-2 ms-2" data-class="bg-transparent" onclick="sidebarType(this)">Transparent</button>
          <button class="btn bg-gradient-dark px-3 mb-2  active ms-2" data-class="bg-white" onclick="sidebarType(this)">White</button>
        </div>
        <p class="text-sm d-xl-none d-block mt-2">You can change the sidenav type just on desktop view.</p>
        <!-- Navbar Fixed -->
        <div class="mt-3 d-flex">
          <h6 class="mb-0">Navbar Fixed</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed" onclick="navbarFixed(this)">
          </div>
        </div>
        <hr class="horizontal dark my-3">
        <div class="mt-2 d-flex">
          <h6 class="mb-0">Light / Dark</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version" onclick="darkMode(this)">
          </div>
        </div>

      </div>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
  <script src=" {{ asset('assets/js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src=" {{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
@yield('scripts')

  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src=" {{asset('assets/js/material-dashboard.min.js?v=3.2.0')}}"></script>
  <script src="https://kit.fontawesome.com/8510d63d0e.js" crossorigin="anonymous"></script>
  <!-- Chart.js CDN -->



</body>

</html>
