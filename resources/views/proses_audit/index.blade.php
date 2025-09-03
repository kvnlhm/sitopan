@extends('master')
@section('judul', 'Proses Assessment')
@section('konten')
    <div class="toolbar mb-5 mb-lg-7" id="kt_toolbar">
        <div class="page-title d-flex flex-column me-3">
            <h1 class="d-flex text-dark fw-bold my-1 fs-3">Proses Assessment</h1>
            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                <li class="breadcrumb-item text-gray-600">
                    <a href="{{ url('dashboard') }}" class="text-gray-600 text-hover-primary">
                        <i class="ki-duotone ki-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item text-gray-500">Proses Assessment</li>
            </ul>
        </div>
    </div>
    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3 mb-1">Tabel</span>
                <span class="text-muted mt-1 fw-semibold fs-7">Daftar Proses Assessment</span>
            </h3>
            <div class="card-toolbar">
                <a href="#" data-bs-toggle="modal" data-bs-target="#modal_form_tambah"
                    class="btn btn-sm btn-light-primary">
                    <i class="ki-duotone ki-plus fs-2"></i>Tambah Proses Assessment
                </a>
            </div>
        </div>
        <div class="card-body py-3">
            <div class="table-responsive">
                <table id="kt_datatable_dom_positioning"
                    class="table table-row-bordered border rounded align-middle gs-0 gy-4">
                    <thead>
                        <tr class="fw-bold text-muted bg-light">
                            <th class="ps-4 min-w-40px rounded-start">No.</th>
                            <th class="min-w-100px">Nama Proses</th>
                            <th class="min-w-100px">Deskripsi</th>
                            <th class="min-w-100px text-center rounded-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($data as $dt)
                            <tr>
                                <td class="ps-4 text-dark fw-bold text-hover-primary mb-1 fs-6">
                                    {{ $i }}
                                </td>
                                <td class="text-dark fw-bold text-hover-primary mb-1 fs-6">
                                    {{ $dt->nama }}
                                </td>
                                <td class="text-dark fw-bold text-hover-primary mb-1 fs-6">
                                    {{ $dt->deskripsi }}
                                </td>
                                <td class="text-center">
                                    <button
                                        onclick="edit({{ $dt->id_proses }},'{{ $dt->nama }}','{{ $dt->deskripsi }}')"
                                        title="Edit Proses Assessment"
                                        class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                        <i class="ki-duotone ki-pencil fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </button>
                                    <button onclick="hapus({{ $dt->id_proses }},'{{ $dt->nama }}')"
                                        title="Hapus Proses Assessment"
                                        class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm">
                                        <i class="ki-duotone ki-trash fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                            <span class="path5"></span>
                                        </i>
                                    </button>
                                </td>
                            </tr>
                            @php
                                $i++;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <div class="modal fade" id="modal_form_tambah" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content rounded">
                <div class="modal-header pb-0 border-0 justify-content-end">
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                </div>
                <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                    <form action="{{ url('proses-audit') }}" method="POST" class="form">
                        @csrf
                        <div class="mb-13 text-center">
                            <h1 class="mb-3">Form Tambah Proses Assessment</h1>
                            <div class="text-muted fw-semibold fs-5">Silahkan isikan data dengan sesuai.</div>
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label for="nama" class="required fs-6 fw-semibold mb-2">Nama Proses</label>
                            <input type="text" id="nama" name="nama"
                                class="form-control form-control-solid @error('nama') is-invalid @enderror"
                                placeholder="Masukkan nama proses assessment"
                                required />
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label for="deskripsi" class="required fs-6 fw-semibold mb-2">Deskripsi</label>
                            <textarea class="form-control form-control-solid @error('deskripsi') is-invalid @enderror" 
                                name="deskripsi" id="deskripsi" 
                                rows="3" 
                                placeholder="Masukkan deskripsi proses assessment"
                                required></textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="text-center">
                            <button type="reset" class="btn btn-light me-3">Reset</button>
                            <button type="submit" class="btn btn-primary">
                                <span class="indicator-label">Simpan</span>
                                <span class="indicator-progress">Mohon menunggu...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_form_update" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content rounded">
                <div class="modal-header pb-0 border-0 justify-content-end">
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                </div>
                <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                    <form id="updateform" action="{{ url('proses-audit/update') }}" method="POST" class="form">
                        @csrf
                        <input type="hidden" id="id_proses" name="id">
                        <div class="mb-13 text-center">
                            <h1 class="mb-3">Form Update Proses Assessment</h1>
                            <div class="text-muted fw-semibold fs-5">Silahkan isikan data dengan sesuai.</div>
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label for="nama_ubah" class="required fs-6 fw-semibold mb-2">Nama Proses</label>
                            <input type="text" id="nama_ubah" name="nama"
                                class="form-control form-control-solid @error('nama') is-invalid @enderror"
                                placeholder="Masukkan nama proses assessment"
                                required />
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label for="deskripsi_ubah" class="required fs-6 fw-semibold mb-2">Deskripsi</label>
                            <textarea class="form-control form-control-solid @error('deskripsi') is-invalid @enderror" 
                                id="deskripsi_ubah" 
                                name="deskripsi" 
                                rows="3" 
                                placeholder="Masukkan deskripsi proses assessment"
                                required></textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="text-center">
                            <button type="reset" class="btn btn-light me-3">Reset</button>
                            <button type="submit" class="btn btn-primary">
                                <span class="indicator-label">Simpan</span>
                                <span class="indicator-progress">Mohon menunggu...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_form_hapus" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content rounded">
                <div class="modal-header pb-0 border-0 justify-content-end">
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                </div>
                <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                    <form id="form_hapus" class="form">
                        <div class="mb-13 text-center">
                            <h1 class="mb-3">Hapus Proses Assessment</h1>
                            <div class="text-muted fw-semibold fs-5">
                                Apakah anda yakin untuk menghapus Proses Assessment <strong><span id="namadelete"></strong></span>?
                            </div>
                        </div>
                        <div class="text-center">
                            <div data-bs-dismiss="modal" class="btn btn-light me-3">Batal</div>
                            <button type="submit" class="btn btn-danger">
                                <span class="indicator-label">Ya, saya yakin</span>
                                <span class="indicator-progress">Mohon menunggu...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
@endsection

@section('script')
    <script>
        function edit(id_proses, nama, deskripsi) {
            $('#id_proses').val(id_proses);
            $('#nama_ubah').val(nama);
            $('#deskripsi_ubah').val(deskripsi);
            $('#modal_form_update').modal('show');
        }

        function hapus(id, nama) {
            $('#form_hapus').attr('action', {!! json_encode(url('proses-audit/hapus/')) !!} + '/' + id);
            $('#namadelete').text(nama);
            $('#modal_form_hapus').modal('show');
        }
    </script>

    @include('my_components.toastr')
    @include('my_components.datatables')
@endsection
