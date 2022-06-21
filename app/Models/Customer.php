<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Classes\DateOnly;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Exception;

class Customer extends Model {

    use SoftDeletes;

    protected $fillable = ['first_name', 'middle_name', 'last_name', 'sex', 'date_of_birth', 'cpf', 'active'];

    /**
     * @param string
     * @return string
     */

    public function getFullNameAttribute($value) {
        return "$this->first_name $this->last_name";
    }

    public function __set($key, $value) {
        switch($key) {
            case 'cpf':
                self::validateCpf($value);
                $this[$key] = $value;
                break;
            case 'date_of_birth':
                $this[$key] = self::adjustDate($value);
                break;
            default:
                $this[$key] = $value;
        }
    }

    private static function validateCpf(string $cpf) {
        if (!is_numeric($cpf) || strlen($cpf) != 11)
            throw new Exception('Invalid cpf!');
    }

    private static function validateDate(string $dateStr) { // generica, deixar externa
        $pattern = '/^([0-9]{2}\/){2}[0-9]{4}$/';
        $match = preg_match($pattern, $dateStr);
        if (!$match)
            throw new Exception('Invalid date!');
    }

    private static function adjustDate(string $dateStr) {
        self::validateDate($dateStr);
        $parts = explode('/', $dateStr);
        $day = $parts[0];
        $month = $parts[1];
        $year = $parts[2];

        $year = $year < 1 ? 1 : ($year > 9999 ? 9999 : $year);
        $month = $month < 1 ? 1 : ($month > 12 ? 12 : $month);

        $leapYear = $year % 100 == 0 ? ($year % 400 == 0) : ($year % 4 == 0);
        $max = [31,28,31,30,31,30,31,31,30,31,30,31];
        $m = $max[$month-1] + ($leapYear && $month == 2 ? 1 : 0);
        $day = $day < 1 ? 1 : ($day > $m ? $m : $day);

        $d = "$year-$month-$day";
        $today = date('Y-m-d', (new \DateTime())->getTimestamp());
        
        if($d > $today)
            throw new Exception("Error: Date of birth cannot be later than today! Date of birth was $dateStr.");

        return $d; // y-m-d
    }

    public function toArray(): array {
        return (array)$this;
    }
}
