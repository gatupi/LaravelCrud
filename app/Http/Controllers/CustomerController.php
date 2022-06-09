<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Customer {
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
}

class DateOnly {
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

class CustomerController extends Controller
{
    public function __construct(){

        $clientes_mock = [
            new Customer(1, 'Gabriel', 'Willian', 'Alonso', new DateOnly(1997,12,8), 'm'),
            new Customer(2, 'Mariana', null, 'Malaguti', new DateOnly(2002,5,30), 'f'),
            new Customer(3, 'Aline', null, 'Capocci', new DateOnly(1980,5,18), 'f'),
            new Customer(4, 'Raphael', 'Vinicios', 'Alonso', new DateOnly(1999,3,28), 'm') 
        ];

        $clientes = session('customers'); // não é a propriedade da classe (é local)
        if (!isset($clientes))
            session(["customers" => $clientes_mock]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $view = '<ol>';
        // $count = 0;
        // foreach($this->clientes as $cliente){
        //     $view .= "<li>" . $cliente['nome'] .  " (id: " . $cliente['id'] . ")</li>";
        // }
        // $view .= '</ol>';
        // return $view;

        $title = "Clientes";
        $customers = session("customers");
        return view('customers.index', compact('customers', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customers.create', [
            'fname'=>null,
            'mname'=>null,
            'lname'=>null,
            'dob'=>'yyyy/MM/dd',
            'sex'=>null,
            'update'=>false
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $clientes = session('customers');
        $count = count($clientes);
        $newId = $count == 0 ? 1 : end($clientes)->getId() + 1;
        $newCustomer = new Customer(
            $newId,
            $request->fname,
            $request->mname,
            $request->lname,
            DateOnly::buildByString($request->dob),
            $request->sex
        );
        $clientes[] = $newCustomer;
        session(['customers' => $clientes]);
        return redirect()->route('customer.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $customers = session('customers');
        $c = $customers[$this->getIndex($id, $customers)];
        if (!isset($c))
            return "<h2>Customer not found.</h2>";
        //return "<h2>Id: " . $customer['id'] . ", Nome: " . $customer['nome'] . "</h2>";

        return view('customers.info', compact('c'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $customers = session('customers');
        $index = $this->getIndex($id, $customers);
        $customer = $customers[$index];
        return view('customers.edit', [
            'id'=>$customer->getId(),
            'fname'=>$customer->getFirstName(),
            'mname'=>$customer->getMiddleName(),
            'lname'=>$customer->getLastName(),
            'dob'=>$customer->getDateOfBirth()->toString("yyyy/MM/dd"),
            'sex'=>$customer->getSex(),
            'update'=>true
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $clientes = session('customers');
        $index = $this->getIndex($id, $clientes);
        $clientes[$index] = $this->getCustomerByRequest($request, $id);
        session(['customers'=>$clientes]);
        return redirect()->route('customer.index');
    }

    private function getCustomerByRequest(Request $request, $id) {
        return new Customer(
            $id,
            $request->fname,
            $request->mname,
            $request->lname,
            DateOnly::buildByString($request->dob),
            $request->sex
        );
    }

    private function getIndex(int $id, array $customers): ?int {
        // // array example
        // $ids = array_column($customers, 'id');
        // $index = array_search($id, $ids);

        $index = 0;
        foreach($customers as $c) {
            if ($c->getId() == $id)
                return $index;
            $index++;
        }
        return null;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $customers = session('customers');
        $index = $this->getIndex($id, $customers);
        array_splice($customers, $index, 1);
        session(['customers'=>$customers]);
        return redirect()->route("customer.index");
    }
}
