<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use App\Models\ProsesAudit;
use App\Models\Audit;
use App\Models\Log;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuditController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id_proyek, $id_proses, $level)
    {
        if (Auth::user()->id_priv == 1 || Auth::user()->id_priv == 2) {
            $proyek = Proyek::findOrFail($id_proyek);
            $proses = ProsesAudit::findOrFail($id_proses);
            $pertanyaan = Pertanyaan::where('kode_proses', $proses->nama)
                                    ->where('level', $level)
                                    ->get();
            // Ambil semua data audit untuk pertanyaan yang ada
            $audits = Audit::where('id_proyek', $id_proyek)
                          ->where('id_proses', $id_proses)
                          ->whereIn('id_pertanyaan', $pertanyaan->pluck('id_pertanyaan'))
                          ->get()
                          ->keyBy('id_pertanyaan');
            
            $log = new Log;
            $log->id_user = Auth::user()->id;
            $log->aktivitas = 'Mengakses halaman assessment untuk proyek ' . $proyek->nama_proyek . ' dan proses ' . $proses->nama;
            $log->save();

            return view('audit.index', compact('proyek', 'proses', 'audits', 'level', 'pertanyaan'));
        } else {
            return redirect()->back()->with('error', 'Maaf, anda tidak memiliki akses.');
        }
    }

    public function store(Request $request, $id_proyek, $id_proses, $level)
    {
        if (Auth::user()->id_priv == 1 || Auth::user()->id_priv == 2) {
            $pertanyaan_ids = array_keys($request->input('exist', []) + $request->input('document_evidence', []));
            foreach ($pertanyaan_ids as $id_pertanyaan) {
                Audit::updateOrCreate(
                    [
                        'id_proyek' => $id_proyek,
                        'id_proses' => $id_proses,
                        'id_pertanyaan' => $id_pertanyaan,
                    ],
                    [
                        'exist' => isset($request->exist[$id_pertanyaan]),
                        'document_evidence' => $request->document_evidence[$id_pertanyaan] ?? '',
                        'score' => $request->score[$id_pertanyaan] ?? 0,
                        'level' => $level,
                    ]
                );
            }

            $log = new Log;
            $log->id_user = Auth::user()->id;
            $log->aktivitas = 'Menyimpan assessment untuk proyek ' . $id_proyek . ' dan proses ' . $id_proses . ' level ' . $level;
            $log->save();

            // Validasi total score untuk lanjut ke level berikutnya
            $total_score = $request->input('total_score', 0);
            
            // Jika di level 5 dan score >= 86, kembali ke Lembar Kerja
            if ($level == 5 && $total_score >= 86) {
                return redirect()->route('lembar-kerja.index', $id_proyek)
                    ->with('success', 'Data assessment level 5 berhasil disimpan. Assessment selesai.');
            }
            
            // Untuk level 1-4
            if ($total_score >= 86) {
                $nextLevel = $level + 1;
                return redirect()->route('audit.index', [$id_proyek, $id_proses, $nextLevel])
                    ->with('success', 'Data assessment berhasil disimpan. Lanjut ke level berikutnya.');
            } else if ($total_score <= 50 && $level > 1) {
                // Jika score <= 50 dan level > 1, kurangi level di lembar kerja
                $proyek = Proyek::findOrFail($id_proyek);
                
                // Update level di tabel pivot
                DB::table('proyek_proses_audit')
                    ->where('id_proyek', $id_proyek)
                    ->where('id_proses', $id_proses)
                    ->update(['level' => $level - 1]);
                
                // Update level di tabel audit
                Audit::where('id_proyek', $id_proyek)
                    ->where('id_proses', $id_proses)
                    ->where('level', $level)
                    ->update(['level' => $level - 1]);
                
                return redirect()->route('lembar-kerja.index', $id_proyek)
                    ->with('success', 'Data assessment berhasil disimpan. Level dikurangi karena total skor di bawah 50%.');
            } else {
                return redirect()->back()
                    ->with('success', 'Data assessment berhasil disimpan. Pastikan total skor minimal 86% untuk dapat melanjutkan ke level berikutnya.');
            }
        } else {
            return redirect()->back()->with('error', 'Maaf, anda tidak memiliki akses.');
        }
    }
} 