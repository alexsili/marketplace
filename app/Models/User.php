<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable
        = [
            'company_id',
            'first_name',
            'last_name',
            'user_type',
            'email',
            'password',
        ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden
        = [
            'password',
            'remember_token',
        ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts
        = [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function isSeller()
    {
        return $this->user_type == 'seller';
    }

    public function isClient()
    {
        return $this->user_type == 'client';
    }

    public function activeReview()
    {
        return $this->hasOne(Review::class)->where('status', 'A');
    }

    public function seller()
    {
        return $this->hasOne(SellerUser::class);
    }

}

