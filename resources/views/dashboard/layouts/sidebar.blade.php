<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand">
        <a class="navbar-brand fs-5 fw-bold" href="/">
            PAGU APP
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        {{-- Dashboard --}}
            <li class="menu-item {{ Request::is('dashboard') ? 'active' : '' }}">
                <a href="/dashboard" class="menu-link">
                    <i class="fa-duotone fa-grid-2 me-3"></i>
                    <div data-i18n="Analytics">Dashboard</div>
                </a>
            </li>
            <li class="menu-item {{ Request::is('dashboard/pagu*') ? 'active' : '' }}">
                <a href="/dashboard/pagu" class="menu-link">
                    <i class="fa-duotone fa-note-sticky fa-sm me-3"></i>
                    <div data-i18n="Analytics">Pagu</div>
                </a>
            </li>

            <li class="menu-item {{ Request::is('dashboard/kegiatan*') ? 'active' : '' }}">
                <a href="/dashboard/kegiatan/program" class="menu-link">
                    <i class="fa-duotone fa-chart-line fa-sm me-3"></i>
                    <div data-i18n="Analytics">Kegiatan</div>
                </a>
            </li>

            <li class="menu-item">
                <hr>
            </li>

            <li class="menu-item {{ Request::is('dashboard/pejabat*') ? 'active' : '' }}">
                <a href="/dashboard/pejabat" class="menu-link">
                    <i class="fa-duotone fa-user-tie fa-sm me-3"></i>
                    <div data-i18n="Analytics">Pejabat</div>
                </a>
            </li>

            <li class="menu-item {{ Request::is('dashboard/user*') ? 'active' : '' }}">
                <a href="/dashboard/user" class="menu-link">
                    <i class="fa-duotone fa-users fa-sm me-3"></i>
                    <div data-i18n="Analytics">User</div>
                </a>
            </li>

    </ul>
</aside>
