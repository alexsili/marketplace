@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-12 text-end">
                <a class="btn btn-secondary" href="{{ url()->previous() }}">
                    Go Back
                </a>
            </div>
        </div>
        <div class="row blog-entries element-animate mt-4">
            <div class="col-md-12  main-content">
                <div class="post-content-body">
                    <h1 class="mb-4 mt-4"> Product Name: {{ $product->name}}</h1>
                    <p class="text-md-start"> Product Description: {{$product->description}}</p>
                    <p class="text-md-start"> Product Price: {{$product->price}}</p>
                    <div class="row mb-3">
                        <label for="file" class="col-md-4 col-form-label ">Product Images</label>
                        <div class="col-md-8">
                            @foreach($product->images as $image)
                                <img src="/uploads/images/{{$image->product_id}}/{{$image->file_name}}" alt="{{$image->file_name}}" style="width: 300px; height: 150px">
                                <br>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
