<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Lembar Kerja - {{ $proyek->nama_proyek }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 18px;
            margin-bottom: 5px;
        }
        .header p {
            font-size: 14px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 11px;
        }
        th {
            background-color: #f5f5f5;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 10px;
            color: #666;
        }
        .process-header {
            background-color: #e9ecef;
            padding: 10px;
            margin: 20px 0 10px;
            font-weight: bold;
        }
        .level-header {
            background-color: #f8f9fa;
            padding: 8px;
            margin: 10px 0;
        }
        .praktik-header {
            background-color: #f5f5f5;
            padding: 6px;
            margin: 5px 0;
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
        .badge {
            padding: 3px 6px;
            border-radius: 3px;
            font-size: 10px;
            color: white;
        }
        .badge-success { background-color: #28a745; }
        .badge-warning { background-color: #ffc107; color: black; }
        .badge-danger { background-color: #dc3545; }
        .badge-info { background-color: #17a2b8; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Lembar Kerja</h1>
        <p>Proyek: {{ $proyek->nama_proyek }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Proses Assessment</th>
                <th>Deskripsi</th>
                <th>Level Terakhir</th>
            </tr>
        </thead>
        <tbody>
            @php $i = 1; @endphp
            @foreach ($proyek->prosesAudit as $proses)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $proses->nama }}</td>
                    <td>{{ $proses->deskripsi }}</td>
                    <td>{{ $proses->pivot->level }}</td>
                </tr>
                @php $i++; @endphp
            @endforeach
        </tbody>
    </table>

    @foreach ($proyek->prosesAudit as $proses)
        <div class="process-header">
            {{ $proses->nama }} - {{ $proses->deskripsi }}
        </div>

        @for ($level = 1; $level <= $proses->pivot->level; $level++)
            <div class="level-header">Level {{ $level }}</div>
            
            @php $details = $auditDetails[$proses->id_proses][$level]; @endphp
            
            @if($level > 1)
                @if($details['type'] == 'praktik')
                    @foreach($details['groups'] as $praktik => $pertanyaanGroup)
                        @php
                            $praktikTotal = count($pertanyaanGroup);
                            $praktikChecked = 0;
                            foreach($pertanyaanGroup as $q) {
                                if(isset($details['audits'][$q->id_pertanyaan]) && $details['audits'][$q->id_pertanyaan]->exist) 
                                    $praktikChecked++;
                            }
                            $praktikScore = $praktikTotal > 0 ? round($praktikChecked / $praktikTotal * 100) : 0;
                            $praktikKategori = 'N';
                            if($praktikScore > 85) $praktikKategori = 'F';
                            else if($praktikScore > 50) $praktikKategori = 'L';
                            else if($praktikScore > 15) $praktikKategori = 'P';
                        @endphp

                        <div class="praktik-header">{{ $praktik }}</div>
                        <table>
                            <thead>
                                <tr>
                                    <th style="width: 50%;">Pertanyaan</th>
                                    <th class="text-center" style="width: 10%;">Ada</th>
                                    <th>Bukti Hasil Kerja</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pertanyaanGroup as $q)
                                    <tr>
                                        <td>{{ $q->pertanyaan }}</td>
                                        <td class="text-center">
                                            @if(isset($details['audits'][$q->id_pertanyaan]) && $details['audits'][$q->id_pertanyaan]->exist)
                                                V
                                            @else
                                                
                                            @endif
                                        </td>
                                        <td>{{ isset($details['audits'][$q->id_pertanyaan]) ? $details['audits'][$q->id_pertanyaan]->document_evidence : '' }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="3">
                                        <strong>Skor: </strong>{{ $praktikScore }}% 
                                        <strong>Kategori: </strong>{{ $praktikKategori }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    @endforeach
                @else
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 5%;">No.</th>
                                <th style="width: 45%;">Pertanyaan</th>
                                <th class="text-center" style="width: 10%;">Ada</th>
                                <th>Bukti Hasil Kerja</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($details['pertanyaan'] as $index => $q)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $q->pertanyaan }}</td>
                                    <td class="text-center">
                                        @if(isset($details['audits'][$q->id_pertanyaan]) && $details['audits'][$q->id_pertanyaan]->exist)
                                            V
                                        @else
                                            
                                        @endif
                                    </td>
                                    <td>{{ isset($details['audits'][$q->id_pertanyaan]) ? $details['audits'][$q->id_pertanyaan]->document_evidence : '' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            @endif
        @endfor
    @endforeach

    <div class="footer">
        <p>Dicetak pada: {{ date('d/m/Y H:i:s') }}</p>
    </div>

    {{-- KESIMPULAN PERHITUNGAN AKHIR --}}
    <div class="header">
        <h2>Kesimpulan Perhitungan Akhir</h2>
    </div>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Proses TI</th>
                <th>Detail Proses TI</th>
                <th>Level</th>
                <th>Skor Akhir (%)</th>
                <th>Kategori Akhir</th>
            </tr>
        </thead>
        <tbody>
            @php $i = 1; @endphp
            @foreach ($proyek->prosesAudit as $proses)
                @php
                    $totalScore = 0;
                    $totalCount = 0;
                    for ($level = 1; $level <= $proses->pivot->level; $level++) {
                        $details = $auditDetails[$proses->id_proses][$level];
                        if ($level > 1 && $details['type'] == 'praktik') {
                            foreach ($details['groups'] as $praktik => $pertanyaanGroup) {
                                $praktikTotal = count($pertanyaanGroup);
                                $praktikChecked = 0;
                                foreach ($pertanyaanGroup as $q) {
                                    if (isset($details['audits'][$q->id_pertanyaan]) && $details['audits'][$q->id_pertanyaan]->exist)
                                        $praktikChecked++;
                                }
                                $praktikScore = $praktikTotal > 0 ? round($praktikChecked / $praktikTotal * 100) : 0;
                                $totalScore += $praktikScore;
                                $totalCount++;
                            }
                        } else {
                            $pertanyaan = $details['pertanyaan'] ?? collect();
                            $pertanyaanTotal = count($pertanyaan);
                            $pertanyaanChecked = 0;
                            foreach ($pertanyaan as $q) {
                                if (isset($details['audits'][$q->id_pertanyaan]) && $details['audits'][$q->id_pertanyaan]->exist)
                                    $pertanyaanChecked++;
                            }
                            $pertanyaanScore = $pertanyaanTotal > 0 ? round($pertanyaanChecked / $pertanyaanTotal * 100) : 0;
                            $totalScore += $pertanyaanScore;
                            $totalCount++;
                        }
                    }
                    $finalScore = $totalCount > 0 ? round($totalScore / $totalCount) : 0;
                    $finalKategori = 'N';
                    if ($finalScore > 85) $finalKategori = 'F';
                    else if ($finalScore > 50) $finalKategori = 'L';
                    else if ($finalScore > 15) $finalKategori = 'P';
                @endphp
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $proses->nama }}</td>
                    <td>{{ $proses->deskripsi }}</td>
                    <td>{{ $proses->pivot->level }}</td>
                    <td>{{ $finalScore }}%</td>
                    <td>{{ $finalKategori }}</td>
                </tr>
                @php $i++; @endphp
            @endforeach
        </tbody>
    </table>
    @php
        $totalLevel = 0;
        $countLevel = 0;
        foreach ($proyek->prosesAudit as $proses) {
            $totalLevel += $proses->pivot->level;
            $countLevel++;
        }
        $avgLevel = $countLevel > 0 ? $totalLevel / $countLevel : 0;
        $roundedLevel = $countLevel > 0 ? round($avgLevel) : 0;
    @endphp
    <div style="margin-top: 10px;">
        <table style="width: 40%; font-size: 13px; margin-left: 0;">
            <tr>
                <td><b>Maturity level</b></td>
                <td>:</td>
                <td>{{ number_format($avgLevel, 2) }}</td>
            </tr>
            <tr>
                <td><b>(Pembulatan)</b></td>
                <td>:</td>
                <td>{{ $roundedLevel }}</td>
            </tr>
        </table>
    </div>
</body>
</html> 