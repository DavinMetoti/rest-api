<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'area_id',
    ];

    /**
     * Get the user that owns the sale.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the area that the sale belongs to.
     */
    public function area()
    {
        return $this->belongsTo(SalesArea::class, 'area_id');
    }

    /**
     * Get the sales orders for the sale.
     */
    public function salesOrders()
    {
        return $this->hasMany(SalesOrder::class, 'sales_id');
    }

    /**
     * Get the sales targets for the sale.
     */
    public function salesTargets()
    {
        return $this->hasMany(SalesTarget::class, 'sales_id');
    }
}
