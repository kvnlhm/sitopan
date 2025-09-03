<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use App\Models\User;
use App\Models\Log;
use App\Models\ProsesAudit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProyekController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Auth::user()->id_priv == 1 || Auth::user()->id_priv == 2) {
            $data = Proyek::with(['user', 'prosesAudit'])->get();
            $users = User::all();
            $proses_audit = ProsesAudit::all();

            $log = new Log;
            $log->id_user = Auth::user()->id;
            $log->aktivitas = 'Mengakses halaman proyek';
            $log->save();

            return view('proyek.index', compact('data', 'users', 'proses_audit'));
        } else {
            return redirect()->back()->with('error', 'Maaf, anda tidak memiliki akses.');
        }
    }

    public function store(Request $request)
    {
        if (Auth::user()->id_priv == 1 || Auth::user()->id_priv == 2) {
            $request->validate([
                'nama_proyek' => 'required|string|max:255'
            ], [
                'nama_proyek.required' => 'Nama proyek wajib diisi',
                'nama_proyek.string' => 'Nama proyek harus berupa teks',
                'nama_proyek.max' => 'Nama proyek maksimal 255 karakter'
            ]);

            $proyek = new Proyek;
            $proyek->nama_proyek = $request->nama_proyek;
            $proyek->id_user = Auth::user()->id;
            $proyek->save();

            $log = new Log;
            $log->id_user = Auth::user()->id;
            $log->aktivitas = 'Menambahkan proyek baru';
            $log->save();

            return redirect('/proyek')->with('success', 'Proyek berhasil ditambahkan.');
        } else {
            return redirect()->back()->with('error', 'Maaf, anda tidak memiliki akses.');
        }
    }

    public function update(Request $request)
    {
        if (Auth::user()->id_priv == 1 || Auth::user()->id_priv == 2) {
            $request->validate([
                'id' => 'required|exists:proyek,id_proyek',
                'nama_proyek' => 'required|string|max:255'
            ], [
                'id.required' => 'ID proyek tidak valid',
                'id.exists' => 'Proyek tidak ditemukan',
                'nama_proyek.required' => 'Nama proyek wajib diisi',
                'nama_proyek.string' => 'Nama proyek harus berupa teks',
                'nama_proyek.max' => 'Nama proyek maksimal 255 karakter'
            ]);

            $proyek = Proyek::findOrFail($request->id);
            $proyek->nama_proyek = $request->nama_proyek;
            $proyek->id_user = Auth::user()->id;
            $proyek->save();

            $log = new Log;
            $log->id_user = Auth::user()->id;
            $log->aktivitas = 'Memperbarui proyek ' . $request->nama_proyek;
            $log->save();

            return redirect('/proyek')->with('success', 'Proyek berhasil diperbarui.');
        } else {
            return redirect()->back()->with('error', 'Maaf, anda tidak memiliki akses.');
        }
    }

    public function destroy($id)
    {
        if (Auth::user()->id_priv == 1 || Auth::user()->id_priv == 2) {
            $proyek = Proyek::findOrFail($id);
            
            $log = new Log;
            $log->id_user = Auth::user()->id;
            $log->aktivitas = 'Menghapus proyek ' . $proyek->nama_proyek;
            $log->save();

            $proyek->delete();
            
            return redirect('/proyek')->with('success', 'Proyek berhasil dihapus.');
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