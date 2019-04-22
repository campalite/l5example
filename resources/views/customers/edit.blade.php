@extends('layout')

@section('title','Edit Details for '. $customer->name)

@section('content')
<div class="row">
    <div class="col-12">
        <h1>Edit details for {{ $customer->name }}</h1>
    </div>
</div>
    <form action="/customers/{{$customer->id}}" method="POST">
        
        @include('customers.form')
    <button type="submit" class="btn btn-primary">Save Customer</button>

        
    </form>
    </div>
</div>
    
@endsection
