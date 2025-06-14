<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_Items extends Model
{
    protected $table = 'items';
    protected $primaryKey = 'id';         
    public $incrementing = false;         
    protected $keyType = 'string'; 
    protected $fillable = [
        'id',
        'name',
        'item_category_id',
        'division_id',
        'condition',
        'purchase_year',
        'photo_path',
        'qr_code',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the category associated with the item.
     */
    public function category()
    {
        return $this->belongsTo(M_Item_Categories::class, 'item_category_id');
    }

    /**
     * Get the category associated with the item.
     */
    public function getCategory()
    {
        return $this->category()->first();
    }

    /**
     * Get the division associated with the item.
     */

    public function division()
    {
        return $this->belongsTo(M_Divisions::class, 'division_id');
    }

    /**
     * Get the division associated with the item.
     */
    public function getDivision()
    {
        return $this->division()->first();
    }

    /**
     * Get the item histories associated with the item.
     */

    public function histories()
    {
        return $this->hasMany(M_Item_Histories::class, 'item_id');
    }

    /**
     * Get the item histories associated with the item.
     */
    public function getHistories()
    {
        return $this->histories()->get();
    }

    /**
     * Get the distributions associated with the item.
     */

    public function distributions()
    {
        return $this->hasMany(M_Distributions::class, 'item_id');
    }

    /**
     * Get the distributions associated with the item.
     */
    public function getDistributions()
    {
        return $this->distributions()->get();
    }

    /**
     * Get all items with their categories.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getAllWithCategory()
    {
        return self::with('category')->get();
    }

    /** 
     * Get items with id and category by Id
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getItemsById($id)
    {
        return self::with('category')->where('id', $id)->first();
    }

    /**
     * Get all items with their divisions.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */



}