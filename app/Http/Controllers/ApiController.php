<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    //

    public function getAllCategories()
    {
        $tree = ProductCategory::getTree();
        $response = json_encode($tree);
        return $response;
    }

    
}
