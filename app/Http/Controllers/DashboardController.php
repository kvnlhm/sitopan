<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ProsesAudit;
use App\Models\Pertanyaan;
use App\Models\Proyek;
use App\Models\Audit;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the dashboard page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        
        // Mengambil data aktual dari database
        $total_proses_audit = ProsesAudit::count();
        $total_pertanyaan = Pertanyaan::count();
        $total_proyek = Proyek::count();
        $total_audit = Audit::count();
        
        $data = [
            'total_proses_audit' => [
                'value' => $total_proses_audit,
                'change' => 0, // Perubahan bisa dihitung jika ada data historis
                'icon' => 'update-file'
            ],
            'total_pertanyaan' => [
                'value' => $total_pertanyaan,
                'change' => 0,
                'icon' => 'question'
            ],
            'total_proyek' => [
                'value' => $total_proyek,
                'change' => 0,
                'icon' => 'scroll'
            ],
            'total_audit' => [
                'value' => $total_audit,
                'change' => 0,
                'icon' => 'some-files'
            ]
        ];

        return view('dashboard', compact('user', 'data'));
    }
} 