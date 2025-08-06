<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Furnitica - Quản trị viên</title>
    <link rel="shortcut icon" type="image/png" href="/assets/admin/images/logos/favicon.png" />
    <link rel="stylesheet" href="/assets/admin/css/styles.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@700&display=swap" rel="stylesheet">
    <style>
        .mh-logo-text {
            font-family: 'Baloo 2', cursive;
            font-weight: 700;
            font-size: 1.8rem;
            color: #111;
            letter-spacing: 1px;
        }
    </style>
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-between">
                    <a href="{{route("admin.dashboard")}}" class="text-nowrap logo-img">
                        <span class="mh-logo-text">MH Fashion</span>
                    </a>
                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="ti ti-x fs-8"></i>
                    </div>
                </div>
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Quản lý</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{route('admin.dashboard')}}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-dashboard"></i>
                                </span>
                                <span class="hide-menu">Trang chủ</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{route('category.index')}}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-category"></i>
                                </span>
                                <span class="hide-menu">Danh mục</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{route('brand.index')}}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-ballpen"></i>
                                </span>
                                <span class="hide-menu">Thương hiệu</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{route('origin.index')}}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-table-export"></i>
                                </span>
                                <span class="hide-menu">Nơi sản xuất</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link"  href="{{route('product.index')}}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-book-2"></i>
                                </span>
                                <span class="hide-menu">Sản phẩm</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{route('staff.index')}}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-user-plus"></i>
                                </span>
                                <span class="hide-menu">Nhân viên</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{route('order.index')}}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-file-invoice"></i>
                                </span>
                                <span class="hide-menu">Đơn hàng</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{route('user.index')}}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-users"></i>
                                </span>
                                <span class="hide-menu">Khách hàng</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{route('post_type.index')}}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-category"></i>
                                </span>
                                <span class="hide-menu">Thể loại bài viết</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{route('post.index')}}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-ballpen"></i>
                                </span>
                                <span class="hide-menu">Bài viết</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('admin.contacts') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-message-circle"></i>
                                </span>
                                <span class="hide-menu">Liên hệ</span>
                            </a>
                        </li>
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Tài khoản</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{route('admin.password')}}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-lock"></i>
                                </span>
                                <span class="hide-menu">Đổi mật khẩu</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{route('admin.logout')}}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-logout"></i>
                                </span>
                                <span class="hide-menu">Đăng xuất</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            <header class="app-header">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <ul class="navbar-nav">
                        <li class="nav-item d-block d-xl-none">
                            <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse"
                                href="javascript:void(0)">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                            <li class="nav-item dropdown">
                                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="/assets/admin/images/profile/user-1.jpg" alt="" width="35" height="35"
                                        class="rounded-circle">
                                </a>
                                <!-- <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up"
                                    aria-labelledby="drop2">
                                    <div class="message-body">
                                        <a href="javascript:void(0)"
                                            class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-user fs-6"></i>
                                            <p class="mb-0 fs-3">My Profile</p>
                                        </a>
                                        <a href="./authentication-login.html"
                                            class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                                    </div>
                                </div> -->
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!--  Header End -->

            @yield('content')

        </div>
    </div>
    <script src="/assets/admin/libs/jquery/dist/jquery.min.js"></script>
    <script src="/assets/admin/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/admin/js/sidebarmenu.js"></script>
    <script src="/assets/admin/js/app.min.js"></script>
    <script src="/assets/admin/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script src="/assets/admin/libs/simplebar/dist/simplebar.js"></script>
    <script src="/assets/admin/js/dashboard.js"></script>
    <script src="/assets/admin/js/my_script.js"></script>
    @stack('js')
</body>

</html>