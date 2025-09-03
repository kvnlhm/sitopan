@extends('master')
@section('judul', 'Audit')
@section('konten')
    <div class="toolbar mb-5 mb-lg-7" id="kt_toolbar">
        <div class="page-title d-flex flex-column me-3">
            <h1 class="d-flex text-dark fw-bold my-1 fs-3">Audit</h1>
            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                <li class="breadcrumb-item text-gray-600">
                    <a href="{{ url('dashboard') }}" class="text-gray-600 text-hover-primary">
                        <i class="ki-duotone ki-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item text-gray-600">
                    <a href="{{ url('proyek') }}" class="text-gray-600 text-hover-primary">Proyek</a>
                </li>
                <li class="breadcrumb-item text-gray-600">
                    <a href="{{ url('lembar-kerja/' . $proyek->id_proyek) }}" class="text-gray-600 text-hover-primary">Lembar Kerja</a>
                </li>
                <li class="breadcrumb-item text-gray-500">Audit</li>
            </ul>
        </div>
    </div>

    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3 mb-1">Form Audit</span>
                <span class="text-muted mt-1 fw-semibold fs-7">
                    Proyek: {{ $proyek->nama_proyek }} | Proses: {{ $proses->nama }}
                </span>
            </h3>
        </div>
        <div class="card-body py-3">
            <form action="{{ url('audit/' . $proyek->id_proyek . '/' . $proses->id_proses) }}" method="POST" class="form">
                @csrf
                <div class="row mb-6">
                    <div class="col-lg-6">
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">Sub Proses</label>
                            <input type="text" name="sub_proses" 
                                class="form-control form-control-solid @error('sub_proses') is-invalid @enderror"
                                value="{{ old('sub_proses', $audit->sub_proses ?? '') }}"
                                placeholder="Masukkan sub proses" required />
                            @error('sub_proses')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">Level</label>
                            <input type="text" name="level" 
                                class="form-control form-control-solid @error('level') is-invalid @enderror"
                                value="{{ old('level', $audit->level ?? '') }}"
                                placeholder="Masukkan level" required />
                            @error('level')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-12">
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">Pertanyaan</label>
                            <textarea name="pertanyaan" rows="3" 
                                class="form-control form-control-solid @error('pertanyaan') is-invalid @enderror"
                                placeholder="Masukkan pertanyaan" required>{{ old('pertanyaan', $audit->pertanyaan ?? '') }}</textarea>
                            @error('pertanyaan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-12">
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">Document Evidence</label>
                            <textarea name="document_evidence" rows="3" 
                                class="form-control form-control-solid @error('document_evidence') is-invalid @enderror"
                                placeholder="Masukkan document evidence" required>{{ old('document_evidence', $audit->document_evidence ?? '') }}</textarea>
                            @error('document_evidence')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-6">
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">Score</label>
                            <input type="number" name="score" min="0" max="100" 
                                class="form-control form-control-solid @error('score') is-invalid @enderror"
                                value="{{ old('score', $audit->score ?? '') }}"
                                placeholder="Masukkan score (0-100)" required />
                            @error('score')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="fs-6 fw-semibold mb-2">Exist</label>
                            <div class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" name="exist" value="1" 
                                    {{ old('exist', $audit->exist ?? false) ? 'checked' : '' }} />
                                <label class="form-check-label">Ya</label>
                            </div>
                            @error('exist')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <a href="{{ url('lembar-kerja/' . $proyek->id_proyek) }}" class="btn btn-light me-3">Kembali</a>
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
@endsection

@section('css')
@endsection

@section('script')
    @include('my_components.toastr')
@endsection 