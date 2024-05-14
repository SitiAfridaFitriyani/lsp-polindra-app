<div class="sidebar-wrapper sidebar-theme">
    <nav id="sidebar">
        <div class="profile-info">
            <figure class="user-cover-image"></figure>
            <div class="user-info">
                <img src="{{ asset('admin/assets/img/nopict.png') }}" alt="avatar">
                <h6 class="">Sonia Shaw</h6>
                <p class="">Project Leader</p>
            </div>
        </div>
        <div class="shadow-bottom"></div>
        <ul class="list-unstyled menu-categories" id="accordionExample">
            <li @class(['menu', 'active' => request()->route()->getName() === 'dashboard'])>
                <a href="{{ route('dashboard') }}" aria-expanded="{{ request()->route()->getName() === 'dashboard' ? 'true': 'false' }}" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        <span>Dashboard</span>
                    </div>
                </a>
            </li>
            <li class="menu menu-heading">
                <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg><span>MASTER DATA</span></div>
            </li>
            <li @class(['menu','active' => request()->routeIs('event.*') || request()->routeIs('skema.*') || request()->routeIs('unitKompetensi.*') || request()->routeIs('elemen.*') || request()->routeIs('kriteriaUnjukKerja.*') || request()->routeIs('berkasPermohonan.*') || request()->routeIs('ujianTulis.*') || request()->routeIs('ujianPraktek.*')])>
                <a href="#perangkat-assesmen" data-toggle="collapse" aria-expanded="{{ request()->routeIs('event.*') || request()->routeIs('skema.*') || request()->routeIs('unitKompetensi.*') || request()->routeIs('elemen.*') || request()->routeIs('kriteriaUnjukKerja.*') || request()->routeIs('berkasPermohonan.*') || request()->routeIs('ujianTulis.*') || request()->routeIs('ujianPraktek.*') ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>                        <span>Perangkat Assesmen</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul @class(['collapse','submenu','list-unstyled','show' => request()->routeIs('event.*') || request()->routeIs('skema.*') || request()->routeIs('unitKompetensi.*') || request()->routeIs('elemen.*') || request()->routeIs('kriteriaUnjukKerja.*') || request()->routeIs('berkasPermohonan.*') || request()->routeIs('ujianTulis.*') || request()->routeIs('ujianPraktek.*')]) id="perangkat-assesmen" data-parent="#accordionExample">
                    <li @class(['active' => request()->routeIs('event.*')])>
                        <a href="{{ route('event.index') }}"> Event </a>
                    </li>
                    <li @class(['active' => request()->routeIs('skema.*')])>
                        <a href="{{ route('skema.index') }}"> Skema  </a>
                    </li>
                    <li @class(['active' => request()->routeIs('unitKompetensi.*')])>
                        <a href="{{ route('unitKompetensi.index') }}"> Unit Kompetensi </a>
                    </li>
                    <li @class(['active' => request()->routeIs('elemen.*')])>
                        <a href="{{ route('elemen.index') }}"> Elemen </a>
                    </li>
                    <li @class(['active' => request()->routeIs('kriteriaUnjukKerja.*')])>
                        <a href="{{ route('kriteriaUnjukKerja.index') }}"> Kriteria Unjuk Kerja </a>
                    </li>
                    <li @class(['active' => request()->routeIs('berkasPermohonan.*')])>
                        <a href="{{ route('berkasPermohonan.index') }}"> Berkas Permohonan </a>
                    </li>
                    <li @class(['active' => request()->routeIs('ujianTulis.*')])>
                        <a href="{{ route('ujianTulis.index') }}"> Ujian Tulis </a>
                    </li>
                    <li @class(['active' => request()->routeIs('ujianPraktek.*')])>
                        <a href="{{ route('ujianPraktek.index') }}"> Ujian Praktek </a>
                    </li>
                </ul>
            </li>
            <li @class(['menu','active' => request()->routeIs('jurusan.*') || request()->routeIs('kelas.*')])>
                <a href="#instrumen-pendukung" data-toggle="collapse" aria-expanded="{{ request()->routeIs('jurusan.*') || request()->routeIs('kelas.*') ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-package"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>                        <span>Instrumen Pendukung</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul @class(['collapse','submenu','list-unstyled','show' => request()->routeIs('jurusan.*') || request()->routeIs('kelas.*')]) id="instrumen-pendukung" data-parent="#accordionExample">
                    <li @class(['active' => request()->routeIs('jurusan.*')])>
                        <a href="{{ route('jurusan.index') }}"> Jurusan </a>
                    </li>
                    <li @class(['active' => request()->routeIs('kelas.*')])>
                        <a href="{{ route('kelas.index') }}"> Kelas </a>
                    </li>
                </ul>
            </li>
            <li class="menu">
                <a href="#users" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        <span>Pengguna</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="users" data-parent="#accordionExample">
                    <li>
                        <a href="user_profile.html"> Asesor </a>
                    </li>
                    <li>
                        <a href="user_account_setting.html"> Asesi </a>
                    </li>
                </ul>
            </li>

            <li class="menu menu-heading">
                <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg><span>PENGATURAN UMUM</span></div>
            </li>

            <li class="menu">
                <a href="table_basic.html" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                        <span>Pengaturan</span>
                    </div>
                </a>
            </li>
        </ul>

    </nav>

</div>
