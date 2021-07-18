<!doctype html>
<html class="no-js" lang="en">

@include('admin.layouts.head')

<body>
    <div id="preloader">
        <div class="loader"></div>
    </div>

    @yield('content')

    @include('admin.layouts.scripts')
</body>

</html>