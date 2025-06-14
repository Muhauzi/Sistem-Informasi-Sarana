<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_Distributions extends Model 
{
    protected $table = 'distributions';
    protected $fillable = [
        'division_id',
        'distributed_by',
        'description',
        'distributed_at',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the division associated with the distribution.
     */
    public function division()
    {
        return $this->belongsTo(M_Divisions::class, 'division_id');
    }

    /**
     * Get the item associated with the distribution.
     */
    public function item()
    {
        return $this->belongsTo(M_Items::class, 'item_id');
    }

    /**
     * Get the user who distributed the item.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'distributed_by');
    }

    /**
     * Get the item histories associated with the distribution.
     */
    public function itemHistories()
    {
        return $this->hasMany(M_Item_Histories::class, 'distribution_id');
    }



    /**
     * Get all distributions by item ID.
     *
     * @param int $itemId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getDistributionsByItemId($itemId)
    {
        return $this->whereHas('itemHistories', function ($query) use ($itemId) {
            $query->where('item_id', $itemId);
        })->get();
    }
    
}