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
                    @if(auth()->user()->is_admin)
                    <td>&nbsp;</td>
                    @endif
                </tr>
            </thead>
            <tbody class="bg-white divide-y">
                @forelse($products as $product)
                    <tr class="bg-white">
                        <td class="px-6 py-4 whitespace-no-wrap">{{$product->name}}</td>
                        <td class="px-6 py-4 whitespace-no-wrap">{{$product->price}}</td>
                        @if(auth()->user()->is_admin)
                        <td class="px-6 py-4 whitespace-no-wrap d-flex">
                            <a href="{{route('products.edit', $product->id)}}" class="btn btn-primary">Edit</a>

                            <form method="post" action="{{ route('products.destroy', $product) }}">
                                @csrf
                                @method("DELETE")

                                <button class="btn btn-danger" onclick="return confirm('Are you sure?')" type="submit">DELETE</button>
                            </form>
                        </td>
                        @endif
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