<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Classes\DateOnly;
use Illuminate\Support\Facades\DB;

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
    public function index()
    {
        $list = DB::select('call select_customers(?,?,?,?,?,?,?,?)', [null,null,null,null,null,null,null,null]);
        $list = array_map(function($element) {
            return (array)$element;
        }, $list);
        $meta = [
            'columns'=>[
                'keys'=>['id', 'full_name', 'cpf', 'age', 'date_of_birth', 'sex', 'active'],
                'pt-br'=>['Id', 'Nome', 'CPF', 'Idade', 'Nascimento', 'Sexo', 'Ativo'],
                'en-us'=>['Id', 'Name', 'CPF', 'Age', 'Date of birth', 'Sex', 'Active']
            ],
            'title'=>['pt-br'=>'Clientes', 'en-us'=>'Customers'],
            'routes'=>[
                'edit'=>'customer.edit',
                'destroy'=>'customer.destroy',
                'show'=>'customer.show'
            ],
            'lang'=>'pt-br'
        ];
        return view('customers.index', compact('list', 'meta'));
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
