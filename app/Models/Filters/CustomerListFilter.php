<?php

namespace App\Models\Filters;

use \Illuminate\Http\Request;

class CustomerListFilter
{

    private const PARAMS = ['name', 'age_min', 'age_max', 'birth_year', 'birth_month', 'birth_day', 'sex', 'active'];
    private array $data = [];

    public function __construct(Request $request)
    {
        $this->data = array_fill_keys(self::PARAMS, null);

        if (isset($request['age_opt'])) {
            switch($request['age_opt']) {
                case 'greater':
                    $this->age_min = $request['age2'];
                    break;
                case 'less':
                    $this->age_max = $request['age2'];
                    break;
                case 'equal':
                    $this->age_min = $this->age_max = $request['age2'];
                    break;
                case 'between':
                    $this->age_min = $request['age1'];
                    $this->age_max = $request['age2'];
                    break;
            }
        }

        if (isset($request['birth_opt'])) {
            switch($request['birth_opt']) {
                case 'date':
                    $parts = getDateParts($request['birth_date']);
                    $this->birth_year = $parts['year'];
                    $this->birth_month = $parts['month'];
                    $this->birth_day = $parts['day'];
                    break;
                case 'month':
                    $this->birth_month = $request['birth_month'];
                    break;
                
                case 'year':
                    $this->birth_year = $request['birth_year'];
                    break;
                case 'month-and-year':
                    $this->birth_month = $request['birth_month'];
                    $this->birth_year = $request['birth_year'];
                    break;
                case 'month-and-day':
                    $this->birth_month = $request['birth_month'];
                    $this->birth_day = $request['birth_day'];
                    break;
                case 'birthday':
                    switch($request['birthday_opt']) {
                        case 'd':
                            $this->birth_day = (int)date('d');
                        case 'm':
                            $this->birth_month = (int)date('m');
                            break;
                    }
                    break;
            }
        }

        $this->active = $request['activity'] ?? null;
        $this->sex = $request['sex'] ?? null;

        if (isset($request['name']))
            $this->name = '%' . $request['name'] . '%';
    }

    public function __set($key, $value)
    {
        if (in_array($key, self::PARAMS))
            $this->data[$key] = $value;
    }

    public function __get($key)
    {
        return in_array($key, self::PARAMS) ? $this->data[$key] : null;
    }

    public function toArray()
    {
        return $this->data;
    }
}
