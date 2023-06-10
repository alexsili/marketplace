@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-6">
                <h1 class="h4 mb-2">Add Product</h1>
            </div>
            <div class="col-6 text-end">
                <a class="btn btn-secondary" href="{{ route('products.index') }}">
                    Go Back
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <form action="{{route('products.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-4">
                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>
                                <div class="col-md-8">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" _required autocomplete="name" autofocus>
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
                                    <input id="price" type="text" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price') }}" _required autocomplete="name" autofocus>
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
                            <div class="row mb-3">
                                <label for="file" class="col-md-4 col-form-label text-md-end">Upload Image</label>
                                <div class="col-md-8">
                                    <div class="col-md-12">
                                        <input type="file" class="form-control" name="file[]" value="{{old('file')}}" placeholder="File" multiple>
                                        @if ($errors->has('file'))
                                            <span class="invalid-feedback d-block">{{ $errors->first('file') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="row mb-3">
                                <label for="description" class="col-md-4 col-form-label text-md-end">{{ __('Description') }}</label>

                                <div class="col-md-6">
                                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" cols="30" rows="10" autofocus>{{ old('description') }}</textarea>
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary text-end">
                                {{ __('Add Product') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

