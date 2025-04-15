<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Coupon extends Model
{

    use SoftDeletes;
    protected $table = 'coupon';
    protected $primaryKey = 'coupon_uuid';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;

    protected $fillable = [
        'code',
        'cost',
        'bill_uuid'
    ];

    protected static function booted()
    {
        static::creating(function ($user) {
            $user->coupon_uuid = (string) Str::uuid();
        });
    }

    public function offers()
    {
        return $this->belongsToMany(Offer::class, 'offer_coupon', 'coupon_uuid', 'offer_uuid');
    }
}
