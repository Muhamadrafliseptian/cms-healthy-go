<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion" style="background-color: black;">
        <div class="sb-sidenav-menu">
            <div class="nav">
                @php
                    $pagesActive =
                        Request::is('dashboard/home*') ||
                        Request::is('dashboard/about-us*') ||
                        Request::is('dashboard/partnership*') ||
                        Request::is('dashboard/product-service*') ||
                        Request::is('dashboard/food*') ||
                        Request::is('dashboard/etc/faq*') ||
                        Request::is('dashboard/etc/tnc*') ||
                        Request::is('dashboard/iklan*') ||
                        Request::is('dashboard/master/konten*') ||
                        Request::is('dashboard/master/section-category*') ||
                        Request::is('dashboard/administrator*') ||
                        Request::is('dashboard/meta*');
                @endphp

                <div class="{{ $pagesActive ? 'show' : '' }}">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionMenu">
                        @php
                            $homeActive = Request::is('dashboard/home*');
                            $aboutActive = Request::is('dashboard/about-us*');
                            $productActive = Request::is('dashboard/product-service*');
                            $foodActive = Request::is('dashboard/food*');
                            $faqActive = Request::is('dashboard/etc/faq*');
                            $tncActive = Request::is('dashboard/etc/tnc*');
                            $masterActive = Request::is('dashboard/master/konten*');
                            $iklanActive = Request::is('dashboard/iklan*');
                            $partnershipActive = Request::is('dashboard/partnership*');
                        @endphp
                        <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}"
                            href="{{ route('dashboard') }}">
                            Dashboard
                        </a>
                        <a class="nav-link {{ Request::is('dashboard/master/section-category*') ? 'active' : '' }}"
                            href="{{ route('scategory.index') }}">
                            Master Category
                        </a>
                        <a class="nav-link {{ Request::is('dashboard/meta*') ? 'active' : '' }}"
                            href="{{ route('meta.index') }}">
                            Meta
                        </a>

                        <a class="nav-link {{ Request::is('dashboard/administrator*') ? 'active' : '' }}"
                            href="{{ route('administrator.index') }}">
                            Administrator
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
                                <a class="nav-link {{ Request::is('dashboard/master/konten/menu*') ? 'active' : '' }}"
                                    href="{{ route('batch-menu.index') }}">Menu</a>
                                <a class="nav-link {{ Request::is('dashboard/master/konten/batch*') ? 'active' : '' }}"
                                    href="{{ route('batch.index') }}">Batch</a>
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
                                <a class="nav-link {{ Request::is('dashboard/home/banner*') ? 'active' : '' }}"
                                    href="{{ route('section.home.index') }}">Banner</a>
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
                                <a class="nav-link {{ Request::is('dashboard/about-us/banner*') ? 'active' : '' }}"
                                    href="{{ route('section.about.index') }}">Banner</a>
                                <a class="nav-link {{ Request::is('dashboard/about-us/description*') ? 'active' : '' }}"
                                    href="{{ route('section.about.description.index') }}">Description</a>
                                <a class="nav-link {{ Request::is('dashboard/about-us/milestone*') ? 'active' : '' }}"
                                    href="{{ route('milestone.index') }}">Milestone</a>
                            </nav>
                        </div>

                        <a class="nav-link {{ $partnershipActive ? '' : 'collapsed' }}" href="#"
                            data-bs-toggle="collapse" data-bs-target="#partnerCollapse" aria-expanded="false"
                            aria-controls="partnerCollapse">
                            Partnership
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse {{ $partnershipActive ? 'show' : '' }}" id="partnerCollapse"
                            data-bs-parent="#sidenavAccordionMenu">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link {{ Request::is('dashboard/partnership/banner*') ? 'active' : '' }}"
                                    href="{{ route('section.partnership.banner.index') }}">Banner</a>
                                <a class="nav-link {{ Request::is('dashboard/partnership/tag*') ? 'active' : '' }}"
                                    href="{{ route('section.partnership.tag.index') }}">Tag</a>
                                <a class="nav-link {{ Request::is('dashboard/partnership/collaborate*') ? 'active' : '' }}"
                                    href="{{ route('section.partnership.collaborate.index') }}">Collaborate</a>
                                <a class="nav-link {{ Request::is('dashboard/partnership/hero*') ? 'active' : '' }}"
                                    href="{{ route('section.partnership.hero.index') }}">Working Together</a>
                                <a class="nav-link {{ Request::is('dashboard/partnership/main*') ? 'active' : '' }}"
                                    href="{{ route('partnership.index') }}">Partnership</a>
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
                                <a class="nav-link {{ Request::is('dashboard/product-service/banner*') ? 'active' : '' }}"
                                    href="{{ route('section.product.banner.index') }}">Banner</a>
                                <a class="nav-link {{ Request::is('dashboard/product-service/tag*') ? 'active' : '' }}"
                                    href="{{ route('section.product.tag.index') }}">Tag</a>
                                <a class="nav-link {{ Request::is('dashboard/product-service/solution*') ? 'active' : '' }}"
                                    href="{{ route('section.product.solution.index') }}">Solution</a>
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
                                <a class="nav-link {{ Request::is('dashboard/food/banner*') ? 'active' : '' }}"
                                    href="{{ route('section.food.banner.index') }}">Banner</a>
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

                        <a class="nav-link {{ $faqActive ? '' : 'collapsed' }}" href="#"
                            data-bs-toggle="collapse" data-bs-target="#FAQ"
                            aria-expanded="{{ $faqActive ? 'true' : 'false' }}" aria-controls="FAQ">
                            FAQ
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>

                        <div class="collapse {{ $faqActive ? 'show' : '' }}" id="FAQ"
                            data-bs-parent="#sidenavAccordionMenu">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link {{ Request::is('dashboard/etc/faq/section/banner*') ? 'active' : '' }}"
                                    href="{{ route('section.faq.banner.index') }}">Banner</a>
                                <a class="nav-link {{ Request::is('dashboard/etc/faq/section/main*') ? 'active' : '' }}"
                                    href="{{ route('faq.index') }}">Main</a>
                            </nav>
                        </div>
                        <a class="nav-link {{ $tncActive ? '' : 'collapsed' }}" href="#"
                            data-bs-toggle="collapse" data-bs-target="#tncCollapse"
                            aria-expanded="{{ $tncActive ? 'true' : 'false' }}" aria-controls="tncCollapse">
                            TNC
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>

                        <div class="collapse {{ $tncActive ? 'show' : '' }}" id="tncCollapse"
                            data-bs-parent="#sidenavAccordionMenu">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link {{ Request::is('dashboard/etc/tnc/section/banner*') ? 'active' : '' }}"
                                    href="{{ route('tnc.indexBanner') }}">Banner</a>
                                <a class="nav-link {{ Request::is('dashboard/etc/tnc/section/reschedule*') ? 'active' : '' }}"
                                    href="{{ route('section.tnc.reschedule.index') }}">Reschedule</a>
                                <a class="nav-link {{ Request::is('dashboard/etc/tnc/section/how-to-eat*') ? 'active' : '' }}"
                                    href="{{ route('section.tnc.hte.index') }}">How To Eat</a>
                                <a class="nav-link {{ Request::is('dashboard/etc/tnc/section/garansi*') ? 'active' : '' }}"
                                    href="{{ route('section.tnc.garansi.index') }}">Klaim Garansi</a>
                                <a class="nav-link {{ Request::is('dashboard/etc/tnc/section/skfm*') ? 'active' : '' }}"
                                    href="{{ route('section.tnc.sk.index') }}">Syarat Ketentuan</a>
                                <a class="nav-link {{ Request::is('dashboard/etc/tnc/section/jadwal-pengiriman*') ? 'active' : '' }}"
                                    href="{{ route('section.tnc.jadwal.index') }}">Jadwal Pengiriman</a>
                                <a class="nav-link {{ Request::is('dashboard/etc/tnc/section/notes-delivery*') ? 'active' : '' }}"
                                    href="{{ route('tnc.index') }}">Notes Pengantaran</a>
                            </nav>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </nav>
</div>
