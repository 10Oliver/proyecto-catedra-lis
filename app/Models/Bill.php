<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Bill extends Model
{

    use SoftDeletes;

    protected $table = 'bill';
    protected $primaryKey = 'bill_uuid';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;

    protected $fillable = [
        'total',
        'amount',
        'user_uuid'
    ];

    protected static function booted()
    {
        static::creating(function ($user) {
            $user->bill_uuid = (string) Str::uuid();
        });
    }

    public function coupons()
    {
        return $this->hasMany(Coupon::class, 'bill_uuid');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_uuid', 'user_uuid');
    }
}
