<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Offer extends Model
{
    use SoftDeletes;
    protected $table = 'offer';
    protected $primaryKey = 'offer_uuid';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;

    protected $fillable = [
        'title',
        'regular_price',
        'offer_price',
        'start_date',
        'end_date',
        'amount',
        'description',
        'state'
    ];

    protected static function booted()
    {
        static::creating(function ($user) {
            $user->offer_uuid = (string) Str::uuid();
        });
    }

    public function getDaysLeftAttribute()
    {
        $today = Carbon::now();
        $endDate = Carbon::parse($this->end_date);
        return $today->lte($endDate) ? (int) $today->diffInDays($endDate) : 0;
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_offer', 'offer_uuid', 'company_uuid');
    }

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'offer_coupon', 'offer_uuid', 'coupon_uuid');
    }
}
