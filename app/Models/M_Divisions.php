<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_Divisions extends Model
{
    protected $table = 'divisions';
    protected $fillable = [
        'name',
        'description',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the items associated with the division.
     */
    public function items()
    {
        return $this->hasMany(M_Items::class, 'division_id');
    }

    /**
     * Get the items associated with the division.
     */
    public function getItems()
    {
        return $this->items()->get();
    }
}