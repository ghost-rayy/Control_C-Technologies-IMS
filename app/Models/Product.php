<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'brand',
        'model',
        'serial_number',
        'cost_price',
        'selling_price',
        'quantity_in_stock',
        'low_stock_threshold',
        'supplier',
        'description',
        'sku',
    ];

    protected $casts = [
        'cost_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function isLowStock()
    {
        return $this->quantity_in_stock <= $this->low_stock_threshold;
    }

    public function getProfit()
    {
        return $this->selling_price - $this->cost_price;
    }

    public function getProfitMargin()
    {
        if ($this->selling_price == 0) {
            return 0;
        }
        return (($this->selling_price - $this->cost_price) / $this->selling_price) * 100;
    }
}
