@section('topcss')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-12 text-end">
                <a class="btn btn-secondary" href="{{ route('productsToReview') }}">
                    Go Back
                </a>
            </div>
        </div>
        <div class="row blog-entries element-animate mt-4">
            <div class="col-md-6  main-content">
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
                <div class="pt-5">
                    <h3 class="mb-3">Leave a review</h3>
                    @if(\App\Models\Review::checkIfUserAddedReview($product->id, \Illuminate\Support\Facades\Auth::user()->id))
                        <div class="form-group mb-3">
                            <label for="rating">Rating</label> <br>
                            @for($i = 1; $i<=5; $i++)
                                <input disabled type="radio" id="star" class="rate ms-1 form-check-input" name="rating" value="{{$i}}"
                                       @if($review->star_rating == $i )checked @endif />
                                <label for="star1" title="text">{{$i}} <span class="fa fa-star"></span></label>
                            @endfor
                        </div>
                        <div class="form-group">
                            <label for="description">Message</label>
                            <textarea name="description" id="description" cols="2" rows="5" disabled
                                      class="form-control">{{ $review->description}}</textarea>
                        </div>

                        <div class="form-group mt-2">
                            <input type="submit" value="Add Review" class="btn btn-primary" disabled>
                        </div>
                    @else
                        <form action="{{route('storeReview', $product->id)}}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="rating">Rating</label> <br>
                                @for($i = 1; $i<=5; $i++)
                                    <input type="radio" id="star" class="rate ms-1 form-check-input {{ $errors->has('rating') ? ' is-invalid' : '' }}" name="rating" value="{{$i}}" @if(old('rating') == $i )checked @endif/>
                                    <label for="star1" title="text">{{$i}} <span class="fa fa-star"></span></label>
                                @endfor
                                @if ($errors->has('rating'))
                                    <span class="invalid-feedback">{{ $errors->first('rating') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="description">Message</label>
                                <textarea name="description" id="description" cols="2" rows="5"
                                          class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}">{{old('description')}}</textarea>
                                @if ($errors->has('description'))
                                    <span class="invalid-feedback">{{ $errors->first('description') }}</span>
                                @endif
                            </div>

                            <div class="form-group mt-2">
                                <input type="submit" value="Add Review" class="btn btn-primary">
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
