<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark bg-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <a class="nav-link" href="{{ url('/dashboard') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>

                @php
                    $pagesActive =
                        Request::is('dashboard/home*') ||
                        Request::is('dashboard/about-us*') ||
                        Request::is('dashboard/partnership*') ||
                        Request::is('dashboard/product-service*') ||
                        Request::is('dashboard/food*') ||
                        Request::is('dashboard/etc*') ||
                        Request::is('dashboard/iklan*') ||
                        Request::is('dashboard/master*');
                @endphp

                <a class="nav-link {{ $pagesActive ? '' : 'collapsed' }}" href="#" data-bs-toggle="collapse"
                    data-bs-target="#collapseLayouts" aria-expanded="{{ $pagesActive ? 'true' : 'false' }}"
                    aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Pages
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>

                <div class="collapse {{ $pagesActive ? 'show' : '' }}" id="collapseLayouts" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionMenu">
                        @php
                            $homeActive = Request::is('dashboard/home*');
                            $aboutActive = Request::is('dashboard/about-us*');
                            $productActive = Request::is('dashboard/product-service*');
                            $foodActive = Request::is('dashboard/food*');
                            $sosmedActive = Request::is('dashboard/etc*');
                            $masterActive = Request::is('dashboard/master/konten*');
                            $iklanActive = Request::is('dashboard/iklan*');
                        @endphp

                        <a class="nav-link {{ Request::is('dashboard/master*') ? 'active' : '' }}"
                            href="{{ route('scategory.index') }}">
                            Master Category
                        </a>

                        <a class="nav-link {{ $masterActive ? '' : 'collapsed' }}" href="#"
                            data-bs-toggle="collapse" data-bs-target="#masterKontenCollapse"
                            aria-expanded="{{ $masterActive ? 'true' : 'false' }}" aria-controls="masterKontenCollapse">
                            Master
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>

                        <div class="collapse {{ $masterActive ? 'show' : '' }}" id="masterKontenCollapse"
                            data-bs-parent="#sidenavAccordionMenu">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link {{ Request::is('dashboard/master/konten/certificate*') ? 'active' : '' }}"
                                    href="{{ route('certificate.index') }}">Certificate</a>
                                <a class="nav-link {{ Request::is('dashboard/master/konten/program*') ? 'active' : '' }}"
                                    href="{{ route('program.index') }}">Program</a>
                                <a class="nav-link {{ Request::is('dashboard/master/konten/testimoni*') ? 'active' : '' }}"
                                    href="{{ route('testimoni.index') }}">Testimoni</a>
                                <a class="nav-link {{ Request::is('dashboard/master/konten/partnership*') ? 'active' : '' }}"
                                    href="{{ route('partnershipHome.index') }}">Partnership</a>
                                <a class="nav-link {{ Request::is('dashboard/master/konten/meal*') ? 'active' : '' }}"
                                    href="{{ route('meal.index') }}">Meal</a>
                                <a class="nav-link {{ Request::is('dashboard/master/konten/batch-menu*') ? 'active' : '' }}"
                                    href="{{ route('batch-menu.index') }}">Batch</a>
                                <a class="nav-link {{ Request::is('dashboard/master/konten/statistic*') ? 'active' : '' }}"
                                    href="{{ route('statistic.index') }}">Statistic</a>
                            </nav>
                        </div>

                        <a class="nav-link {{ $homeActive ? '' : 'collapsed' }}" href="#"
                            data-bs-toggle="collapse" data-bs-target="#homeCollapse"
                            aria-expanded="{{ $homeActive ? 'true' : 'false' }}" aria-controls="homeCollapse">
                            Home
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>

                        <div class="collapse {{ $homeActive ? 'show' : '' }}" id="homeCollapse"
                            data-bs-parent="#sidenavAccordionMenu">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ url('/home') }}">Banner</a>
                                <a class="nav-link {{ Request::is('dashboard/home/video*') ? 'active' : '' }}"
                                    href="{{ route('video.index') }}">Video</a>
                                <a class="nav-link {{ Request::is('dashboard/home/service*') ? 'active' : '' }}"
                                    href="{{ route('service.index') }}">Layanan</a>
                            </nav>
                        </div>

                        <a class="nav-link {{ $aboutActive ? '' : 'collapsed' }}" href="#"
                            data-bs-toggle="collapse" data-bs-target="#aboutCollapse"
                            aria-expanded="{{ $aboutActive ? 'true' : 'false' }}" aria-controls="aboutCollapse">
                            About Us
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse {{ $aboutActive ? 'show' : '' }}" id="aboutCollapse"
                            data-bs-parent="#sidenavAccordionMenu">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ url('/home') }}">Banner</a>
                                <a class="nav-link" href="{{ url('/home') }}">Description</a>
                                <a class="nav-link {{ Request::is('dashboard/about-us/milestone*') ? 'active' : '' }}"
                                    href="{{ route('milestone.index') }}">Milestone</a>
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

                        <a class="nav-link {{ $productActive ? '' : 'collapsed' }}" href="#"
                            data-bs-toggle="collapse" data-bs-target="#productCollapse"
                            aria-expanded="{{ $productActive ? 'true' : 'false' }}" aria-controls="productCollapse">
                            Product & Service
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse {{ $productActive ? 'show' : '' }}" id="productCollapse"
                            data-bs-parent="#sidenavAccordionMenu">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ url('/home') }}">Banner</a>
                                <a class="nav-link" href="{{ url('/home') }}">Tag</a>
                                <a class="nav-link" href="{{ url('/partnership') }}">Solution</a>
                                <a class="nav-link {{ Request::is('dashboard/product-service/promo*') ? 'active' : '' }}"
                                    href="{{ route('promo.index') }}">Promo</a>
                            </nav>
                        </div>

                        <a class="nav-link {{ $foodActive ? '' : 'collapsed' }}" href="#"
                            data-bs-toggle="collapse" data-bs-target="#foodCollapse"
                            aria-expanded="{{ $productActive ? 'true' : 'false' }}" aria-controls="foodCollapse">
                            Food
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse {{ $foodActive ? 'show' : '' }}" id="foodCollapse"
                            data-bs-parent="#sidenavAccordionMenu">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ url('/home') }}">Banner</a>
                                <a class="nav-link {{ Request::is('dashboard/food/carousel*') ? 'active' : '' }}"
                                    href="{{ route('carousel.index') }}">Carousel</a>
                            </nav>
                        </div>

                        <a class="nav-link {{ $iklanActive ? '' : 'collapsed' }}" href="#"
                            data-bs-toggle="collapse" data-bs-target="#iklanCollapse"
                            aria-expanded="{{ $iklanActive ? 'true' : 'false' }}" aria-controls="iklanCollapse">
                            Iklan
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>

                        <div class="collapse {{ $iklanActive ? 'show' : '' }}" id="iklanCollapse"
                            data-bs-parent="#sidenavAccordionMenu">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link {{ Request::is('dashboard/iklan/achievement*') ? 'active' : '' }}"
                                    href="{{ route('achievement.index') }}">Achievement</a>
                                <a class="nav-link {{ Request::is('dashboard/iklan/banner*') ? 'active' : '' }}"
                                    href="{{ route('banner.index') }}">Banner</a>
                                <a class="nav-link {{ Request::is('dashboard/iklan/benefit*') ? 'active' : '' }}"
                                    href="{{ route('benefits.index') }}">Benefit</a>
                                <a class="nav-link {{ Request::is('dashboard/iklan/galeri*') ? 'active' : '' }}"
                                    href="{{ route('galeri.index') }}">Galeri</a>
                                <a class="nav-link {{ Request::is('dashboard/iklan/goals*') ? 'active' : '' }}"
                                    href="{{ route('goals.index') }}">Goals</a>
                                <a class="nav-link {{ Request::is('dashboard/iklan/pains*') ? 'active' : '' }}"
                                    href="{{ route('pains.index') }}">Pains</a>
                                <a class="nav-link {{ Request::is('dashboard/iklan/promo*') ? 'active' : '' }}"
                                    href="{{ route('promoIklan.index') }}">Promo</a>
                            </nav>
                        </div>

                        <a class="nav-link {{ Request::is('dashboard/etc/sosmed*') ? 'active' : '' }}"
                            href="{{ route('sosmed.index') }}">
                            Social Media
                        </a>

                        <a class="nav-link {{ Request::is('dashboard/etc/contact*') ? 'active' : '' }}"
                            href="{{ route('contact.index') }}">
                            Contact
                        </a>
                        <a class="nav-link {{ Request::is('dashboard/etc/faq*') ? 'active' : '' }}"
                            href="{{ route('faq.index') }}">
                            FAQ
                        </a>
                        <a class="nav-link {{ Request::is('dashboard/etc/tnc*') ? 'active' : '' }}"
                            href="{{ route('tnc.index') }}">
                            Terms & Conditions
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </nav>
</div>
