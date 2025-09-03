@extends('master')
@section('judul', 'Pertanyaan')
@section('konten')
    <div class="toolbar mb-5 mb-lg-7" id="kt_toolbar">
        <div class="page-title d-flex flex-column me-3">
            <h1 class="d-flex text-dark fw-bold my-1 fs-3">Pertanyaan</h1>
            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                <li class="breadcrumb-item text-gray-600">
                    <a href="{{ url('dashboard') }}" class="text-gray-600 text-hover-primary">
                        <i class="ki-duotone ki-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item text-gray-500">Pertanyaan</li>
            </ul>
        </div>
    </div>
    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3 mb-1">Tabel</span>
                <span class="text-muted mt-1 fw-semibold fs-7">Daftar Pertanyaan</span>
            </h3>
            <div class="card-toolbar">
                <a href="#" data-bs-toggle="modal" data-bs-target="#modal_form_tambah"
                    class="btn btn-sm btn-light-primary">
                    <i class="ki-duotone ki-plus fs-2"></i>Tambah Pertanyaan
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
                            <th class="min-w-100px">Kode Proses</th>
                            <th class="min-w-100px">Level</th>
                            {{-- <th class="min-w-100px">PA</th> --}}
                            <th class="min-w-100px">Praktik Manajemen</th>
                            <th class="min-w-200px">Pertanyaan</th>
                            {{-- <th class="min-w-200px">Deskripsi</th> --}}
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
                                    {{ $dt->prosesAudit->nama ?? '-' }}
                                </td>
                                <td class="text-dark fw-bold text-hover-primary mb-1 fs-6">
                                    {{ $dt->level }}
                                </td>
                                {{-- <td class="text-dark fw-bold text-hover-primary mb-1 fs-6">
                                    {{ $dt->pa }}
                                </td> --}}
                                <td class="text-dark fw-bold text-hover-primary mb-1 fs-6">
                                    {{ $dt->praktik }}
                                </td>
                                <td class="text-dark fw-bold text-hover-primary mb-1 fs-6">
                                    {{ $dt->pertanyaan }}
                                </td>
                                {{-- <td class="text-dark fw-bold text-hover-primary mb-1 fs-6">
                                    {{ $dt->deskripsi }}
                                </td> --}}
                                <td class="text-center">
                                    <button
                                        onclick="edit({{ $dt->id_pertanyaan }},'{{ $dt->kode_proses }}','{{ $dt->level }}','{{ $dt->praktik }}','{{ $dt->pertanyaan }}','{{ $dt->deskripsi }}')"
                                        title="Edit Pertanyaan"
                                        class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                        <i class="ki-duotone ki-pencil fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </button>
                                    <button onclick="hapus({{ $dt->id_pertanyaan }},'{{ $dt->pertanyaan }}')"
                                        title="Hapus Pertanyaan"
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
                    <form action="{{ url('pertanyaan') }}" method="POST" class="form">
                        @csrf
                        <div class="mb-13 text-center">
                            <h1 class="mb-3">Form Tambah Pertanyaan</h1>
                            <div class="text-muted fw-semibold fs-5">Silahkan isikan data dengan sesuai.</div>
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label for="kode_proses" class="required fs-6 fw-semibold mb-2">Kode Proses</label>
                            <select class="form-select form-select-solid @error('kode_proses') is-invalid @enderror" 
                                name="kode_proses" id="kode_proses" required>
                                <option value="">Pilih Kode Proses</option>
                                @foreach ($prosesAudit as $pa)
                                    <option value="{{ $pa->nama }}">{{ $pa->nama }}</option>
                                @endforeach
                            </select>
                            @error('kode_proses')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label for="level" class="required fs-6 fw-semibold mb-2">Level</label>
                            <input type="text" id="level" name="level"
                                class="form-control form-control-solid @error('level') is-invalid @enderror"
                                placeholder="Masukkan level"
                                required />
                            @error('level')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- <div class="d-flex flex-column mb-8 fv-row">
                            <label for="pa" class="required fs-6 fw-semibold mb-2">PA</label>
                            <input type="text" id="pa" name="pa"
                                class="form-control form-control-solid @error('pa') is-invalid @enderror"
                                placeholder="Masukkan PA"
                                required />
                            @error('pa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div> --}}
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label for="praktik" class="required fs-6 fw-semibold mb-2">Praktik</label>
                            <input type="text" id="praktik" name="praktik"
                                class="form-control form-control-solid @error('praktik') is-invalid @enderror"
                                placeholder="Masukkan praktik manajemen"
                                required />
                            @error('praktik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label for="pertanyaan" class="required fs-6 fw-semibold mb-2">Pertanyaan</label>
                            <textarea class="form-control form-control-solid @error('pertanyaan') is-invalid @enderror" 
                                name="pertanyaan" id="pertanyaan" 
                                rows="3" 
                                placeholder="Masukkan pertanyaan"
                                required></textarea>
                            @error('pertanyaan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- <div class="d-flex flex-column mb-8 fv-row">
                            <label for="deskripsi" class="required fs-6 fw-semibold mb-2">Deskripsi</label>
                            <textarea class="form-control form-control-solid @error('deskripsi') is-invalid @enderror" 
                                name="deskripsi" id="deskripsi" 
                                rows="3" 
                                placeholder="Masukkan deskripsi"
                                required></textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div> --}}
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
                    <form id="updateform" action="{{ url('pertanyaan/update') }}" method="POST" class="form">
                        @csrf
                        <input type="hidden" id="id_pertanyaan" name="id">
                        <div class="mb-13 text-center">
                            <h1 class="mb-3">Form Update Pertanyaan</h1>
                            <div class="text-muted fw-semibold fs-5">Silahkan isikan data dengan sesuai.</div>
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label for="kode_proses_ubah" class="required fs-6 fw-semibold mb-2">Kode Proses</label>
                            <select class="form-select form-select-solid @error('kode_proses') is-invalid @enderror" 
                                name="kode_proses" id="kode_proses_ubah" required>
                                <option value="">Pilih Kode Proses</option>
                                @foreach ($prosesAudit as $pa)
                                    <option value="{{ $pa->nama }}">{{ $pa->nama }}</option>
                                @endforeach
                            </select>
                            @error('kode_proses')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label for="level_ubah" class="required fs-6 fw-semibold mb-2">Level</label>
                            <input type="text" id="level_ubah" name="level"
                                class="form-control form-control-solid @error('level') is-invalid @enderror"
                                placeholder="Masukkan level"
                                required />
                            @error('level')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- <div class="d-flex flex-column mb-8 fv-row">
                            <label for="pa_ubah" class="required fs-6 fw-semibold mb-2">PA</label>
                            <input type="text" id="pa_ubah" name="pa"
                                class="form-control form-control-solid @error('pa') is-invalid @enderror"
                                placeholder="Masukkan PA"
                                required />
                            @error('pa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div> --}}
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label for="praktik_ubah" class="required fs-6 fw-semibold mb-2">Praktik</label>
                            <input type="text" id="praktik_ubah" name="praktik"
                                class="form-control form-control-solid @error('praktik') is-invalid @enderror"
                                placeholder="Masukkan praktik manajemen"
                                required />
                            @error('praktik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label for="pertanyaan_ubah" class="required fs-6 fw-semibold mb-2">Pertanyaan</label>
                            <textarea class="form-control form-control-solid @error('pertanyaan') is-invalid @enderror" 
                                id="pertanyaan_ubah" 
                                name="pertanyaan" 
                                rows="3" 
                                placeholder="Masukkan pertanyaan"
                                required></textarea>
                            @error('pertanyaan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- <div class="d-flex flex-column mb-8 fv-row">
                            <label for="deskripsi_ubah" class="required fs-6 fw-semibold mb-2">Deskripsi</label>
                            <textarea class="form-control form-control-solid @error('deskripsi') is-invalid @enderror" 
                                id="deskripsi_ubah" 
                                name="deskripsi" 
                                rows="3" 
                                placeholder="Masukkan deskripsi"
                                required></textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div> --}}
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
                            <h1 class="mb-3">Hapus Pertanyaan</h1>
                            <div class="text-muted fw-semibold fs-5">
                                Apakah anda yakin untuk menghapus Pertanyaan <strong><span id="pertanyaandelete"></strong></span>?
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
        function edit(id, kode_proses, level, praktik, pertanyaan) {
            $('#id_pertanyaan').val(id);
            $('#kode_proses_ubah').val(kode_proses);
            $('#level_ubah').val(level);
            $('#praktik_ubah').val(praktik);
            $('#pertanyaan_ubah').val(pertanyaan);
            $('#modal_form_update').modal('show');
        }

        function hapus(id, pertanyaan) {
            $('#form_hapus').attr('action', {!! json_encode(url('pertanyaan/hapus/')) !!} + '/' + id);
            $('#pertanyaandelete').text(pertanyaan);
            $('#modal_form_hapus').modal('show');
        }
    </script>

    @include('my_components.toastr')
    @include('my_components.datatables')
@endsection 