@section('topcss')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-12 text-end">
                <a class="btn btn-secondary" href="{{ route('home') }}">
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
                <div class="pt-5">
                    <h3 class="mb-5">Reviews({{$reviews->count()}})</h3>
                    @if ($reviews->count())
                        <table id="datatable" class="table">
                            <thead>
                            <th class="no-sort">Name</th>
                            <th class="no-sort">Description</th>
                            <th>Stars Number</th>
                            </thead>
                            <tbody>
                            @foreach ($reviews as $review)
                                <tr>
                                    <td>{{ $review->user->fullName }}</td>
                                    <td>{{ $review->description }}</td>
                                    <td>{{ $review->star_rating }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-center mt-4 pt-4">No reviews</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('endjs')
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#datatable').DataTable({
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                columnDefs: [{
                    orderable: false,
                    targets: "no-sort"
                }],
            });
        });

    </script>
@endsection


