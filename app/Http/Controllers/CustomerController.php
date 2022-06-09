<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use App\Models\Filters\CustomerListFilter;

class CustomerController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $order = buildOrderBy('1:d,0', ['full_name', 'date_of_birth', 'id']);
        $filters = (new CustomerListFilter($request))->toArray();

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

        $count = $query->count();

        $perPage = 15;
        $perPage = $perPage < 15 ? 15 : ($perPage > 20 ? 20 : $perPage);
        $maxPages = intdiv($count, $perPage) + ($count % $perPage != 0);
        $page = 1;
        $page = $page < 1 ? 1 : ($page > $maxPages ? $maxPages : $page);

        $list = DB::query()->fromSub($query, 'q')->whereBetween('n', [($page - 1) * $perPage + 1, $page * $perPage])->orderBy('n')->get();

        $list = $list->map(function ($element) {
            return (array)$element;
        });
        $meta = [
            'columns' => [
                'keys' => ['n', 'id', 'full_name', 'cpf', 'age', 'date_of_birth', 'sex', 'active'],
                'pt-br' => ['#', 'Id', 'Nome', 'CPF', 'Idade', 'Nascimento', 'Sexo', 'Ativo'],
                'en-us' => ['#', 'Id', 'Name', 'CPF', 'Age', 'Date of birth', 'Sex', 'Active']
            ],
            'title' => ['pt-br' => 'Clientes', 'en-us' => 'Customers'],
            'routes' => [
                'edit' => 'customer.edit',
                'destroy' => 'customer.destroy',
                'show' => 'customer.show'
            ],
            'lang' => 'pt-br'
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
            'first_name' => null,
            'middle_name' => null,
            'last_name' => null,
            'date_of_birth' => 'yyyy/MM/dd',
            'sex' => null,
            'update' => false,
            'cpf' => null
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
        } catch (\Throwable $e) {
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
        $customer = Customer::find($id);
        $attributes = [
            'id'            => ['pt-br' => 'Id',                'en-us' => 'Id'],
            'full_name'     => ['pt-br' => 'Nome completo',     'en-us' => 'Full name'],
            'age'           => ['pt-br' => 'Idade',             'en-us' => 'Age'],
            'formatted_cpf' => ['pt-br' => 'CPF',               'en-us' => 'BR CPF'],
            'date_of_birth' => ['pt-br' => 'Nascimento',        'en-us' => 'Date of birth'],
            'sex'           => ['pt-br' => 'Sexo',              'en-us' => 'Sex'],
            'created_at'    => ['pt-br' => 'Data cadastro',     'en-us' => 'Register date'],
            'active'        => ['pt-br' => 'Ativo',             'en-us' => 'Active']
        ];
        $lang = 'pt-br';

        return view('customers.info', compact('customer', 'attributes', 'lang'));
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
            'update' => true,
            'id' => $id,
            'cpf' => $customer['cpf'],
            'first_name' => $customer['first_name'],
            'middle_name' => $customer['middle_name'],
            'last_name' => $customer['last_name'],
            'date_of_birth' => $date_of_birth,
            'sex' => $customer['sex']
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
        } catch (\Throwable $e) {
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
        } catch (\Throwable $e) {
            return "Error: " . $e->getMessage();
        }
        return redirect()->route('customer.index');
    }
}
