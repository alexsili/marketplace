@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                @if ($products->count())
                    <table class="table mt-4">
                        <thead>
                        <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Company Name</th>
                            <th scope="col">Average Rating</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td class="t-bold">
                                    <img src="/uploads/images/{{$product->id}}/{{$product->images->first()->file_name ?? '-'}}" style="height: 100px; width: 150px">
                                </td>
                                <td class="t-bold">
                                    <a href="{{route('productShow',$product->id)}}">{{ $product->name }}</a></td>
                                <td class="t-bold">{{ $product->company->name }}</td>
                                <td class="t-bold">{{ $product->avgReviewRating() }}</td>
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
