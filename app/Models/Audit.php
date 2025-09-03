<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    use HasFactory;

    protected $table = 'audit';
    protected $primaryKey = 'id_audit';
    public $timestamps = true;

    protected $fillable = [
        'id_proyek',
        'id_proses',
        'sub_proses',
        'id_pertanyaan',
        'exist',
        'document_evidence',
        'score',
        'level'
    ];

    protected $casts = [
        'exist' => 'boolean'
    ];

    public function proyek()
    {
        return $this->belongsTo(Proyek::class, 'id_proyek', 'id_proyek');
    }

    public function prosesAudit()
    {
        return $this->belongsTo(ProsesAudit::class, 'id_proses', 'id_proses');
    }
} 