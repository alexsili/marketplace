@section('topcss')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-12 text-end">
                <a class="btn btn-secondary" href="{{ route('products.index') }}">
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
                    @if(\App\Models\Review::checkIfUserAddedReview($product->id))
                        <div class="form-group mb-3">
                            <label for="rating">Rating</label> <br>
                            @for($i = 1; $i<=5; $i++)
                                <input disabled type="radio" id="star" class="rate ms-1 form-check-input" name="rating" value="{{$i}}"
                                       @if(Auth::user()->review->star_rating == $i )checked @endif />
                                <label for="star1" title="text">{{$i}} <span class="fa fa-star"></span></label>
                            @endfor
                        </div>
                        <div class="form-group">
                            <label for="description">Message</label>
                            <textarea name="description" id="description" cols="2" rows="5" disabled
                                      class="form-control">{{ Auth::user()->review->description}}</textarea>
                        </div>
                        <div class="row mb-3">
                            <label for="status" class="col-1 col-form-label ">Status</label>
                            <div class="col-md-8 text-md-start">
                                <div class="radio mt-2">
                                    <input type="radio" name="status" id="status-active" value="A"
                                           @if( Auth::user()->review->status=='A') checked @endif disabled>
                                    <label for="status-active">Active</label>
                                    &nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="status" id="status-inactive" value="I"
                                           @if(Auth::user()->review->status=='I') checked @endif disabled>
                                    <label for="status-inactive">Inactive</label>
                                </div>
                            </div>
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

                            <div class="row mb-3 @if ($errors->has('status')) has-error @endif">
                                <label for="status" class="col-1 col-form-label">Status</label>
                                <div class="col-md-8">
                                    <div class="radio mt-2">
                                        <input type="radio" name="status" id="status-active" value="A"
                                               @if(((!empty(old('status')) && old('status')=='A')) || empty(old('status'))) checked @endif>
                                        <label for="status-active">Active</label>
                                        &nbsp;&nbsp;&nbsp;
                                        <input type="radio" name="status" id="status-inactive" value="I"
                                               @if((!empty(old('status')) && old('status') =='I')) checked @endif>
                                        <label for="status-inactive">Inactive</label>
                                    </div>
                                    @if ($errors->has('status'))
                                        <p
                                            class="invalid-feedback">{{ $errors->first('status') }}</p>
                                    @endif
                                </div>
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
