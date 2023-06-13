<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function activeReviews()
    {
        return $this->hasMany(Review::class)->where('status', 'A');
    }

    public function avgReviewRating()
    {
        return round($this->activeReviews()->avg('star_rating'), 2);

    }
}
