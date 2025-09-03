@extends('master')
@section('judul', 'Assessment')
@section('konten')
    <div class="toolbar mb-5 mb-lg-7" id="kt_toolbar">
        <div class="page-title d-flex flex-column me-3">
            <h1 class="d-flex text-dark fw-bold my-1 fs-3">Assessment</h1>
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
                <li class="breadcrumb-item text-gray-500">Assessment</li>
            </ul>
        </div>
    </div>

    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3 mb-1">{{ $proyek->nama_proyek }}</span>
            </h3>
        </div>
        <div class="card-body py-3">
            <div class="mb-4">
                <span class="fw-semibold">Proses</span> :
                <span class="badge badge-danger ms-2">{{ $proses->nama }} - {{ $proses->deskripsi }}</span>
            </div>
            <div class="mb-4">
                <span class="fw-semibold">Level</span> :
                <span class="badge badge-danger ms-2">{{ $level }}</span>
            </div>
            <form action="{{ url('audit/' . $proyek->id_proyek . '/' . $proses->id_proses . '/' . $level) }}" method="POST" class="form">
                @csrf
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover align-middle">
                        <thead>
                            <tr class="fw-bold text-muted bg-light">
                                @if($level > 1)
                                    <th class="ps-4 min-w-200px rounded-start align-middle">Praktik Manajemen</th>
                                @else
                                    <th class="ps-4 min-w-40px rounded-start align-middle">No.</th>
                                @endif
                                <th class="min-w-350px align-middle">Pertanyaan</th>
                                <th class="min-w-80px text-center align-middle">Ada</th>
                                <th class="min-w-200px align-middle">Bukti Hasil Kerja</th>
                                <th class="min-w-80px align-middle">Skor</th>
                                <th class="min-w-80px rounded-end align-middle">Level</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($level > 1)
                                @php
                                    $praktikGroups = $pertanyaan->groupBy('praktik');
                                    $rowIndex = 0;
                                    $praktikIdx = 0;
                                @endphp
                                @foreach($praktikGroups as $praktik => $pertanyaanGroup)
                                    @php
                                        $praktikTotal = count($pertanyaanGroup);
                                        $praktikChecked = 0;
                                        foreach($pertanyaanGroup as $q) {
                                            if(isset($audits[$q->id_pertanyaan]) && $audits[$q->id_pertanyaan]->exist) $praktikChecked++;
                                        }
                                        $praktikScore = $praktikTotal > 0 ? round($praktikChecked / $praktikTotal * 100) : 0;
                                        $praktikKategori = 'N';
                                        if($praktikScore > 85) $praktikKategori = 'F';
                                        else if($praktikScore > 50) $praktikKategori = 'L';
                                        else if($praktikScore > 15) $praktikKategori = 'P';
                                    @endphp
                                    @foreach($pertanyaanGroup as $j => $q)
                                        <tr>
                                            @if($j == 0)
                                                <td class="ps-4 text-dark fw-bold text-hover-primary mb-1 fs-6 align-middle bg-light border-end border-2" rowspan="{{ count($pertanyaanGroup) }}" style="vertical-align: middle; padding-top:0; padding-bottom:0; min-width:200px;">{{ $praktik }}</td>
                                            @endif
                                            <td class="text-dark fw-bold text-hover-primary mb-1 fs-6 align-middle">
                                                <textarea class="form-control form-control-solid w-100 m-0 p-1" style="resize:vertical; min-height:38px;" readonly>{{ $q->pertanyaan }}</textarea>
                                            </td>
                                            <td class="text-center align-middle">
                                                <input type="checkbox" class="form-check-input exist-check" name="exist[{{ $q->id_pertanyaan }}]" data-index="{{ $rowIndex }}" data-praktik-idx="{{ $praktikIdx }}" {{ isset($audits[$q->id_pertanyaan]) && $audits[$q->id_pertanyaan]->exist ? 'checked' : '' }} />
                                            </td>
                                            <td class="text-dark fw-bold text-hover-primary mb-1 fs-6 align-middle">
                                                <textarea class="form-control form-control-solid w-100 m-0 p-1" style="resize:vertical; min-height:38px;" name="document_evidence[{{ $q->id_pertanyaan }}]">{{ isset($audits[$q->id_pertanyaan]) ? $audits[$q->id_pertanyaan]->document_evidence : '' }}</textarea>
                                            </td>
                                            @if($j == 0)
                                                <td class="text-dark fw-bold text-hover-primary mb-1 fs-6 align-middle bg-light border-end border-2" rowspan="{{ count($pertanyaanGroup) }}">
                                                    <input type="text" id="praktik-score-{{ $praktikIdx }}" class="form-control form-control-solid praktik-score w-100 m-0 p-1 text-center" value="{{ $praktikScore }}" readonly />
                                                </td>
                                                <td class="text-dark fw-bold text-hover-primary mb-1 fs-6 align-middle bg-light border-end border-2" rowspan="{{ count($pertanyaanGroup) }}">
                                                    <input type="text" id="praktik-kategori-{{ $praktikIdx }}" class="form-control form-control-solid praktik-kategori w-100 m-0 p-1 text-center" value="{{ $praktikKategori }}" readonly />
                                                </td>
                                            @endif
                                        </tr>
                                        @php $rowIndex++; @endphp
                                    @endforeach
                                    @php $praktikIdx++; @endphp
                                @endforeach
                            @else
                                @foreach($pertanyaan as $i => $q)
                                <tr>
                                    <td class="ps-4 text-dark fw-bold text-hover-primary mb-1 fs-6 align-middle">{{ $i+1 }}</td>
                                    <td class="text-dark fw-bold text-hover-primary mb-1 fs-6 align-middle">
                                        <textarea class="form-control form-control-solid w-100 m-0 p-1" style="resize:vertical; min-height:38px;" readonly>{{ $q->pertanyaan }}</textarea>
                                    </td>
                                    <td class="text-center align-middle">
                                        <input type="checkbox" class="form-check-input exist-check" name="exist[{{ $q->id_pertanyaan }}]" data-index="{{ $i }}" {{ isset($audits[$q->id_pertanyaan]) && $audits[$q->id_pertanyaan]->exist ? 'checked' : '' }} />
                                    </td>
                                    <td class="text-dark fw-bold text-hover-primary mb-1 fs-6 align-middle">
                                        <textarea class="form-control form-control-solid w-100 m-0 p-1" style="resize:vertical; min-height:38px;" name="document_evidence[{{ $q->id_pertanyaan }}]">{{ isset($audits[$q->id_pertanyaan]) ? $audits[$q->id_pertanyaan]->document_evidence : '' }}</textarea>
                                    </td>
                                    <td class="text-dark fw-bold text-hover-primary mb-1 fs-6 align-middle">
                                        <input type="text" class="form-control form-control-solid score-item w-100 m-0 p-1" name="score[{{ $q->id_pertanyaan }}]" value="{{ isset($audits[$q->id_pertanyaan]) ? $audits[$q->id_pertanyaan]->score : '0' }}" readonly data-index="{{ $i }}" />
                                    </td>
                                    <td class="text-dark fw-bold text-hover-primary mb-1 fs-6 align-middle">
                                        <input type="text" class="form-control form-control-solid kategori-item w-100 m-0 p-1" value="N" readonly data-index="{{ $i }}" />
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end fw-bold">Total</td>
                                <td colspan="2">
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <label class="fw-semibold">Skor (%)</label>
                                            <input type="text" class="form-control form-control-solid" id="total_score_display" value="0" readonly />
                                            <input type="hidden" name="total_score" id="total_score" value="0" />
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label class="fw-semibold">K. Level</label>
                                            <input type="text" class="form-control form-control-solid" id="kategori_level" name="kategori_level" value="N" readonly />
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ url('lembar-kerja/' . $proyek->id_proyek) }}" class="btn btn-secondary me-2">Kembali ke Lembar Kerja</a>
                    @if($level > 1)
                        <a href="{{ url('audit/' . $proyek->id_proyek . '/' . $proses->id_proses . '/' . $level-1) }}" class="btn btn-danger me-2">Kembali</a>
                    @endif
                    <button type="submit" class="btn btn-primary">Simpan dan Lanjutkan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('css')
@endsection

@section('script')
    @include('my_components.toastr')
    <script>
        function updateScoreAndLevel() {
            const checkboxes = document.querySelectorAll('.exist-check');
            let totalScore = 0;
            let total = checkboxes.length;

            // Hanya update per pertanyaan jika level == 1
            @if($level == 1)
            const scoreInputs = document.querySelectorAll('.score-item');
            const kategoriInputs = document.querySelectorAll('.kategori-item');
            checkboxes.forEach((cb, i) => {
                let score = cb.checked ? 100 : 0;
                scoreInputs[i].value = score;
                kategoriInputs[i].value = score === 100 ? 'F' : 'N';
                totalScore += score;
            });
            let avgScore = total > 0 ? totalScore / total : 0;
            avgScore = Math.round(avgScore);
            document.getElementById('total_score_display').value = avgScore;
            document.getElementById('total_score').value = avgScore;
            let kategori = 'N';
            if(avgScore > 85) kategori = 'F';
            else if(avgScore > 50) kategori = 'L';
            else if(avgScore > 15) kategori = 'P';
            document.getElementById('kategori_level').value = kategori;
            @endif

            // Update score & kategori per Praktik Manajemen (khusus level > 1)
            @if($level > 1)
            let praktikMap = {};
            document.querySelectorAll('.exist-check').forEach(cb => {
                let praktikIdx = cb.getAttribute('data-praktik-idx');
                if (praktikIdx !== null) {
                    if (!praktikMap[praktikIdx]) praktikMap[praktikIdx] = { total: 0, checked: 0 };
                    praktikMap[praktikIdx].total++;
                    if (cb.checked) praktikMap[praktikIdx].checked++;
                }
            });

            let totalPraktikScore = 0;
            let praktikCount = Object.keys(praktikMap).length;

            Object.keys(praktikMap).forEach(praktikIdx => {
                let obj = praktikMap[praktikIdx];
                let score = obj.total > 0 ? Math.round(obj.checked / obj.total * 100) : 0;
                let kategori = 'N';
                if(score > 85) kategori = 'F';
                else if(score > 50) kategori = 'L';
                else if(score > 15) kategori = 'P';
                let scoreInput = document.getElementById('praktik-score-' + praktikIdx);
                let kategoriInput = document.getElementById('praktik-kategori-' + praktikIdx);
                if(scoreInput) scoreInput.value = score;
                if(kategoriInput) kategoriInput.value = kategori;
                totalPraktikScore += score;
            });

            // Calculate and update total score and kategori level
            let avgTotalScore = praktikCount > 0 ? Math.round(totalPraktikScore / praktikCount) : 0;
            document.getElementById('total_score_display').value = avgTotalScore;
            document.getElementById('total_score').value = avgTotalScore;
            let totalKategori = 'N';
            if(avgTotalScore > 85) totalKategori = 'F';
            else if(avgTotalScore > 50) totalKategori = 'L';
            else if(avgTotalScore > 15) totalKategori = 'P';
            document.getElementById('kategori_level').value = totalKategori;
            @endif
        }
        document.querySelectorAll('.exist-check').forEach(cb => {
            cb.addEventListener('change', updateScoreAndLevel);
        });
        // Inisialisasi saat load
        updateScoreAndLevel();
    </script>
@endsection 