@extends('layouts.app')

@section('title','Edit Details for '. $customer->name)

@section('content')
<div class="row">
    <div class="col-12">
        <h1>Edit details for {{ $customer->name }}</h1>
    </div>
</div>
    <form action="{{ route('customers.update',['customer' => $customer]) }}" method="POST" enctype="multipart/form-data">
        
        @include('customers.form')
    <button type="submit" class="btn btn-primary">Save Customer</button>

        
    </form>
    </div>
</div>
    
@endsection
