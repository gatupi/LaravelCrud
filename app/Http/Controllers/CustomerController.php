<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Classes\DateOnly;
use Illuminate\Support\Facades\DB;

class CustomerListFilter {

    protected const PARAMS = ['name', 'age_min', 'age_max', 'birth_year', 'birth_month', 'birth_day', 'sex', 'active'];
    private array $data = [];

    public function __construct() {
        $this->data = array_fill_keys(self::PARAMS, null);
    }

    public function __set($key, $value) {
        if (in_array($key, self::PARAMS)) {
            switch($key){
                case 'name':
                    $this->data[$key] = "%$value%";
                    break;
                default:
                $this->data[$key] = $value;
            }                
        }
    }

    public function __get($key) {
        return in_array($key, self::PARAMS) ? $this->data[$key] : null;
    }

    public function toArray() {
        return $this->data;
    }

    public static function createByRequest(Request $request): CustomerListFilter {
        $filter = new CustomerListFilter();

        switch($request->age_filter_opt) {
            case 'between':
                $filter->age_min = $request->age1 ?? null;
                $filter->age_max = $request->age2 ?? null;
                break;
            case 'greater':
                $filter->age_min = $request->age2 ?? null;
                break;
            case 'less':
                $filter->age_max = $request->age2 ?? null;
                break;
            case 'equal':
                $filter->age_min = $filter->age_max = $request->age2 ?? null;
                break;
        }

        $m = ['jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec'];

        switch($request->birth_filter_opt) {
            case 'month':
                $filter->birth_month = array_search($request->birth_month, $m) + 1;
                break;
            case 'date':
                if (isset($request->birth_date)) {
                    $parts = explode('-', $request->birth_date);
                    $filter->birth_year = (int)$parts[0];
                    $filter->birth_month = (int)$parts[1];
                    $filter->birth_day = (int)$parts[2];
                }
                break;
            case 'year':
                $filter->birth_year = $request->birth_year;
                break;
            case 'month-and-year':
                $filter->birth_month = array_search($request->birth_month, $m) + 1;
                $filter->birth_year = $request->birth_year;
                break;
            case 'birthday':
                $opt = $request->birthday_option;
                $filter->birth_month = (int)date('m');
                if ($opt == 'd')
                    $filter->birth_day = (int)date('d');
                break;
            case 'month-and-day':
                $filter->birth_month = array_search($request->birth_month, $m) + 1;
                $filter->birth_day = $request->birth_day;
                break;
        }

        $filter->name = $request->name ?? null;
        $filter->sex = !isset($request->sex) || $request->sex == 'both' ? null : $request->sex;
        $filter->active = !isset($request->activity) || $request->activity == 'all' ? null : $request->activity;

        return $filter;
    }
}

class CustomerController extends Controller
{
    public function __construct(){
        
        $customers = Customer::all();
        if (empty($customers)) {
            $customers = [
                ['first_name'=>'Gabriel', 'middle_name'=>'Willian', 'last_name'=>'Alonso', 'sex'=>'m', 'cpf'=>'12312312311', 'date_of_birth'=>'1997-12-08'],
                ['first_name'=>'Mariana', 'middle_name'=>null, 'last_name'=>'Malaguti', 'sex'=>'f', 'cpf'=>'12312312312', 'date_of_birth'=>'2002-05-30'],
                ['first_name'=>'Aline', 'middle_name'=>null, 'last_name'=>'Capocci', 'sex'=>'f', 'cpf'=>'12312312313', 'date_of_birth'=>'1980-05-18']
            ];
            foreach($customers as $c) {
                Customer::create($c);
            }
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = CustomerListFilter::createByRequest($request)->toArray();

        $query = DB::table('customers')->select(
            DB::raw("row_number() over (order by full_name) as row_num"),
            'id',
            DB::raw("get_customer_fullname(id) as full_name"),
            DB::raw("get_customer_age(id) as age"),
            DB::raw("date_format(date_of_birth, '%d/%m/%Y') as date_of_birth"),
            DB::raw('hide_cpf(cpf) as cpf'),
            'sex',
            'active'
        )
        ->whereRaw("
            deleted_at is null
            and (? is null or year(date_of_birth) = ?)
            and (? is null or month(date_of_birth) = ?)
            and (? is null or day(date_of_birth) = ?)
            and (? is null or sex = ?)
            and (? is null or active = ?)
        ", [$filters['birth_year'], $filters['birth_year'], $filters['birth_month'], $filters['birth_month'],
            $filters['birth_day'], $filters['birth_day'], $filters['sex'], $filters['sex'],
            $filters['active'], $filters['active']])
        ->havingRaw('
            (? is null or full_name like ?) and (? is null or age >= ?) and (? is null or age <= ?)
        ', [$filters['name'], $filters['name'], $filters['age_min'], $filters['age_min'],
            $filters['age_max'], $filters['age_max']]);

        $count = DB::query()->select(DB::raw('count(*) as total'))->fromSub($query, 'q')->get()->first()->total;

        $perPage = 15;
        $perPage = $perPage < 15 ? 15 : ($perPage > 20 ? 20 : $perPage);
        $maxPages = intdiv($count, $perPage) + ($count % $perPage != 0);
        $page = 1;
        $page = $page < 1 ? 1 : ($page > $maxPages ? $maxPages : $page);
        $list = DB::query()->select()->fromSub($query, 'q')->whereRaw('q.row_num between ? and ?', [($page-1)*$perPage + 1, $page*$perPage])->get()->toArray();

        $list = array_map(function($element) {
            return (array)$element;
        }, $list);
        $meta = [
            'columns'=>[
                'keys'=>['row_num', 'id', 'full_name', 'cpf', 'age', 'date_of_birth', 'sex', 'active'],
                'pt-br'=>['#', 'Id', 'Nome', 'CPF', 'Idade', 'Nascimento', 'Sexo', 'Ativo'],
                'en-us'=>['#', 'Id', 'Name', 'CPF', 'Age', 'Date of birth', 'Sex', 'Active']
            ],
            'title'=>['pt-br'=>'Clientes', 'en-us'=>'Customers'],
            'routes'=>[
                'edit'=>'customer.edit',
                'destroy'=>'customer.destroy',
                'show'=>'customer.show'
            ],
            'lang'=>'pt-br'
        ];
        return view('customers.index', compact('list', 'meta', 'maxPages', 'page', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customers.create', [
            'first_name'=>null,
            'middle_name'=>null,
            'last_name'=>null,
            'date_of_birth'=>'yyyy/MM/dd',
            'sex'=>null,
            'update'=>false,
            'cpf'=>null
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
        $customer = new Customer();
        
        try {
            $customer->cpf = $request->cpf;
            $customer->first_name = $request->first_name;
            $customer->middle_name = $request->middle_name;
            $customer->last_name = $request->last_name;
            $customer->sex = $request->sex;
            $customer->active = true;
            $customer->date_of_birth = $request->date_of_birth;
            $customer->save();
        }
        catch(\Throwable $e) {
            return "<h1>Oops... Houve um problema com o cadastro :(<br>Aqui está a mensagem: \"" . $e->getMessage() . "\"</h1>";
        }

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
        $customer = Customer::find($id);

        $date_parts = explode('-', $customer['date_of_birth']);
        $date_of_birth = $date_parts[2] . '/' . $date_parts[1] . '/' . $date_parts[0];

        return view('customers.create', [
            'update'=>true,
            'id'=>$id,
            'cpf'=>$customer['cpf'],
            'first_name'=>$customer['first_name'],
            'middle_name'=>$customer['middle_name'],
            'last_name'=>$customer['last_name'],
            'date_of_birth'=>$date_of_birth,
            'sex'=>$customer['sex']
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
        $customer = Customer::find($id);
        try {
            $customer->cpf = $request->cpf;
            $customer->first_name = $request->first_name;
            $customer->middle_name = $request->middle_name;
            $customer->last_name = $request->last_name;
            $customer->sex = $request->sex;
            $customer->active = true;
            $customer->date_of_birth = $request->date_of_birth;
            $customer->update();
        }
        catch(\Throwable $e) {
            return "<h1>Oops... Houve um problema com o cadastro :(<br>Aqui está a mensagem: \"" . $e->getMessage() . "\"</h1>";
        }
        return redirect()->route('customer.index');
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
        try {
            $customer = Customer::find($id);
            $customer->delete();
        } catch(\Throwable $e) {
            return "Error: " . $e->getMessage();
        }
        return redirect()->route('customer.index');
    }
}
