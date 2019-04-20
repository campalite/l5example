<?php

namespace App\Http\Controllers;
use App\Customer;
use App\Company;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    public function list()
    {
        $activeCustomers = Customer::active()->get();
        $inactiveCustomers = Customer::inactive()->get();
        //dd($activeCustomers);
        $companies = Company::all();
        return view('internals.customers',compact('activeCustomers','inactiveCustomers','companies'));

       // return view('internals.customers',[
       //     'activeCustomers' => $activeCustomers,
       //     'inactiveCustomers' => $inactiveCustomers,
       // ]);
    }
    
    public function store()
    {
    $data = request()->validate([
        'name' => 'required|min:3',
        'email' => 'required|email',
        'active' => 'required',
        'company_id' => 'required',
        
    ]);
        //dd($data);

        $Customer = Customer::create($data);
        //$customer = new Customer();
        //$customer->name = request('name');
        //$customer->email = request('email');
        //$customer->active = request('active');
        //$customer->save();
        
        return back();
    }
}
