<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Auth::user()->id_priv == 1) {
            $data = Log::with('user')->orderBy('created_at', 'desc')->get();

            $log = new Log;
            $log->id_user = Auth::user()->id;
            $log->aktivitas = 'Mengakses halaman log aktivitas';
            $log->save();

            return view('log.index', compact('data'));
        } else {
            return redirect()->back()->with('error', 'Maaf, anda tidak memiliki akses.');
        }
    }

    public function destroy($id)
    {
        if (Auth::user()->id_priv == 1) {
            $log = Log::findOrFail($id);
            
            $logAktivitas = new Log;
            $logAktivitas->id_user = Auth::user()->id;
            $logAktivitas->aktivitas = 'Menghapus log aktivitas';
            $logAktivitas->save();

            $log->delete();
            
            return redirect('/log')->with('success', 'Log aktivitas berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Maaf, anda tidak memiliki akses.');
        }
    }

    public function hapusSemua()
    {
        if (Auth::user()->id_priv == 1) {
            $logAktivitas = new Log;
            $logAktivitas->id_user = Auth::user()->id;
            $logAktivitas->aktivitas = 'Menghapus semua log aktivitas';
            $logAktivitas->save();

            Log::truncate();
            
            return redirect('/log')->with('success', 'Semua log aktivitas berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Maaf, anda tidak memiliki akses.');
        }
    }
} 