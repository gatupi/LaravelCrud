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
     * @return string
     */

    public function getFullNameAttribute() {
        return $this->first_name  . (!empty($this->middle_name) ? " $this->middle_name " : " ") . $this->last_name;
    }

    /**
     * @param string $value
     * @return string
     */

    public function getFirstNameAttribute($value) {
        return self::ucfirst_name_part($value);
    }

    /**
     * @param string
     * @return ?string
     */

    public function getMiddleNameAttribute($value) {
        return !empty($value) ? self::ucfirst_name_part($value) : null;
    }

    /**
     * @param string
     * @return string
     */

    public function getLastNameAttribute($value) {
        return self::ucfirst_name_part($value);
    }

    public static function ucfirst_name_part(string $name_part): string {
        return mb_strtoupper(substr($name_part, 0, 1)) . mb_strtolower(substr($name_part, 1));
    }

    /**
     * @return int
     */

    public function getAgeAttribute() {
        $birth = self::get_date_parts($this->date_of_birth);
        $current = self::get_date_parts(date('Y-m-d'));
        $year_diff = $current['year'] - $birth['year'];
        $month_diff = $current['month'] - $birth['month'];
        $day_diff = $current['day'] - $birth['day'];

        return $year_diff - ($month_diff < 0 || ($month_diff == 0 && $day_diff < 0));
    }

    public static function get_date_parts(string $dateStr): array { // valid format: Y-m-d, retorna ['year'=>, 'month'=>, 'day'=>]
        $parts = explode('-', $dateStr);
        return ['year'=>(int)$parts[0], 'month'=>(int)$parts[1], 'day'=>(int)$parts[2]];
    }

    /**
     * @return string
     */

    public function getHiddenCpfAttribute() {
        return '***.' . substr($this->cpf, 3, 3) . '.***-' . substr($this->cpf, 9);
    }

    /**
     * @return string
     */

    public function getFormattedCpfAttribute() {
        return substr($this->cpf, 0, 3) . '.' . substr($this->cpf, 3, 3) . '.' . substr($this->cpf, 6, 3) . '-' . substr($this->cpf, 9);
    }

    /**
     * @param string
     * @return void
     */

    public function setDateOfBirthAttribute($value) {
        $this->attributes['date_of_birth'] = self::adjustDate($value);
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
        $today = date('Y-m-d');
        
        if($d > $today)
            throw new Exception("Error: Date of birth cannot be later than today! Date of birth was $dateStr.");

        return $d; // y-m-d
    }

    public function toListView(): array {
        return [
            'full_name'=>$this->full_name,
            'age'=>$this->age,
            'date_of_birth'=>$this->date_of_birth,
            'id'=>$this->id,
            'cpf'=>$this->formatted_cpf,
            'sex'=>$this->sex,
            'active'=>$this->active
        ];
    }
}
