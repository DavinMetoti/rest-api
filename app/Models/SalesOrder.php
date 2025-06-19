<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'reference_no',
        'sales_id',
        'customer_id',
    ];

    /**
     * Get the sale that owns the sales order.
     */
    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sales_id');
    }

    /**
     * Get the customer that owns the sales order.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the sales order items for the sales order.
     */
    public function salesOrderItems()
    {
        return $this->hasMany(SalesOrderItem::class, 'order_id');
    }

    /**
     * Alias for salesOrderItems to support 'items' relationship in repository.
     */
    public function items()
    {
        return $this->salesOrderItems();
    }

    /**
     * Get the total amount of the sales order.
     */
    public function getTotalAmountAttribute()
    {
        return $this->salesOrderItems->sum(function ($item) {
            return $item->quantity * $item->selling_price;
        });
    }
}
