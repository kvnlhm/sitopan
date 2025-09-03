<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Pertanyaan;
use App\Models\ProsesAudit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PertanyaanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Auth::user()->id_priv == 1) {
            $data = Pertanyaan::with('prosesAudit')->get();
            $prosesAudit = ProsesAudit::all();

            $log = new Log;
            $log->id_user = Auth::user()->id;
            $log->aktivitas = 'Mengakses halaman pertanyaan';
            $log->save();

            return view('pertanyaan.index', compact('data', 'prosesAudit'));
        } else {
            return redirect()->back()->with('error', 'Maaf, anda tidak memiliki akses.');
        }
    }

    public function store(Request $request)
    {
        if (Auth::user()->id_priv == 1) {
            $request->validate([
                'kode_proses' => 'required|exists:proses_audit,nama',
                'level' => 'required|string',
                // 'pa' => 'required|string',
                'praktik' => 'required|string',
                'pertanyaan' => 'required|string',
                // 'deskripsi' => 'required|string'
            ], [
                'kode_proses.required' => 'Kode proses wajib dipilih',
                'kode_proses.exists' => 'Kode proses tidak valid',
                'level.required' => 'Level wajib diisi',
                'level.string' => 'Level harus berupa teks',
                // 'level.max' => 'Level maksimal 50 karakter',
                // 'pa.required' => 'PA wajib diisi',
                // 'pa.string' => 'PA harus berupa teks',
                // 'pa.max' => 'PA maksimal 50 karakter',
                'praktik.required' => 'Praktik wajib diisi',
                'praktik.string' => 'Praktik harus berupa teks',
                // 'praktik.max' => 'Praktik maksimal 50 karakter',
                'pertanyaan.required' => 'Pertanyaan wajib diisi',
                'pertanyaan.string' => 'Pertanyaan harus berupa teks',
                // 'deskripsi.required' => 'Deskripsi wajib diisi',
                // 'deskripsi.string' => 'Deskripsi harus berupa teks'
            ]);

            $pertanyaan = new Pertanyaan;
            $pertanyaan->kode_proses = $request->kode_proses;
            $pertanyaan->level = $request->level;
            // $pertanyaan->pa = $request->pa;
            $pertanyaan->praktik = $request->praktik;
            $pertanyaan->pertanyaan = $request->pertanyaan;
            // // $pertanyaan->deskripsi = $request->deskripsi;
            $pertanyaan->save();
            
            $log = new Log;
            $log->id_user = Auth::user()->id;
            $log->aktivitas = 'Menambahkan pertanyaan';
            $log->save();

            return redirect('/pertanyaan')->with('success', 'Pertanyaan berhasil ditambahkan.');
        } else {
            return redirect()->back()->with('error', 'Maaf, anda tidak memiliki akses.');
        }
    }

    public function update(Request $request)
    {
        if (Auth::user()->id_priv == 1) {
            $request->validate([
                'id' => 'required|exists:pertanyaan,id_pertanyaan',
                'kode_proses' => 'required|exists:proses_audit,nama',
                'level' => 'required|string',
                // 'pa' => 'required|string',
                'praktik' => 'required|string',
                'pertanyaan' => 'required|string',
                // 'deskripsi' => 'required|string'
            ], [
                'id.required' => 'ID pertanyaan tidak valid',
                'id.exists' => 'ID pertanyaan tidak ditemukan',
                'kode_proses.required' => 'Kode proses wajib dipilih',
                'kode_proses.exists' => 'Kode proses tidak valid',
                'level.required' => 'Level wajib diisi',
                'level.string' => 'Level harus berupa teks',
                // 'level.max' => 'Level maksimal 50 karakter',
                // 'pa.required' => 'PA wajib diisi',
                // 'pa.string' => 'PA harus berupa teks',
                // 'pa.max' => 'PA maksimal 50 karakter',
                'praktik.required' => 'Praktik wajib diisi',
                'praktik.string' => 'Praktik harus berupa teks',
                // 'praktik.max' => 'Praktik maksimal 50 karakter',
                'pertanyaan.required' => 'Pertanyaan wajib diisi',
                'pertanyaan.string' => 'Pertanyaan harus berupa teks',
                // 'deskripsi.required' => 'Deskripsi wajib diisi',
                // 'deskripsi.string' => 'Deskripsi harus berupa teks'
            ]);

            $pertanyaan = Pertanyaan::findOrFail($request->id);
            $pertanyaan->kode_proses = $request->kode_proses;
            $pertanyaan->level = $request->level;
            // $pertanyaan->pa = $request->pa;
            $pertanyaan->praktik = $request->praktik;
            $pertanyaan->pertanyaan = $request->pertanyaan;
            // // $pertanyaan->deskripsi = $request->deskripsi;
            $pertanyaan->save();

            $log = new Log;
            $log->id_user = Auth::user()->id;
            $log->aktivitas = 'Memperbarui pertanyaan';
            $log->save();

            return redirect('/pertanyaan')->with('success', 'Pertanyaan berhasil diperbarui.');
        } else {
            return redirect()->back()->with('error', 'Maaf, anda tidak memiliki akses.');
        }
    }

    public function destroy($id)
    {
        if (Auth::user()->id_priv == 1) {
            $pertanyaan = Pertanyaan::findOrFail($id);
            
            $log = new Log;
            $log->id_user = Auth::user()->id;
            $log->aktivitas = 'Menghapus pertanyaan';
            $log->save();

            $pertanyaan->delete();
            
            return redirect('/pertanyaan')->with('success', 'Pertanyaan berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Maaf, anda tidak memiliki akses.');
        }
    }
} 