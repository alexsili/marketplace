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

    public function activeProduct()
    {
        return $this->belongsTo(Product::class)->where('status', 'A');
    }

    public static function checkIfUserAddedReview($productId, $userId)
    {
        return Review::where('product_id', $productId)->where('user_id', $userId)->first();
    }
}
