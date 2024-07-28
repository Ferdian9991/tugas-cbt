@auth
    <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
            <div class="sidebar-brand">
                <a href="">Menu Utama</a>
            </div>
            {{-- <div class="sidebar-brand sidebar-brand-sm">
                <a href="">Menu Utama</a>
            </div> --}}
            <ul class="sidebar-menu">
                <li class="{{ Request::is('packages*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('packages') }}"><i class="fas fa-list"></i><span>Paket Soal</span></a>
                </li>
                <!-- profile ganti password -->
                <li class="menu-header">Profile</li>
                <li class="{{ Request::is('profile/edit') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('profile/edit') }}"><i class="far fa-user"></i>
                        <span>Profile</span></a>
                </li>
                <li class="{{ Request::is('profile/change-password') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('profile/change-password') }}"><i class="fas fa-key"></i> <span>Ganti
                            Password</span></a>
                </li>
            </ul>
        </aside>
    </div>
@endauth
