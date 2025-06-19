<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'production_price',
        'selling_price',
    ];

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
     * Get the sales order items for the product.
     */
    public function salesOrderItems()
    {
        return $this->hasMany(SalesOrderItem::class);
    }
}
