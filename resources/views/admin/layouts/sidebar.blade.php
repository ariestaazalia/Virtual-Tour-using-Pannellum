<div class="sidebar-menu">
    <div class="sidebar-header">
        <div class="logo">
            <a href="#"><img src="{{asset('img/logoAdmin.png')}}" alt="logo"></a>
        </div>
    </div>
    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu">
                    <li class="{{ Request::routeIs('home') ? 'active' : '' }}">
                        <a href="{{ route('home') }}"><i class="ti-home"></i><span>Dashboard</span></a>
                    </li>
                    
                    <li class="{{ Request::routeIs('config') ? 'active' : '' }}">
                        <a href="{{ route('config') }}"><i class="ti-map-alt"></i> <span>Scene dan Hotspot</span></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>