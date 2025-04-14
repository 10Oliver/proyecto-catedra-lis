<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class OfferCoupon extends Model
{

    use SoftDeletes;

    protected $table = 'offer_coupon';
    protected $primaryKey = 'offer_coupon_uuid';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;

    protected $fillable = [
        'offer_uuid',
        'coupon_uuid'
    ];

    protected static function booted()
    {
        static::creating(function ($user) {
            $user->offer_coupon_uuid = (string) Str::uuid();
        });
    }
}
