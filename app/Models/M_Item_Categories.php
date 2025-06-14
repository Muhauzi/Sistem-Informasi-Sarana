<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\M_Items; // Assuming M_Items is the model for items

class M_Item_Categories extends Model
{
    protected $table = 'item_categories';
    protected $fillable = [
        'name',
        'code',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    /**
     * Get the items associated with the category.
     */
    public function items()
    {
        return $this->hasMany(M_Items::class, 'item_category_id');
    }
    /**
     * Get the items associated with the category.
     */
    public function getItems()
    {
        return $this->items()->get();
    }

    /**
     * Get all categories.
     */
    public function getAllCategories()
    {
        return $this->all();
    }

    /**
     * Create a new category.
     *
     * @param array $data
     * @return M_Item_Categories
     */
    public function createCategory(array $data)
    {
        return $this->create($data);
    }
}
