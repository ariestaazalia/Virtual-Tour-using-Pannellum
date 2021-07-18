<!doctype html>
<html class="no-js" lang="en">

@include('admin.layouts.head')

<body>
    <div id="preloader">
        <div class="loader"></div>
    </div>

    <div class="page-container">
        @include('admin.layouts.sidebar')
        
        <div class="main-content">
            <div class="header-area">
                <div class="row align-items-center">
                    <div class="col-md-6 col-sm-8 clearfix">
                        <div class="nav-btn pull-left">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-4 clearfix">
                        <ul class="notification-area pull-right">
                            <li class="dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>{{Auth::user()->username}} <i class="ti-angle-down"></i> </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('profil') }}">Ubah Profil</a>
                                    <a class="dropdown-item" href="{{ route('ubahPassword') }}">Ubah Password</a>

                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="main-content-inner">
                <div class="sales-report-area mt-5 mb-5">
                    @yield('content')
                </div>
            </div>
        </div>
        
        <footer>
            <div class="footer-area">
                <p>© Copyright <span id="year"></span>. Fakultas Teknik Universitas Jenderal Soedirman.</p>
            </div>
        </footer>
    </div>
    
    @include('admin.layouts.scripts')
    @stack('script')

    <script>
        document.getElementById("year").innerHTML = new Date().getFullYear();
    </script>
</body>
</html>