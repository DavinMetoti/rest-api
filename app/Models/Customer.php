<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'address',
        'phone',
    ];

    /**
     * Get the sales orders for the customer.
     */
    public function salesOrders()
    {
        return $this->hasMany(SalesOrder::class);
    }
}
