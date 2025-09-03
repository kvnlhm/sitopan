<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use App\Models\ProsesAudit;
use App\Models\Log;
use App\Models\Audit;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class LembarKerjaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id_proyek)
    {
        if (Auth::user()->id_priv == 1 || Auth::user()->id_priv == 2) {
            $proyek = Proyek::with(['prosesAudit' => function($query) use ($id_proyek) {
                $query->withPivot('level');
            }])->findOrFail($id_proyek);

            // Get latest audit level for each process
            foreach($proyek->prosesAudit as $proses) {
                $latestAudit = Audit::where('id_proyek', $id_proyek)
                    ->where('id_proses', $proses->id_proses)
                    ->orderBy('level', 'desc')
                    ->first();
                
                if($latestAudit && $latestAudit->level > $proses->pivot->level) {
                    // Update level in pivot table
                    $proyek->prosesAudit()->updateExistingPivot($proses->id_proses, [
                        'level' => $latestAudit->level
                    ]);
                    // Update level in collection
                    $proses->pivot->level = $latestAudit->level;
                }
            }

            $proses_audit = ProsesAudit::all();
            
            $log = new Log;
            $log->id_user = Auth::user()->id;
            $log->aktivitas = 'Mengakses lembar kerja proyek ' . $proyek->nama_proyek;
            $log->save();

            return view('lembar_kerja.index', compact('proyek', 'proses_audit'));
        } else {
            return redirect()->back()->with('error', 'Maaf, anda tidak memiliki akses.');
        }
    }

    public function hapusProses(Request $request, $id_proyek)
    {
        if (Auth::user()->id_priv == 1 || Auth::user()->id_priv == 2) {
            $request->validate([
                'id_proses' => 'required|exists:proses_audit,id_proses'
            ], [
                'id_proses.required' => 'ID proses assessment wajib diisi',
                'id_proses.exists' => 'Proses assessment tidak ditemukan'
            ]);

            $proyek = Proyek::findOrFail($id_proyek);
            $proses = ProsesAudit::findOrFail($request->id_proses);
            
            // Hapus relasi proyek dengan proses assessment
            $proyek->prosesAudit()->detach($request->id_proses);

            $log = new Log;
            $log->id_user = Auth::user()->id;
            $log->aktivitas = 'Menghapus proses assessment ' . $proses->nama . ' dari proyek ' . $proyek->nama_proyek;
            $log->save();

            return redirect()->back()->with('success', 'Proses assessment berhasil dihapus dari lembar kerja.');
        } else {
            return redirect()->back()->with('error', 'Maaf, anda tidak memiliki akses.');
        }
    }

    public function streamPdf($id_proyek)
    {
        if (Auth::user()->id_priv == 1 || Auth::user()->id_priv == 2) {
            $proyek = Proyek::with(['prosesAudit' => function($query) {
                $query->withPivot('level');
            }])->findOrFail($id_proyek);

            // Get audit details for each process and level
            $auditDetails = [];
            foreach($proyek->prosesAudit as $proses) {
                $auditDetails[$proses->id_proses] = [];
                for($level = 1; $level <= $proses->pivot->level; $level++) {
                    // Get pertanyaan for this level
                    $pertanyaan = Pertanyaan::where('kode_proses', $proses->nama)
                        ->where('level', $level)
                        ->get();

                    // Get audits for these pertanyaan
                    $audits = Audit::where('id_proyek', $id_proyek)
                        ->where('id_proses', $proses->id_proses)
                        ->where('level', $level)
                        ->get()
                        ->keyBy('id_pertanyaan');

                    // Group pertanyaan by praktik for level > 1
                    if($level > 1) {
                        $praktikGroups = $pertanyaan->groupBy('praktik');
                        $auditDetails[$proses->id_proses][$level] = [
                            'type' => 'praktik',
                            'groups' => $praktikGroups,
                            'audits' => $audits
                        ];
                    } else {
                        $auditDetails[$proses->id_proses][$level] = [
                            'type' => 'pertanyaan',
                            'pertanyaan' => $pertanyaan,
                            'audits' => $audits
                        ];
                    }
                }
            }
            
            $log = new Log;
            $log->id_user = Auth::user()->id;
            $log->aktivitas = 'Melihat lembar kerja proyek ' . $proyek->nama_proyek . ' dalam format PDF';
            $log->save();

            $pdf = PDF::loadView('lembar_kerja.pdf', compact('proyek', 'auditDetails'));
            return $pdf->stream('lembar_kerja_' . $proyek->nama_proyek . '.pdf');
        } else {
            return redirect()->back()->with('error', 'Maaf, anda tidak memiliki akses.');
        }
    }

    public function generatePdf($id_proyek)
    {
        if (Auth::user()->id_priv == 1 || Auth::user()->id_priv == 2) {
            $proyek = Proyek::with(['prosesAudit' => function($query) {
                $query->withPivot('level');
            }])->findOrFail($id_proyek);

            // Get audit details for each process and level
            $auditDetails = [];
            foreach($proyek->prosesAudit as $proses) {
                $auditDetails[$proses->id_proses] = [];
                for($level = 1; $level <= $proses->pivot->level; $level++) {
                    // Get pertanyaan for this level
                    $pertanyaan = Pertanyaan::where('kode_proses', $proses->nama)
                        ->where('level', $level)
                        ->get();

                    // Get audits for these pertanyaan
                    $audits = Audit::where('id_proyek', $id_proyek)
                        ->where('id_proses', $proses->id_proses)
                        ->where('level', $level)
                        ->get()
                        ->keyBy('id_pertanyaan');

                    // Group pertanyaan by praktik for level > 1
                    if($level > 1) {
                        $praktikGroups = $pertanyaan->groupBy('praktik');
                        $auditDetails[$proses->id_proses][$level] = [
                            'type' => 'praktik',
                            'groups' => $praktikGroups,
                            'audits' => $audits
                        ];
                    } else {
                        $auditDetails[$proses->id_proses][$level] = [
                            'type' => 'pertanyaan',
                            'pertanyaan' => $pertanyaan,
                            'audits' => $audits
                        ];
                    }
                }
            }
            
            $log = new Log;
            $log->id_user = Auth::user()->id;
            $log->aktivitas = 'Mengunduh lembar kerja proyek ' . $proyek->nama_proyek . ' dalam format PDF';
            $log->save();

            $pdf = PDF::loadView('lembar_kerja.pdf', compact('proyek', 'auditDetails'));
            return $pdf->download('lembar_kerja_' . $proyek->nama_proyek . '.pdf');
        } else {
            return redirect()->back()->with('error', 'Maaf, anda tidak memiliki akses.');
        }
    }

    public function getProsesAudit($id)
    {
        if (Auth::user()->id_priv == 1 || Auth::user()->id_priv == 2) {
            $proyek = Proyek::with('prosesAudit')->findOrFail($id);
            return response()->json($proyek->prosesAudit);
        }
        return response()->json([], 403);
    }

    public function prosesAudit(Request $request)
    {
        if (Auth::user()->id_priv == 1 || Auth::user()->id_priv == 2) {
            $request->validate([
                'id_proyek' => 'required|exists:proyek,id_proyek',
                'id_proses' => 'required|array',
                'id_proses.*' => 'exists:proses_audit,id_proses'
            ], [
                'id_proyek.required' => 'ID proyek wajib diisi',
                'id_proyek.exists' => 'Proyek tidak ditemukan',
                'id_proses.required' => 'Proses assessment wajib dipilih',
                'id_proses.array' => 'Format proses assessment tidak valid',
                'id_proses.*.exists' => 'Proses assessment tidak valid'
            ]);

            $proyek = Proyek::findOrFail($request->id_proyek);
            
            // Sync relasi proyek dengan proses assessment
            $proyek->prosesAudit()->sync($request->id_proses);

            $log = new Log;
            $log->id_user = Auth::user()->id;
            $log->aktivitas = 'Memperbarui proses assessment untuk proyek ' . $proyek->nama_proyek;
            $log->save();

            return redirect('/lembar-kerja/' . $proyek->id_proyek)->with('success', 'Proses assessment berhasil diperbarui.');
        } else {
            return redirect()->back()->with('error', 'Maaf, anda tidak memiliki akses.');
        }
    }
} 