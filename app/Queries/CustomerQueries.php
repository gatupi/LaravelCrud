<?php

use Illuminate\Support\Facades\DB;
use App\Models\Filters\CustomerListFilter;

class CustomerQueries {

    private function __construct() { }

    public static function getCustomerList($order, CustomerListFilter $filters) {



        $query = DB::table('customer_list_view as c')
            ->select(DB::raw("row_number() over (" . $order . ") as n, c.*"))
            ->whereRaw("
            (? is null or year(date_of_birth) = ?)
            and (? is null or month(date_of_birth) = ?)
            and (? is null or day(date_of_birth) = ?)
            and (? is null or sex = ?)
            and (? is null or active = ?)
            and (? is null or full_name like ?)
            and (? is null or age >= ?)
            and (? is null or age <= ?)
        ", [
                $filters['birth_year'], $filters['birth_year'], $filters['birth_month'], $filters['birth_month'],
                $filters['birth_day'], $filters['birth_day'], $filters['sex'], $filters['sex'],
                $filters['active'], $filters['active'],
                $filters['name'], $filters['name'], $filters['age_min'], $filters['age_min'],
                $filters['age_max'], $filters['age_max']
            ]);
    }
}