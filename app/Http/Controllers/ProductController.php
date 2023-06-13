<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::query()
            ->where('company_id', Auth::user()->seller->company_id)
            ->when($request->has('pd'), function ($query) use ($request) {
                $query->when($request->get('pd') == 'myProducts', function ($q2) use ($request) {
                    $q2->where('company_id', Auth::user()->seller->company_id);
                    $q2->where('user_id', Auth::user()->id);
                });
            })
            ->get();

        return view('product.index')
            ->with('products', $products);
    }

    public function show($productId)
    {
        $product = Product::find($productId);

        abort_if(!$product, 403);
        abort_if($product->company_id != Auth::user()->seller->company_id, 403);

        return view('product.show')->with('product', $product);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'        => 'required|string|max:255',
            'description' => 'required|min:3|max:1000',
            'price'       => 'required|numeric',
            'status'      => 'required|max:1',
            'file.*'      => 'required|mimes:jpeg,jpg,bmp,png,pdf,doc,docx|max:30000',
        ]);

        $product              = new Product();
        $product->user_id     = Auth::user()->id;
        $product->company_id  = Auth::user()->seller->company->id;
        $product->name        = $request->get('name');
        $product->description = $request->get('description');
        $product->price       = $request->get('price');
        $product->status      = $request->get('status');
        $product->save();


        if ($file = $request->file('file')) {
            foreach ($file as $file) {
                $imageOriginalName = $file->getClientOriginalName();
                $image             = str_replace(' ', '', $product->name) . '_' . $imageOriginalName;
                $file->move('uploads/images/' . $product->id, $image);

                $productImage             = new  Image();
                $productImage->product_id = $product->id;
                $productImage->file_name  = $image;
                $productImage->save();
            }
        }

        return redirect(route('products.index'))->with('success', 'Product saved successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($productId)
    {
        $product = Product::find($productId);

        abort_if(!$product, 403);
        abort_if($product->company_id != Auth::user()->seller->company_id, 403);
        abort_if($product->user_id != Auth::user()->seller->user_id, 403);

        return view('product.edit')->with('product', $product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $productId)
    {
        $product = Product::find($productId);

        abort_if(!$product, 403);
        abort_if($product->company_id != Auth::user()->seller->company_id, 403);
        abort_if($product->user_id != Auth::user()->seller->user_id, 403);

        $this->validate($request, [
            'name'        => 'required|string|max:255',
            'description' => 'required|min:3|max:1000',
            'price'       => 'required|numeric',
            'status'      => 'required|max:1',
            'file.*'      => 'mimes:jpeg,jpg,bmp,png,pdf,doc,docx|max:30000',
        ]);

        $product->user_id     = Auth::user()->id;
        $product->company_id  = Auth::user()->seller->company->id;
        $product->name        = $request->get('name');
        $product->description = $request->get('description');
        $product->price       = $request->get('price');
        $product->status      = $request->get('status');
        $product->save();


        if ($file = $request->file('file')) {
            foreach ($file as $file) {
                $imageOriginalName = $file->getClientOriginalName();
                $image             = str_replace(' ', '', $product->name) . '_' . $imageOriginalName;
                $file->move('uploads/images/' . $product->id, $image);

                $productImage             = new  Image();
                $productImage->product_id = $product->id;
                $productImage->file_name  = $image;
                $productImage->save();
            }
        }

        return redirect(route('products.index'))->with('success', 'Product updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($productId)
    {
        $product = Product::find($productId);

        abort_if(!$product, 403);
        abort_if($product->company_id != Auth::user()->seller->company_id, 403);
        abort_if($product->user_id != Auth::user()->seller->user_id, 403);

        $productImages = Image::where('product_id', $productId)->get();
        if ($productImages) {
            foreach ($productImages as $productImage) {
                $productImage->delete();
            }
        }

        $product->delete();

        return redirect(route('products.index'))->with('success', 'Product deleted successfully.');
    }
}
