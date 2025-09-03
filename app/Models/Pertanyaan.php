<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    use HasFactory;

    protected $table = 'pertanyaan';
    protected $primaryKey = 'id_pertanyaan';
    public $timestamps = true;

    protected $fillable = [
        'kode_proses',
        'level',
        'pa',
        'praktik',
        'pertanyaan',
        'deskripsi'
    ];

    public function prosesAudit()
    {
        return $this->belongsTo(ProsesAudit::class, 'kode_proses', 'nama');
    }
} 