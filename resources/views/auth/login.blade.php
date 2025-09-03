<!DOCTYPE html>
<html lang="id">

<head>
    <base href="../../../" />
    <title>Login - SITOPAN</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <link rel="shortcut icon" href="/shalvasi2020/public/storage/Logo_SITOPAN_1.png" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="/shalvasi2020/public/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="/shalvasi2020/public/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
</head>

<body id="kt_body" class="auth-bg bgi-size-cover bgi-attachment-fixed bgi-position-center">
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
        <style>
            body {
                background-image: url('/shalvasi2020/public/assets/media/auth/bg10.jpeg');
            }

            [data-bs-theme="dark"] body {
                background-image: url('/shalvasi2020/public/assets/media/auth/bg10-dark.jpeg');
            }
        </style>
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <div class="d-flex flex-lg-row-fluid">
                <div class="d-flex flex-column flex-center pb-0 pb-lg-10 p-10 w-100">
                    <img class="theme-light-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20"
                        src="/shalvasi2020/public/storage/Logo_SITOPAN-removebg-preview.png" alt="" />
                    <img class="theme-dark-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20"
                        src="/shalvasi2020/public/storage/Logo_SITOPAN-removebg-preview.png" alt="" />
                    <h1 class="text-gray-800 fs-2qx fw-bold text-center mb-7">SELAMAT DATANG</h1>
                    <div class="text-gray-600 fs-base text-center fw-semibold">
                        {{ date('Y') }}
                    </div>
                </div>
            </div>
            <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
                <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
                    <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
                        <div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">
                            <form class="form w-100" method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="text-center mb-11">
                                    <h1 class="text-dark fw-bolder mb-3">Masuk</h1>
                                </div>

                                <div class="fv-row mb-8">
                                    <input type="email" placeholder="Alamat Email" name="email"
                                        value="{{ old('email') }}"
                                        class="form-control bg-transparent @error('email') is-invalid @enderror" />
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="fv-row mb-8">
                                    <input type="password" placeholder="Kata Sandi" name="password"
                                        class="form-control bg-transparent @error('password') is-invalid @enderror" />
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">
                                            Ingat Saya
                                        </label>
                                    </div>
                                    <a href="{{ route('password.request') }}" class="link-primary">Lupa Kata Sandi?</a>
                                </div> --}}
                                <div class="d-grid mb-10">
                                    <button type="submit" class="btn btn-primary">Masuk</button>
                                </div>
                                <div class="text-gray-500 text-center fw-semibold fs-6">
                                    Belum memiliki akun?
                                    <a href="{{ route('register') }}" class="link-primary fw-semibold">Daftar</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var hostUrl = "/shalvasi2020/public/assets/";
    </script>
    <script src="/shalvasi2020/public/assets/plugins/global/plugins.bundle.js"></script>
    <script src="/shalvasi2020/public/assets/js/scripts.bundle.js"></script>
    <script src="/shalvasi2020/public/assets/js/custom/authentication/sign-in/general.js"></script>
    @include('my_components.toastr')
	@include('my_components.datatables')
</body>

</html>
