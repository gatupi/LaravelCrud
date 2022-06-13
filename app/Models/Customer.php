<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Classes\DateOnly;

class Customer extends Model {
    private string $firstName;
    private ?string $middleName;
    private string $lastName;
    private DateOnly $dateOfBirth;
    private ?string $sex;
    private string $fullName;
    private int $age;
    private int $id;

    public function __construct(int $id, string $fname, ?string $mname, string $lname, DateOnly $dateOfBirth, string $sex) {
        $this->id = $id;
        $this->setFirstName($fname);
        $this->setMiddleName($mname);
        $this->setLastName($lname);
        $this->setDateOfBirth($dateOfBirth);
        $this->setSex($sex);
        $this->setFullName();
        $this->setAge();
    }

    private function setFirstName(string $fname) {
        $this->firstName = $fname;
    }

    private function setMiddleName(?string $mname) {
        $this->middleName = $mname;
    }

    private function setLastName(string $lname) {
        $this->lastName = $lname;
    }

    private function setDateOfBirth(DateOnly $dob) {
        $this->dateOfBirth = $dob;
    }

    private function setFullName() {
        $this->fullName = $this->firstName . ' ' . (isset($this->middleName) ? $this->middleName . ' ' : '') . $this->lastName;
    }

    private function setAge() {
        $now = date('Y/m/d');
        $parts = explode('/', $now);
        $dob = $this->dateOfBirth;
        $yearDiff = (int)$parts[0] - $dob->getYear();
        $monthDiff = (int)$parts[1] - $dob->getMonth();
        $dayDiff = (int)$parts[2] - $dob->getDay();
        $this->age = $yearDiff - ($monthDiff < 0 || ($monthDiff == 0 && $dayDiff < 0) ? 1 : 0);
    }

    public function getAge() {
        return $this->age;
    }

    public function getDateOfBirth() {
        return $this->dateOfBirth;
    }

    private function setSex(string $sex) {
        $sex = strtolower($sex);
        $this->sex = $sex != 'm' && $sex != 'f' ? null : $sex;
    }

    public function getFullName(): string {
        return $this->fullName;
    }

    public function getId() {
        return $this->id;
    }

    public function getSex() {
        return $this->sex;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function getMiddleName() {
        return $this->middleName;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function __toString(): string {
        return "Customer\n  Id: $this->id\n  Name: $this->fullName\n  Date of birth: $this->dateOfBirth\n  Age: $this->age yo\n  Sex: " . strtoupper($this->sex) . "\n";
    }

    public function toArray(): array {
        return [
            'fullName'=>$this->getFullName(),
            'id'=>$this->id,
            'dateOfBirth'=>$this->dateOfBirth->__toString(),
            'age'=>$this->getAge(),
            'sex'=>$this->sex
        ];
    }
}
