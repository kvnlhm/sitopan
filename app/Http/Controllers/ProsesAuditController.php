<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\ProsesAudit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProsesAuditController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Auth::user()->id_priv == 1) {
            $data = ProsesAudit::all();

            $log = new Log;
            $log->id_user = Auth::user()->id;
            $log->aktivitas = 'Mengakses halaman proses assessment';
            $log->save();

            return view('proses_audit.index', compact('data'));
        } else {
            return redirect()->back()->with('error', 'Maaf, anda tidak memiliki akses.');
        }
    }

    public function store(Request $request)
    {
        if (Auth::user()->id_priv == 1) {
            $request->validate([
                'nama' => 'required|string|max:255',
                'deskripsi' => 'required|string'
            ], [
                'nama.required' => 'Nama proses assessment wajib diisi',
                'nama.string' => 'Nama proses assessment harus berupa teks',
                'nama.max' => 'Nama proses assessment maksimal 255 karakter',
                'deskripsi.required' => 'Deskripsi wajib diisi',
                'deskripsi.string' => 'Deskripsi harus berupa teks'
            ]);

            $prosesAudit = new ProsesAudit;
            $prosesAudit->nama = $request->nama;
            $prosesAudit->deskripsi = $request->deskripsi;
            $prosesAudit->save();
            
            $log = new Log;
            $log->id_user = Auth::user()->id;
            $log->aktivitas = 'Menambahkan proses assessment';
            $log->save();

            return redirect('/proses-audit')->with('success', 'Proses assessment berhasil ditambahkan.');
        } else {
            return redirect()->back()->with('error', 'Maaf, anda tidak memiliki akses.');
        }
    }

    public function update(Request $request)
    {
        if (Auth::user()->id_priv == 1) {
            $request->validate([
                'nama' => 'required|string|max:255',
                'deskripsi' => 'required|string'
            ], [
                'nama.required' => 'Nama proses assessment wajib diisi',
                'nama.string' => 'Nama proses assessment harus berupa teks',
                'nama.max' => 'Nama proses assessment maksimal 255 karakter',
                'deskripsi.required' => 'Deskripsi wajib diisi',
                'deskripsi.string' => 'Deskripsi harus berupa teks'
            ]);

            $prosesAudit = ProsesAudit::findOrFail($request->id);
            $prosesAudit->nama = $request->nama;
            $prosesAudit->deskripsi = $request->deskripsi;
            $prosesAudit->save();

            $log = new Log;
            $log->id_user = Auth::user()->id;
            $log->aktivitas = 'Memperbarui proses assessment '.$request->nama;
            $log->save();

            return redirect('/proses-audit')->with('success', 'Proses assessment berhasil diperbarui.');
        } else {
            return redirect()->back()->with('error', 'Maaf, anda tidak memiliki akses.');
        }
    }

    public function destroy($id)
    {
        if (Auth::user()->id_priv == 1) {
            $prosesAudit = ProsesAudit::findOrFail($id);
            
            $log = new Log;
            $log->id_user = Auth::user()->id;
            $log->aktivitas = 'Menghapus proses assessment '.$prosesAudit->nama;
            $log->save();

            $prosesAudit->delete();
            
            return redirect('/proses-audit')->with('success', 'Proses assessment berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Maaf, anda tidak memiliki akses.');
        }
    }
} 