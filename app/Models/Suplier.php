<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suplier extends Model
{
    //
    protected $table = 'supliers';

    protected $fillable = [
        'name',
        'nohp',
        'email',
        'alamat',
        'jenis_kelamin',
        'nama_pt',
        'brand',
        'tipe_bank',
        'nama_bank',
        'no_rekening',
        'atas_nama',
    ];
    
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}

