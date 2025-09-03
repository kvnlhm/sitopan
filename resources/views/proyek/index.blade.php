@extends('master')
@section('judul', 'Proyek')
@section('konten')
    <div class="toolbar mb-5 mb-lg-7" id="kt_toolbar">
        <div class="page-title d-flex flex-column me-3">
            <h1 class="d-flex text-dark fw-bold my-1 fs-3">Proyek</h1>
            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                <li class="breadcrumb-item text-gray-600">
                    <a href="{{ url('dashboard') }}" class="text-gray-600 text-hover-primary">
                        <i class="ki-duotone ki-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item text-gray-500">Proyek</li>
            </ul>
        </div>
    </div>
    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3 mb-1">Tabel</span>
                <span class="text-muted mt-1 fw-semibold fs-7">Daftar Proyek</span>
            </h3>
            <div class="card-toolbar">
                <a href="#" data-bs-toggle="modal" data-bs-target="#modal_form_tambah"
                    class="btn btn-sm btn-light-primary">
                    <i class="ki-duotone ki-plus fs-2"></i>Tambah Proyek
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
                            <th class="min-w-100px">Nama Proyek</th>
                            <th class="min-w-100px">User</th>
                            <th class="min-w-200px">Proses Assessment</th>
                            <th class="min-w-100px text-center rounded-end">Aksi</th>
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
                                    {{ $dt->nama_proyek }}
                                </td>
                                <td class="text-dark fw-bold text-hover-primary mb-1 fs-6">
                                    {{ $dt->user->name }}
                                </td>
                                <td class="text-dark fw-bold text-hover-primary mb-1 fs-6">
                                    @foreach($dt->prosesAudit as $proses)
                                        <span class="badge badge-light-primary me-1">{{ $proses->nama }}</span>
                                    @endforeach
                                </td>
                                <td class="text-center">
                                    <button onclick="prosesAudit({{ $dt->id_proyek }},'{{ $dt->nama_proyek }}')"
                                        title="Proses Assessment"
                                        class="btn btn-icon btn-bg-light btn-active-color-success btn-sm me-1">
                                        <i class="ki-duotone ki-update-file fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                        </i>
                                    </button>
                                    <a href="{{ route('lembar-kerja.stream', $dt->id_proyek) }}"
                                        title="Lihat Laporan"
                                        class="btn btn-icon btn-bg-light btn-active-color-info btn-sm me-1"
                                        target="_blank">
                                        <i class="ki-duotone ki-document fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </a>
                                    {{-- <a href="{{ route('lembar-kerja.pdf', $dt->id_proyek) }}"
                                        title="Download Laporan"
                                        class="btn btn-icon btn-bg-light btn-active-color-info btn-sm">
                                        <i class="ki-duotone ki-file-down fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </a> --}}
                                    <button
                                        onclick="edit({{ $dt->id_proyek }},'{{ $dt->nama_proyek }}',{{ $dt->id_user }})"
                                        title="Edit Proyek"
                                        class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                        <i class="ki-duotone ki-pencil fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </button>
                                    <button onclick="hapus({{ $dt->id_proyek }},'{{ $dt->nama_proyek }}')"
                                        title="Hapus Proyek"
                                        class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm me-1">
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
                    <form action="{{ url('proyek') }}" method="POST" class="form">
                        @csrf
                        <div class="mb-13 text-center">
                            <h1 class="mb-3">Form Tambah Proyek</h1>
                            <div class="text-muted fw-semibold fs-5">Silahkan isikan data dengan sesuai.</div>
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label for="nama_proyek" class="required fs-6 fw-semibold mb-2">Nama Proyek</label>
                            <input type="text" id="nama_proyek" name="nama_proyek"
                                class="form-control form-control-solid @error('nama_proyek') is-invalid @enderror"
                                placeholder="Masukkan nama proyek"
                                required />
                            @error('nama_proyek')
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
                    <form id="updateform" action="{{ url('proyek/update') }}" method="POST" class="form">
                        @csrf
                        <input type="hidden" id="id_proyek" name="id">
                        <div class="mb-13 text-center">
                            <h1 class="mb-3">Form Update Proyek</h1>
                            <div class="text-muted fw-semibold fs-5">Silahkan isikan data dengan sesuai.</div>
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label for="nama_proyek_ubah" class="required fs-6 fw-semibold mb-2">Nama Proyek</label>
                            <input type="text" id="nama_proyek_ubah" name="nama_proyek"
                                class="form-control form-control-solid @error('nama_proyek') is-invalid @enderror"
                                placeholder="Masukkan nama proyek"
                                required />
                            @error('nama_proyek')
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
                            <h1 class="mb-3">Hapus Proyek</h1>
                            <div class="text-muted fw-semibold fs-5">
                                Apakah anda yakin untuk menghapus Proyek <strong><span id="namadelete"></span></strong>?
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

    <div class="modal fade" id="modal_proses_audit" tabindex="-1" aria-hidden="true">
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
                    <form id="form_proses_audit" action="{{ url('proyek/proses-audit') }}" method="POST" class="form">
                        @csrf
                        <input type="hidden" id="id_proyek_proses" name="id_proyek">
                        <div class="mb-13 text-center">
                            <h1 class="mb-3">Pilih Proses Assessment</h1>
                            <div class="text-muted fw-semibold fs-5">
                                Pilih proses assessment untuk proyek <strong><span id="nama_proyek_proses"></span></strong>
                            </div>
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">Proses Assessment</label>
                            <div class="table-responsive">
                                <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                                    <thead>
                                        <tr class="fw-bold text-muted">
                                            <th class="w-25px">
                                                <div class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" id="check_all" />
                                                </div>
                                            </th>
                                            <th class="min-w-150px">Nama Proses</th>
                                            <th class="min-w-140px">Deskripsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($proses_audit as $proses)
                                        <tr>
                                            <td>
                                                <div class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input proses_check" type="checkbox" 
                                                        name="id_proses[]" value="{{ $proses->id_proses }}" />
                                                </div>
                                            </td>
                                            <td>{{ $proses->nama }}</td>
                                            <td>{{ $proses->deskripsi }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @error('id_proses')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="text-center">
                            <div data-bs-dismiss="modal" class="btn btn-light me-3">Batal</div>
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
@endsection

@section('css')
@endsection

@section('script')
    <script>
        function edit(id_proyek, nama_proyek, id_user) {
            $('#id_proyek').val(id_proyek);
            $('#nama_proyek_ubah').val(nama_proyek);
            $('#id_user_ubah').val(id_user);
            $('#modal_form_update').modal('show');
        }

        function hapus(id, nama_proyek) {
            $('#form_hapus').attr('action', {!! json_encode(url('proyek/hapus/')) !!} + '/' + id);
            $('#namadelete').text(nama_proyek);
            $('#modal_form_hapus').modal('show');
        }

        function prosesAudit(id_proyek, nama_proyek) {
            $('#id_proyek_proses').val(id_proyek);
            $('#nama_proyek_proses').text(nama_proyek);
            
            // Reset semua checkbox
            $('.proses_check').prop('checked', false);
            
            // Ambil data proses assessment yang sudah dipilih
            $.get({!! json_encode(url('proyek/get-proses-audit/')) !!} + '/' + id_proyek, function(data) {
                data.forEach(function(proses) {
                    $('input[name="id_proses[]"][value="' + proses.id_proses + '"]').prop('checked', true);
                });
            });
            
            $('#modal_proses_audit').modal('show');
        }

        // Checkbox handler
        $('#check_all').change(function() {
            $('.proses_check').prop('checked', $(this).prop('checked'));
        });
    </script>

    @include('my_components.toastr')
    @include('my_components.datatables')
@endsection 