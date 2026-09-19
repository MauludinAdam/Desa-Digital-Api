<?php

namespace App\Models;

use App\Models\BumdesUnit;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;

class BumdesSales extends Model
{
    use UUID;

    protected $fillable = [
        'invoice_number',
        'sale_date',
        'customer_name',
        'total_amount',
        'payment_method',
        'status',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where('customer_name', 'like', "%{$search}%")
                ->orWhere('invoice_number', 'like', "%{$search}%");
    }

    public function bumdesUnit()
    {
        return $this->belongsTo(BumdesUnit::class);
    }

    public function bumdesSalesItem()
    {
        return $this->hasMany(BumdesSalesItem::class);
    }
}
