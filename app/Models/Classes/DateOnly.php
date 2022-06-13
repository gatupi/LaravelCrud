<?php

namespace App\Models\Classes;

use Illuminate\Database\Eloquent\Model;

class DateOnly extends Model {
    private int $day;
    private int $month;
    private int $year;

    public function __construct(int $year, int $month, int $day) {
        $this->setYear($year);
        $this->setMonth($month);
        $this->setDay($day);
    }

    public static function buildByString(string $dateStr): ?DateOnly {
        $pattern = '/^[0-9]{1,4}\/[0-9]{1,2}\/[0-9]{1,2}$/';
        echo $pattern . "\n";
        if (preg_match($pattern, $dateStr)) {
            $parts = explode('/', $dateStr);
            return new DateOnly($parts[0], $parts[1], $parts[2]);
        }
        echo "invalid!\n";
        return null;
    }

    private function setDay(int $day): void {
        $m30 = [4, 6, 9, 11];
        $max = 31;
        if ($this->month == 2)
            $max = $this->isLeapYear() ? 29 : 28;
        else if (in_array($this->month, $m30))
            $max = 30;
        $this->day = $day < 1 ? 1 : ($day > $max ? $max : $day);
    }

    private function setMonth(int $month): void {
        $this->month = $month < 1 ? 1 : ($month > 12 ? 12 : $month);
    }

    private function setYear(int $year): void {
        $this->year = $year < 1 ? 1 : ($year > 9999 ? 9999 : $year);
    }

    public function isLeapYear(): bool {
        return $this->year % 100 == 0 ? $this->year % 400 == 0 : $this->year % 4 == 0;
    }

    public function __toString(): string {
        return $this->toString();
    }

    public function getDay(): int {
        return $this->day;
    }

    public function getMonth(): int {
        return $this->month;
    }

    public function getYear(): int {
        return $this->year;
    }

    public function toString(string $format = "dd/MM/yyyy"): string {

        switch($format){
            default:
            case "dd/MM/yyyy":
                return str_pad($this->day, 2, '0', STR_PAD_LEFT) . '/' . str_pad($this->month, 2, '0', STR_PAD_LEFT) . '/' . str_pad($this->year, 4, '0', STR_PAD_LEFT);
            case "MM/dd/yyyy":
                return str_pad($this->month, 2, '0', STR_PAD_LEFT) . '/' . str_pad( $this->day, 2,'0', STR_PAD_LEFT) . '/' . str_pad($this->year, 4, '0', STR_PAD_LEFT);
            case "yyyy/MM/dd":
                return str_pad($this->year, 4, '0', STR_PAD_LEFT) . '/' . str_pad($this->month, 2, '0', STR_PAD_LEFT) . '/' . str_pad($this->day, 2, '0', STR_PAD_LEFT);
            case "d/M/y":
                return $this->day . '/' . $this->month . '/' . $this->year;
            case "M/d/y":
                return $this->month . '/' . $this->day . '/' . $this->year;
            case "y/M/d":
                return $this->year . '/' . $this->month . '/' . $this->day;
        }
    }
}
