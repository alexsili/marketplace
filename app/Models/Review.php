<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Review extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class)->where('status', 'A');
    }

    public static function checkIfUserAddedReview($productId)
    {
        $response = false;
        $reviews = Review::where('product_id', $productId)->get();
        if ($reviews) {
            foreach ($reviews as $review) {
                if (Auth::user()->id == $review->user_id) {
                    $response = true;
                }
            }
        }
        return  $response;
    }
}
