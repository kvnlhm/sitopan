<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyek extends Model
{
    use HasFactory;

    protected $table = 'proyek';
    protected $primaryKey = 'id_proyek';
    public $timestamps = true;

    protected $fillable = [
        'nama_proyek',
        'id_user'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function prosesAudit()
    {
        return $this->belongsToMany(ProsesAudit::class, 'proyek_proses_audit', 'id_proyek', 'id_proses')
            ->withPivot('level')
            ->withTimestamps();
    }
} 