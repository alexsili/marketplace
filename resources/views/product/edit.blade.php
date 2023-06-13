@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-6">
                <h1 class="h4 mb-2">Edit Product</h1>
            </div>
            <div class="col-6 text-end">
                <a class="btn btn-secondary" href="{{ url()->previous() }}">
                    Go Back
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <form action="{{route('products.update', $product->id)}}" method="POST" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="row">
                        <div class="col-4">
                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>
                                <div class="col-md-8">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $product->name }}" _required autocomplete="name" autofocus>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="price" class="col-md-4 col-form-label text-md-end">{{ __('Price') }}</label>
                                <div class="col-md-8">
                                    <input id="price" type="text" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ $product->price }}" _required autocomplete="name" autofocus>
                                    @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3 @if ($errors->has('status')) has-error @endif">
                                <label for="status" class="col-md-4 col-form-label text-md-end">Status</label>
                                <div class="col-md-8">
                                    <div class="radio">
                                        <input type="radio" name="status" id="status-active" value="A"
                                               @if( $product->status == 'A') checked="checked" @endif
                                        <label for="status-active"> &nbsp; Active</label>
                                        &nbsp;&nbsp;&nbsp;
                                        <input type="radio" name="status" id="status-inactive" value="I"
                                               @if( $product->status == 'I') checked="checked" @endif
                                        <label for="status-inactive"> &nbsp;Inactive</label>
                                    </div>
                                    @if ($errors->has('status'))
                                        <p
                                            class="invalid-feedback">{{ $errors->first('status') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="file" class="col-md-4 col-form-label text-md-end">Upload Image</label>
                                <div class="col-md-8">
                                    <div class="col-md-12">
                                        <input type="file" class="form-control" name="file[]" value="{{old('file')}}" placeholder="File">
                                        @if ($errors->has('file'))
                                            <span class="invalid-feedback d-block">{{ $errors->first('file') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="file" class="col-md-4 col-form-label text-md-end">Uploaded Images</label>
                                <div class="col-md-8">
                                    @foreach($product->images as $image)
                                        <img src="/uploads/images/{{$image->product_id}}/{{$image->file_name}}" alt="{{$image->file_name}}" style="width: 200px; height: 120px">
                                        <br>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="row mb-3">
                                <label for="description" class="col-md-4 col-form-label text-md-end">{{ __('Description') }}</label>

                                <div class="col-md-6">
                                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" cols="30" rows="10" autofocus>{{ $product->description }}</textarea>
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-6">
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteProductModal">
                                Delete
                            </button>
                        </div>
                        <div class="col-6 text-end">
                            <button type="submit" class="btn btn-large btn-primary">
                                {{ __('Update Product') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Product </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are sure you want to delete this product {{$product->name}} ?
                </div>
                <div class="modal-footer">
                    <form action="{{ route('products.destroy', $product->id)}}" method="POST">
                        @method('delete')
                        @csrf
                        <button type="submit" class="btn btn-danger" style="width: 120px;">Delete</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>
@endsection

