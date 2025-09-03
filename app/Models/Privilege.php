<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    protected $table = 'priv';
    protected $primaryKey = 'id_priv';
    protected $fillable = ['nama'];

    public function users()
    {
        return $this->hasMany(User::class, 'id_priv');
    }
} 