<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    //
    protected $table = 'product_categories';
    protected $fillable = ['name', 'parent_id'];

    public function children()
    {
        return $this->hasMany(ProductCategory::class, 'parent_id')->select('id', 'name');
    }

    public function parent()
    {
        return $this->belongsTo(ProductCategory::class, 'parent_id');
    }

    public static function getTree()
    {
        $t = self::getChildrenRecursively(ProductCategory::select('id', 'name')->where('id', 1)->get()->first());
        return $t;
    }

    private static function getChildrenRecursively($category)
    {
        $children = $category->children;
        if ($children->count() > 0) {
            foreach ($children as $child) {
                self::getChildrenRecursively($child);
            }
        }
        return $category;
    }
}
