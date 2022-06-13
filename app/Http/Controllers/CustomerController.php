<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Classes\DateOnly;

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
        $clientes = session("customers");
        $customers = [];
        foreach($clientes as $c) {
            $customers[] = $c->toArray();
        }
        $meta = [
            'id'=>['pt-br'=>'Id', 'en-us'=>'Id'],
            'fullName'=>['pt-br'=>'Nome', 'en-us'=>'Name'],
            'age'=>['pt-br'=>'Idade', 'en-us'=>'Age'],
            'sex'=>['pt-br'=>'Sexo', 'en-us'=>'Sex'],
            'dateOfBirth'=>['pt-br'=>'Nascimento', 'en-us'=>'Date of birth'],
        ];
        $route = ['show'=>'customer.show', 'edit'=>'customer.edit', 'destroy'=>'customer.destroy'];
        return view('customers.index', compact('customers', 'title', 'meta', 'route'));
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
