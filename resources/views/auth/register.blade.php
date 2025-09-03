<!DOCTYPE html>
<html lang="id">
<head>
    <base href="../../../"/>
    <title>Daftar - SITOPAN</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="/shalvasi2020/public/storage/Logo_SITOPAN_1.png" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="/shalvasi2020/public/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="/shalvasi2020/public/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
</head>

<body id="kt_body" class="auth-bg bgi-size-cover bgi-attachment-fixed bgi-position-center">
    <div class="d-flex flex-column flex-root">
        <style>body { background-image: url('/shalvasi2020/public/assets/media/auth/bg10.jpeg'); }</style>
        
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <!--begin::Aside-->
            <div class="d-flex flex-lg-row-fluid">
                <div class="d-flex flex-column flex-center pb-0 pb-lg-10 p-10 w-100">
                    <img class="theme-light-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20" src="/shalvasi2020/public/storage/Logo_SITOPAN-removebg-preview.png" alt="" />
                    <h1 class="text-gray-800 fs-2qx fw-bold text-center mb-7">SELAMAT DATANG</h1>
                    <div class="text-gray-600 fs-base text-center fw-semibold">
                        {{ date('Y') }}
                    </div>
                </div>
            </div>

            <!--begin::Body-->
            <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
                <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
                    <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
                        <div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">
                            
                            <form class="form w-100" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                                @csrf
                                
                                <div class="text-center mb-11">
                                    <h1 class="text-dark fw-bolder mb-3">Daftar Akun</h1>
                                </div>

                                <div class="fv-row mb-8">
                                    <input type="text" placeholder="Username" name="name" value="{{ old('name') }}" 
                                        class="form-control bg-transparent @error('name') is-invalid @enderror" />
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="fv-row mb-8">
                                    <input type="text" placeholder="Nama Lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" 
                                        class="form-control bg-transparent @error('nama_lengkap') is-invalid @enderror" />
                                    @error('nama_lengkap')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="fv-row mb-8">
                                    <input type="email" placeholder="Alamat Email" name="email" value="{{ old('email') }}" 
                                        class="form-control bg-transparent @error('email') is-invalid @enderror" />
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="fv-row mb-8">
                                    <input type="text" placeholder="Nomor Telepon" name="no_telp" value="{{ old('no_telp') }}" 
                                        class="form-control bg-transparent @error('no_telp') is-invalid @enderror" />
                                    @error('no_telp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="fv-row mb-8">
                                    <textarea placeholder="Alamat Lengkap" name="alamat" 
                                        class="form-control bg-transparent @error('alamat') is-invalid @enderror" 
                                        rows="3">{{ old('alamat') }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="fv-row mb-8">
                                    <label class="form-label">Foto Profil</label>
                                    <input type="file" name="foto" accept="image/*"
                                        class="form-control bg-transparent @error('foto') is-invalid @enderror" />
                                    @error('foto')
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

                                <div class="fv-row mb-8">
                                    <input type="password" placeholder="Ulangi Kata Sandi" name="password_confirmation" 
                                        class="form-control bg-transparent" />
                                </div>

                                <div class="d-grid mb-10">
                                    <button type="submit" class="btn btn-primary">Daftar Sekarang</button>
                                </div>

                                <div class="text-gray-500 text-center fw-semibold fs-6">
                                    Sudah memiliki akun?
                                    <a href="{{ route('login') }}" class="link-primary fw-semibold">Masuk</a>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>var hostUrl = "/shalvasi2020/public/assets/";</script>
    <script src="/shalvasi2020/public/assets/plugins/global/plugins.bundle.js"></script>
    <script src="/shalvasi2020/public/assets/js/scripts.bundle.js"></script>
    @include('my_components.toastr')
    @include('my_components.datatables')
</body>
</html> 