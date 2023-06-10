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
    public function index()
    {
        if (Auth::user()->user_type == 'seller') {
            $products = Product::where('company_id', Auth::user()->company_id)->get();
        } else {
            $products = Product::where('status', 'A')->get();
        }
        return view('product.index')->with('products', $products);
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
        $product->company_id  = Auth::user()->company_id;
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

        if (!$product) {
            return redirect(route('products.index'))->with('error', 'Product not found.');
        }

        return view('product.edit')->with('product', $product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $productId)
    {
        $product = Product::find($productId);

        if (!$product) {
            return redirect(route('products.index'))->with('error', 'Product not found.');
        }

        if (Auth::user()->id != $product->user_id) {
            return redirect(route('products.index'))->with('error', 'You don\'t have permissions to update this product.');
        }

        $this->validate($request, [
            'name'        => 'required|string|max:255',
            'description' => 'required|min:3|max:1000',
            'price'       => 'required|numeric',
            'status'      => 'required|max:1',
            'file.*'      => 'mimes:jpeg,jpg,bmp,png,pdf,doc,docx|max:30000',
        ]);

        $product->user_id     = Auth::user()->id;
        $product->company_id  = Auth::user()->company_id;
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

        if (!$product) {
            return redirect(route('products.index'))->with('error', 'Product not found.');
        }

        if (Auth::user()->id != $product->user_id) {
            return redirect(route('products.index'))->with('error', 'You don\'t have permissions to delete this product.');
        }

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
