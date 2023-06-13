<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $products = Product::where('status', 'A')->get();

        return view('review.index')->with('products', $products);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($productId)
    {
        $product = Product::find($productId);

        $review = Review::where('product_id', $productId)->where('user_id', Auth::user()->id)->first();

        return view('review.create')
            ->with('review', $review)
            ->with('product', $product);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $productId)
    {
        abort_if(Review::checkIfUserAddedReview($productId, Auth::user()->id), 403);

        $this->validate($request, [
            'rating'      => 'required|integer|min:1|max:5',
            'description' => 'required|min:3|max:1000',
        ]);

        $review              = new Review();
        $review->user_id     = Auth::user()->id;
        $review->product_id  = $productId;
        $review->star_rating = $request->get('rating');
        $review->description = $request->get('description');
        $review->status      = 'A';
        $review->save();

        return redirect(route('productsToReview'))->with('success', 'Review added successfully.');
    }

}
