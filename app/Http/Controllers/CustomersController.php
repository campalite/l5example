<?php

namespace App\Http\Controllers;
use App\Customer;
use App\Company;
use App\Listener;
use App\Events\NewCustomerHasRegisteredEvent;
use App\Mail\WelcomeNewUserMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
   

class CustomersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {   
        //$customers = Customer::all();
        $customers = Customer::with('company')->paginate(20);
        //for optimization query request (eager loading)
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
        $this->authorize('create', Customer::class);

        $customer = Customer::create($this->validateRequest());

        $this->storeImage($customer);

        event(new NewCustomerHasRegisteredEvent($customer));
        
        return redirect('customers');

       // return redirect('customers');
            //$data = request()->validate([
            //    'name' => 'required|min:3',
            //    'email' => 'required|email',
            //    'active' => 'required',
            //    'company_id' => 'required',    ]);
        //dd($data);
        //$Customer = Customer::create($data);
        //$customer = new Customer();
        //$customer->name = request('name');
        //$customer->email = request('email');
        //$customer->active = request('active');
        //$customer->save();
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

        $this->storeImage($customer);

        return redirect('customers/'. $customer->id);
    }

    public function destroy(Customer $customer)
    {

        $this->authorize('delete', $customer);
        
        $customer->delete();

        return redirect('customers');
    }

    private function validateRequest()
    {

        return tap(request()->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'active' => 'required',
            'company_id' => 'required',

        ]), function() {

            if(request()->hasFile('image')) {
                request()->validate([
                    'image' => 'file|image|max:5000',
                ]);
            }

        });

    }

    private function storeImage($customer)
    {
        if (request()->has('image')){
            $customer->update([
                'image' => request()->image->store('uploads','public'),
            ]);
            //http://image.intervention.io/
            $image = Image::make(public_path('storage/' . $customer->image))->fit(300,300);
            $image->save();
        }
    }
    
}
