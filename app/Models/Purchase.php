<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Suplier;
use App\Models\PurchaseItem;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'suplier_id',
        'invoice_number',
        'purchase_date',
        'deskripsi',
        'total',
    ];

    public function suplier()
    {
        return $this->belongsTo(suplier::class);
    }

    public function items()
    {
        return $this->hasMany(PurchaseItem::class);
    }
}
