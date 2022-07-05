<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    //

    private static function findCategoryById(array $categories, int $id) {
        foreach($categories as $cat)
            if ($cat->id == $id)
                return $cat;
        return null;
    }

    public function getAllCategories()
    {
        $query = DB::table('product_categories')->select('id', 'name', 'parent_id')->orderBy('parent_id')->orderBy('id')->get();
        $categories = $query->toArray();

        for($i=1; $i<count($categories); $i++) {
            $current = $categories[$i];
            $p = self::findCategoryById($categories, $current->parent_id);
            if (!isset($p->children))
                $p->children = [];
            $p->children[] = $current;
        }

        $json = json_encode($categories[0]);
        return response($json, 200);
    }
}
