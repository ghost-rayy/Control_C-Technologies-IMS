<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'user_id',
        'total_amount',
        'total_cost',
        'payment_method',
        'transaction_ref',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function getProfit()
    {
        return $this->total_amount - $this->total_cost;
    }

    public function getProfitMargin()
    {
        if ($this->total_amount == 0) {
            return 0;
        }
        return (($this->total_amount - $this->total_cost) / $this->total_amount) * 100;
    }
}
