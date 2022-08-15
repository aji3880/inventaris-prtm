<aside class="menu-sidebar d-none d-lg-block">
    <div class="logo">
        <a href="dashboard">
            <img src="{{ URL::asset('images/pertamina.png') }}" alt="Cool Admin" />
        </a>
    </div>
    <div class="menu-sidebar__content js-scrollbar1">
        <nav class="navbar-sidebar">
            <ul class="list-unstyled navbar__list">
                <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                    <a class="js-arrows" href="dashboard">
                        <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                </li>
                <li class="{{ Request::is('barang') ? 'active' : '' }} {{ Request::is('create') ? 'active' : '' }}">
                    <a href="barang">
                        <i class="fas fa-table" ></i>Barang</a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
