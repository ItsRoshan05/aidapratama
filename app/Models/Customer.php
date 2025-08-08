<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    protected $table = 'customers';
    protected $fillable = [
        'name',
        'nohp',
        'email',
        'alamat',
        'jenis_kelamin',
        'tipe_bank',
        'nama_bank',
        'no_rekening',
        'atas_nama',
    ];
}
