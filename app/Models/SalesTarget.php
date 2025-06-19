<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesTarget extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'active_date',
        'amount',
        'sales_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'active_date' => 'date',
            'amount' => 'decimal:2',
        ];
    }

    /**
     * Get the sale that owns the sales target.
     */
    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sales_id');
    }
}
