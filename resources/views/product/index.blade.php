@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-6">
                <h1 class="h4 mb-2">Products</h1>
            </div>
            @if(Auth::user()->user_type == 'seller')
                <div class="col-6 text-end">
                    <a class="btn btn-primary" href="{{ route('products.create') }}">
                        Add Product
                    </a>
                </div>
            @endif
        </div>
        <div class="row">
            <div class="col-12">
                @if ($products->count())
                    <table class="table mt-4">
                        <thead>
                        <tr>
                            <th scope="col">NAME</th>
                            <th scope="col">DESCRIPTION</th>
                            <th scope="col">PRICE</th>
                            <th scope="col">STATUS</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td class="t-bold">
                                    @if(Auth::user()->user_type == 'seller')
                                    <a href="{{route('products.edit', $product->id)}} ">{{ $product->name }}</a>
                                    @else
                                        <a href="{{route('createReview', $product->id)}} ">{{ $product->name }}</a>
                                    @endif
                                </td>
                                <td class="t-bold">{{ $product->description }}</td>
                                <td class="t-bold">{{ $product->price }}</td>
                                <td class="t-bold"> @if($product->status == 'A')
                                        Active
                                    @else
                                        Inactive
                                    @endif</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-center mt-4 pt-4">No products</p>
                @endif
            </div>
        </div>
    </div>
@endsection
