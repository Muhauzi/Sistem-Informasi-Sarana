<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_Item_Histories extends Model
{
    protected $table = 'item_histories';
    protected $fillable = [
        'distribution_id',
        'item_id',
        'from_division_id',
        'to_division_id',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the item associated with the history.
     */
    public function item()
    {
        return $this->belongsTo(M_Items::class, 'item_id');
    }

    /**
     * Get the item associated with the history.
     */
    public function getItem()
    {
        return $this->item()->first();
    }

    /**
     * Get the division from which the item was moved.
     */
    public function fromDivision()
    {
        return $this->belongsTo(M_Divisions::class, 'from_division_id');
    }

    /**
     * Get the division to which the item was moved.
     */

    public function toDivision()
    {
        return $this->belongsTo(M_Divisions::class, 'to_division_id');
    }

    /**
     * Get the distribution associated with the history.
     */
    public function distribution()
    {
        return $this->belongsTo(M_Distributions::class, 'distribution_id');
    }

    public function getHistoriesByItemId($itemId)
    {
        return $this->where('item_id', $itemId)
            ->orderBy('created_at', 'desc')
            ->with(['item:id,name', 'fromDivision:id,name', 'toDivision:id,name'])
            ->get()
            ->map(function ($history) {
                return [
                    'id' => $history->id,
                    'item_id' => $history->item->id ?? null,
                    'item_name' => $history->item->name ?? null,
                    'from_division_id' => $history->fromDivision->id ?? null,
                    'from_division_name' => $history->fromDivision->name ?? null,
                    'to_division_id' => $history->toDivision->id ?? null,
                    'to_division_name' => $history->toDivision->name ?? null,
                    'distribution_id' => $history->distribution_id,
                    'created_at' => $history->created_at,
                ];
            });
    }


    /**
     * Get the item histories associated with the distribution.
     */
    public function getItemByDistributions($idDistribution)
    {
        return $this->where('distribution_id', $idDistribution)
            ->orderBy('created_at', 'desc')
            ->with(['item:id,name'])
            ->get()
            ->map(function ($history) {
                return [
                    'id' => $history->item->id ?? null,
                    'name' => $history->item->name ?? null,
                ];
            });
    }
}
