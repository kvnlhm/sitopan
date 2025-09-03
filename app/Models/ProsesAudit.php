<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProsesAudit extends Model
{
    use HasFactory;

    protected $table = 'proses_audit';
    protected $primaryKey = 'id_proses';
    public $timestamps = true;
    
    protected $fillable = [
        'nama',
        'deskripsi'
    ];

    public function proyek()
    {
        return $this->belongsToMany(Proyek::class, 'proyek_proses_audit', 'id_proses', 'id_proyek')
            ->withTimestamps();
    }
} 