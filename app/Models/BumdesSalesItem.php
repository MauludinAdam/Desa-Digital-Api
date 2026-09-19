<?php

namespace App\Models;

use App\Models\BumdesProduct;
use App\Models\BumdesSales;
use App\Models\BumdesSalesItem;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;

class BumdesSalesItem extends Model
{
    use UUID;

    protected $fillable = [
        'bumdes_sales_id',
        'bumdes_product_id',
        'quantity',
        'price',
        'subtotal',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->whereHas('bumdesProduct', function($query) use ($search){
            $query->where('name', 'like', "%{$search}%");
        });
    }

    public function bumdesSales()
    {
        return $this->belongsTo(BumdesSales::class);
    }

    public function bumdesProduct()
    {
        return $this->belongsTo(BumdesProduct::class);
    }
}
