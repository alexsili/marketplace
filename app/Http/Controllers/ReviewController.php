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

    /**
     * Show the form for creating a new resource.
     */
    public function create($productId)
    {
        $product = Product::find($productId);

        return view('review.create')->with('product', $product);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $productId)
    {

        if (Review::checkIfUserAddedReview($productId)) {
            return redirect(route('products.index'));
        }

        $this->validate($request, [
            'rating'      => 'required|integer|min:1|max:5',
            'description' => 'required|min:3|max:1000',
            'status'      => 'required|max:1',
        ]);

        $review              = new Review();
        $review->user_id     = Auth::user()->id;
        $review->product_id  = $productId;
        $review->star_rating = $request->get('rating');
        $review->description = $request->get('description');
        $review->status      = $request->get('status');
        $review->save();

        return redirect(route('products.index'))->with('success', 'Review added successfully.');
    }

}
