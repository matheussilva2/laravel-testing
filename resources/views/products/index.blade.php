@extends('layouts.app')

@section('content')
    <div class="mx-5 bg-light">
        @if(auth()->user()->is_admin)
        <a href="/products/create" class="btn btn-primary">Add new product</a>
        @endif
        <table class="table my-5 table-dark">
            <thead>
                <tr>
                    <td>Name</td>
                    <td>Price</td>
                </tr>
            </thead>
            <tbody class="bg-white divide-y">
                @forelse($products as $product)
                    <tr class="bg-white">
                        <td class="px-6 py-4 whitespace-no-wrap">{{$product->name}}</td>
                        <td class="px-6 py-4 whitespace-no-wrap">{{$product->price}}</td>
                    </tr>
                @empty
                    <tr class="bg-white">
                        <td class="px-6 py-4 whitespace-no-wrap text-sm">
                            {{ __("No products found") }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection