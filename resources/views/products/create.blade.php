@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ route('products.store') }}" class="mx-5 bg-light">
        @csrf
        
        <input type="text" class="form-control bg-light mb-2" placeholder="Name" name="name" />
        <input type="number" step="0.1" class="form-control mb-2 bg-light" placeholder="Price" name="price" />
        <button class="btn btn-success" type="submit">SAVE</button>
    </form>
@endsection