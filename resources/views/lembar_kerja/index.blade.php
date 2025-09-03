@extends('master')
@section('judul', 'Lembar Kerja')
@section('konten')
    <div class="toolbar mb-5 mb-lg-7" id="kt_toolbar">
        <div class="page-title d-flex flex-column me-3">
            <h1 class="d-flex text-dark fw-bold my-1 fs-3">Lembar Kerja</h1>
            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                <li class="breadcrumb-item text-gray-600">
                    <a href="{{ url('dashboard') }}" class="text-gray-600 text-hover-primary">
                        <i class="ki-duotone ki-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item text-gray-600">
                    <a href="{{ url('proyek') }}" class="text-gray-600 text-hover-primary">Proyek</a>
                </li>
                <li class="breadcrumb-item text-gray-500">Lembar Kerja</li>
            </ul>
        </div>
    </div>

    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3 mb-1">Lembar Kerja</span>
                <span class="text-muted mt-1 fw-semibold fs-7">Proyek: {{ $proyek->nama_proyek }}</span>
            </h3>
            <div class="card-toolbar">
                <button onclick="prosesAudit({{ $proyek->id_proyek }},'{{ $proyek->nama_proyek }}')"
                    class="btn btn-sm btn-light-primary me-2">
                    <i class="ki-duotone ki-update-file fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                        <span class="path4"></span>
                    </i>
                    Proses Assessment
                </button>
                <a href="{{ route('lembar-kerja.stream', $proyek->id_proyek) }}" class="btn btn-sm btn-light-primary me-2" target="_blank">
                    <i class="ki-duotone ki-document fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    Lihat Laporan
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
                            <th class="min-w-100px">Proses Assessment</th>
                            <th class="min-w-200px">Deskripsi</th>
                            <th class="min-w-100px">Level</th>
                            <th class="min-w-100px text-center rounded-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($proyek->prosesAudit as $proses)
                            <tr>
                                <td class="ps-4 text-dark fw-bold text-hover-primary mb-1 fs-6">
                                    {{ $i }}
                                </td>
                                <td class="text-dark fw-bold text-hover-primary mb-1 fs-6">
                                    {{ $proses->nama }}
                                </td>
                                <td class="text-dark fw-bold text-hover-primary mb-1 fs-6">
                                    {{ $proses->deskripsi }}
                                </td>
                                <td class="text-dark fw-bold text-hover-primary mb-1 fs-6">
                                    {{ $proses->pivot->level }}
                                </td>
                                <td class="text-center">
                                    @if ($proses->pivot->level != 1)
                                        <a href="{{ url('audit/' . $proyek->id_proyek . '/' . $proses->id_proses . '/' . $proses->pivot->level) }}"
                                            class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"
                                            title="Assessment Level {{ $proses->pivot->level }}">
                                            <i class="ki-duotone ki-document fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </a>
                                    @else
                                        <a href="{{ url('audit/' . $proyek->id_proyek . '/' . $proses->id_proses . '/' . $proses->pivot->level+1) }}"
                                            class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"
                                            title="Assessment Level {{ $proses->pivot->level }}">
                                            <i class="ki-duotone ki-document fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </a>
                                    @endif
                                    <button onclick="hapusProses({{ $proses->id_proses }},'{{ $proses->nama }}')"
                                        title="Hapus Proses"
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
    <!-- Modal Hapus Proses -->
    <div class="modal fade" id="modal_hapus_proses" tabindex="-1" aria-hidden="true">
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
                    <form id="form_hapus_proses" class="form" method="POST">
                        @csrf
                        <input type="hidden" id="id_proses_hapus" name="id_proses">
                        <div class="mb-13 text-center">
                            <h1 class="mb-3">Hapus Proses Assessment</h1>
                            <div class="text-muted fw-semibold fs-5">
                                Apakah anda yakin untuk menghapus proses assessment <strong><span id="nama_proses_hapus"></span></strong>?
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

    <!-- Modal Proses Assessment -->
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
                    <form id="form_proses_audit" action="{{ url('lembar-kerja/proses-audit') }}" method="POST" class="form">
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
        function hapusProses(id_proses, nama_proses) {
            $('#id_proses_hapus').val(id_proses);
            $('#nama_proses_hapus').text(nama_proses);
            $('#form_hapus_proses').attr('action', {!! json_encode(url('lembar-kerja/hapus-proses/')) !!} + '/' + {!! $proyek->id_proyek !!});
            $('#modal_hapus_proses').modal('show');
        }

        function prosesAudit(id_proyek, nama_proyek) {
            $('#id_proyek_proses').val(id_proyek);
            $('#nama_proyek_proses').text(nama_proyek);
            
            // Reset semua checkbox
            $('.proses_check').prop('checked', false);
            
            // Ambil data proses audit yang sudah dipilih
            $.get({!! json_encode(url('lembar-kerja/get-proses-audit/')) !!} + '/' + id_proyek, function(data) {
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

        // Ketika modal dibuka, cek apakah semua checkbox tercentang
        $('#modal_proses_audit').on('shown.bs.modal', function() {
            var allChecked = $('.proses_check:checked').length === $('.proses_check').length;
            $('#check_all').prop('checked', allChecked);
        });
    </script>

    @include('my_components.toastr')
    @include('my_components.datatables')
@endsection 