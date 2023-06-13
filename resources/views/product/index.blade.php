@section('topcss')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-2">
                <select id="products-filter" class="form-select">
                    <option value="all" @if(\Request::get('pd') == 'all' || \Request::get('pd') == '' ) selected="selected" @endif>
                        All Products
                    </option>
                    <option value="myProducts" @if(\Request::get('pd') == 'myProducts') selected="selected" @endif>My
                                                                                                                   Products
                    </option>
                </select>
            </div>
            <div class="col-10 text-end">
                <a class="btn btn-primary" href="{{ route('products.create') }}">
                    Add Product
                </a>
            </div>
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
                            <th scope="col">VIEW</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td class="t-bold">
                                    @if($product->user_id == Auth::user()->seller->user_id)
                                        <a href="{{route('products.edit', $product->id)}} ">{{ $product->name }}</a>
                                    @else
                                        {{ $product->name }}
                                    @endif
                                </td>
                                <td class="t-bold">{{ $product->description }}</td>
                                <td class="t-bold">{{ $product->price }}</td>
                                <td class="t-bold"> @if($product->status == 'A')
                                        Active
                                    @else
                                        Inactive
                                    @endif</td>

                                <td class="t-bold">
                                    <a href="{{route('products.show', $product->id)}} "><i class="fa fa-eye" aria-hidden="true"></i></a>
                                </td>
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

@section('endjs')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script>

        $(document).ready(function () {
            $('#products-filter').on('change', function () {
                window.location = '/products/?pd=' + this.value;
            });
        });
    </script>
@endsection
