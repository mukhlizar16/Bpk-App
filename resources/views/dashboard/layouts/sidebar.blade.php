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
                <i class="fa-duotone fa-note-sticky me-3"></i>
                <div data-i18n="Analytics">Pagu</div>
            </a>
        </li>

        <li class="menu-item {{ Request::is('dashboard/kontrak*') ? 'active' : '' }}">
            <a href="/dashboard/kontrak" class="menu-link">
                <i class="fa-duotone fa-file-contract me-3"></i>
                <div data-i18n="Analytics">Kontrak</div>
            </a>
        </li>

        <li class="menu-item {{ Request::is('dashboard/adendum*') ? 'active' : '' }}">
            <a href="/dashboard/adendum" class="menu-link">
                <i class="fa-solid fa-file-contract me-3"></i>
                <div data-i18n="Analytics">Adendum</div>
            </a>
        </li>

        <li class="menu-item {{ Request::is('dashboard/sp2d*') ? 'active' : '' }}">
            <a href="/dashboard/sp2d" class="menu-link">
                <i class="fa-regular fa-file-contract me-3"></i>
                <div data-i18n="Analytics">Sp2d</div>
            </a>
        </li>

        <li class="menu-item {{ Request::is('dashboard/spmk*') ? 'active' : '' }}">
            <a href="/dashboard/spmk" class="menu-link">
                <i class="fa-light fa-file-contract me-3"></i>
                <div data-i18n="Analytics">Spmk</div>
            </a>
        </li>

        <li class="menu-item {{ Request::is('dashboard/berita-acara*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="fa-duotone fa-files fa-sm me-3"></i>
                <div data-i18n="Layouts">Berita Acara</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ Request::is('dashboard/berita-acara/pemeriksaan*') ? 'active' : '' }}">
                    <a href="/dashboard/berita-acara/pemeriksaan" class="menu-link">
                        <div data-i18n="Analytics">Pemeriksaan</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('dashboard/berita-acara/bast') ? 'active' : '' }}">
                    <a href="/dashboard/berita-acara/bast" class="menu-link">
                        <div data-i18n="Analytics">BAST</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('dashboard/berita-acara/bast-pho*') ? 'active' : '' }}">
                    <a href="/dashboard/berita-acara/bast-pho" class="menu-link">
                        <div data-i18n="Analytics">BAST PHO</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{ Request::is('dashboard/realisasi*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="fa-duotone fa-chart-network fa-sm me-3"></i>
                <div data-i18n="Layouts">Realisasi Kegiatan</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ Request::is('dashboard/realisasi/keuangan*') ? 'active' : '' }}">
                    <a href="/dashboard/realisasi/keuangan" class="menu-link">
                        <div data-i18n="Analytics">Keuangan</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('dashboard/realisasi/fisik*') ? 'active' : '' }}">
                    <a href="/dashboard/realisasi/fisik" class="menu-link">
                        <div data-i18n="data surat">Fisik</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{ Request::is('dashboard/pejabat*') ? 'active' : '' }}">
            <a href="/dashboard/pejabat" class="menu-link">
                <i class="fa-duotone fa-user-tie fa-sm me-3"></i>
                <div data-i18n="Analytics">Pejabat</div>
            </a>
        </li>


        <li class="menu-item">
            <hr>
        </li>

        <li class="menu-item">
            <p class="menu-link">Master Data</p>
        </li>

        <li class="menu-item {{ Request::is('dashboard/program*') ? 'active' : '' }}">
            <a href="/dashboard/program" class="menu-link">
                <i class="fa-duotone fa-sitemap fa-sm me-3"></i>
                <div data-i18n="Analytics">Program</div>
            </a>
        </li>

        <li class="menu-item {{ Request::is('dashboard/kegiatan*') ? 'active' : '' }}">
            <a href="/dashboard/kegiatan" class="menu-link">
                <i class="fa-duotone fa-chart-line fa-sm me-3"></i>
                <div data-i18n="Analytics">Kegiatan</div>
            </a>
        </li>

        <li class="menu-item {{ Request::is('dashboard/sub-kegiatan*') ? 'active' : '' }}">
            <a href="/dashboard/sub-kegiatan" class="menu-link">
                <i class="fa-duotone fa-objects-column fa-sm me-3"></i>
                <div data-i18n="Analytics">Sub Kegiatan</div>
            </a>
        </li>

        <li class="menu-item {{ Request::is('dashboard/pengadaan*') ? 'active' : '' }}">
            <a href="/dashboard/pengadaan" class="menu-link">
                <i class="fa-duotone fa-megaphone fa-sm me-3"></i>
                <div data-i18n="Analytics">Jenis Pengadaan</div>
            </a>
        </li>

        <li class="menu-item {{ Request::is('dashboard/dana*') ? 'active' : '' }}">
            <a href="/dashboard/dana" class="menu-link">
                <i class="fa-duotone fa-money-simple-from-bracket fa-sm me-3"></i>
                <div data-i18n="Analytics">Sumber Dana</div>
            </a>
        </li>

        <li class="menu-item {{ Request::is('dashboard/jabatan*') ? 'active' : '' }}">
            <a href="/dashboard/jabatan" class="menu-link">
                <i class="fa-duotone fa-person-arrow-up-from-line fa-sm me-3"></i>
                <div data-i18n="Analytics">Jabatan</div>
            </a>
        </li>


    </ul>
</aside>
