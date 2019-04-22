<?php

namespace App\Http\Controllers;
use App\Customer;
use App\Company;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    public function index()
    {   
        $customers = Customer::all();
        
        return view('customers.index',compact('customers'));
        //$activeCustomers = Customer::active()->get();
        //$inactiveCustomers = Customer::inactive()->get();
        //dd($activeCustomers);
        //return view('customers.index',compact('activeCustomers','inactiveCustomers'));

       // return view('customers',[
       //     'activeCustomers' => $activeCustomers,
       //     'inactiveCustomers' => $inactiveCustomers,
       // ]);
    }

    public function create()
    {
        $companies = Company::all();
        $customer = new Customer();
        return view('customers.create',compact('companies','customer'));
    }
    
    public function store()
    {
        Customer::create($this->validateRequest());
            //$data = request()->validate([
            //    'name' => 'required|min:3',
            //    'email' => 'required|email',
            //    'active' => 'required',
            //    'company_id' => 'required',
            //    
            //]);
        //dd($data);

        //$Customer = Customer::create($data);
        //$customer = new Customer();
        //$customer->name = request('name');
        //$customer->email = request('email');
        //$customer->active = request('active');
        //$customer->save();
        
        return redirect('customers');
    }

    public function show(Customer $customer) // route model binding
    {
        //$customer = Customer::where('id', $customer)->firstOrFail();
        
        return view('customers.show',compact('customer'));
    }

    public function edit(Customer $customer)
    {
        $companies = Company::all();
        return view('customers.edit',compact('customer','companies'));
    }

    public function update(Customer $customer)
    {
        $customer->update($this->validateRequest());

        return redirect('customers/'. $customer->id);
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect('customers');
    }

    private function validateRequest()
    {
        return request()->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'active' => 'required',
            'company_id' => 'required',
        ]);
    }
    
}
