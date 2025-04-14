<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class CompanyOffer extends Model
{
    use SoftDeletes;

    protected $table = 'company_offer';
    protected $primaryKey = 'company_offer_uuid';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;

    protected $fillable = [
        'company_uuid',
        'offer_uuid'
    ];

    protected static function booted()
    {
        static::creating(function ($user) {
            $user->company_offer_uuid = (string) Str::uuid();
        });
    }
}
