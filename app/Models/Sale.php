<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'invoice_number',
        'customer_id',
        'tag',
        'sale_date',
        'total',
        'note',
        'term', // dalam hari
        'deadline_date', // tanggal jatuh tempo 
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }
}
