<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrderItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'quantity',
        'production_price',
        'selling_price',
        'product_id',
        'order_id',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'production_price' => 'decimal:2',
            'selling_price' => 'decimal:2',
        ];
    }

    /**
     * Get the product that owns the sales order item.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the sales order that owns the sales order item.
     */
    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class, 'order_id');
    }

    /**
     * Get the total amount of the sales order item.
     */
    public function getTotalAmountAttribute()
    {
        return $this->quantity * $this->selling_price;
    }
}
