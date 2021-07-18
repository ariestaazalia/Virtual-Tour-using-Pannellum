<!doctype html>
<html class="no-js" lang="en">

@include('admin.layouts.head')

<body>
    <div id="preloader">
        <div class="loader"></div>
    </div>

    <div class="main-content-inner">
        <div class="sales-report-area mt-5 mb-5">
            @yield('content')
        </div>
    </div>

    @include('admin.layouts.scripts')
    @stack('script')
</body>
</html>