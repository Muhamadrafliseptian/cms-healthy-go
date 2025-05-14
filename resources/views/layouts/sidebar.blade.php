<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark bg-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <a class="nav-link" href="{{ url('/dashboard') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>

                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts"
                    aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Pages
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>

                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionMenu">
                        @php
                            $homeActive = Request::is('dashboard/home*');
                        @endphp

                        <a class="nav-link {{ $homeActive ? '' : 'collapsed' }}" href="#" data-bs-toggle="collapse"
                            data-bs-target="#homeCollapse" aria-expanded="{{ $homeActive ? 'true' : 'false' }}"
                            aria-controls="homeCollapse">
                            Home
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>

                        <div class="collapse {{ $homeActive ? 'show' : '' }}" id="homeCollapse"
                            data-bs-parent="#sidenavAccordionMenu">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ url('/home') }}">Banner</a>
                                <a class="nav-link" href="{{ url('/partnership') }}">Video</a>
                                <a class="nav-link {{ Request::is('dashboard/home/certificate*') ? 'active' : '' }}" href="{{ route('certificate.index') }}">Certificate</a>
                                <a class="nav-link {{ Request::is('dashboard/home/service*') ? 'active' : '' }}"
                                    href="{{ route('service.index') }}">Layanan</a>
                                <a class="nav-link {{ Request::is('dashboard/home/program*') ? 'active' : '' }}" href="{{ url('dashboard/home/program') }}">Program</a>
                                <a class="nav-link {{ Request::is('dashboard/home/partnership*') ? 'active' : '' }}" href="{{ url('dashboard/home/partnership') }}">Partnership</a>
                                <a class="nav-link {{ Request::is('dashboard/home/testimoni*') ? 'active' : '' }}" href="{{ url('dashboard/home/testimoni') }}">Testimoni</a>
                                <a class="nav-link" href="{{ url('/food') }}">Lokasi</a>
                            </nav>
                        </div>

                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#aboutCollapse"
                            aria-expanded="false" aria-controls="aboutCollapse">
                            About Us
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="aboutCollapse" data-bs-parent="#sidenavAccordionMenu">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ url('/home') }}">Banner</a>
                                <a class="nav-link" href="{{ url('/home') }}">Description</a>
                                <a class="nav-link" href="{{ url('/partnership') }}">Milestone</a>
                                <a class="nav-link" href="{{ url('/partnership') }}">Partnership</a>
                            </nav>
                        </div>

                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#partnerCollapse" aria-expanded="false" aria-controls="partnerCollapse">
                            Partnership
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="partnerCollapse" data-bs-parent="#sidenavAccordionMenu">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ url('/home') }}">Banner</a>
                                <a class="nav-link" href="{{ url('/home') }}">Tag</a>
                                <a class="nav-link" href="{{ url('/partnership') }}">Collaborate</a>
                                <a class="nav-link" href="{{ url('/partnership') }}">Working Together</a>
                                <a class="nav-link" href="{{ url('/partnership') }}">Partnership</a>
                            </nav>
                        </div>

                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#productCollapse" aria-expanded="false" aria-controls="productCollapse">
                            Product & Service
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="productCollapse" data-bs-parent="#sidenavAccordionMenu">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ url('/home') }}">Banner</a>
                                <a class="nav-link" href="{{ url('/home') }}">Tag</a>
                                <a class="nav-link" href="{{ url('/partnership') }}">Solution</a>
                                <a class="nav-link" href="{{ url('/partnership') }}">Promo</a>
                                <a class="nav-link" href="{{ url('/partnership') }}">Program</a>
                                <a class="nav-link" href="{{ url('/partnership') }}">Meal</a>
                            </nav>
                        </div>

                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#foodCollapse"
                            aria-expanded="false" aria-controls="foodCollapse">
                            Food
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="foodCollapse" data-bs-parent="#sidenavAccordionMenu">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ url('/home') }}">Banner</a>
                                <a class="nav-link" href="{{ url('/home') }}">Batch</a>
                                <a class="nav-link" href="{{ url('/partnership') }}">Carousel</a>
                            </nav>
                        </div>
                        <a href="" class="nav-link">
                            Social Media
                        </a>
                        <a href="" class="nav-link">
                            Contact
                        </a>
                        <a href="" class="nav-link">
                            FAQ
                        </a>
                        <a href="" class="nav-link">
                            Terms & Conditions
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </nav>
</div>