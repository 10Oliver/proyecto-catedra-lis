<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Company extends Model
{
    use SoftDeletes;
    protected $table = 'company';
    protected $primaryKey = 'company_uuid';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'nit',
        'address',
        'phone',
        'email',
        'percentage'
    ];

    protected static function booted()
    {
        static::creating(function ($user) {
            $user->company_uuid = (string) Str::uuid();
        });
    }

    public function offers()
    {
        return $this->belongsToMany(Offer::class, 'company_offer', 'company_uuid', 'offer_uuid');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'company_user', 'company_uuid', 'user_uuid');
    }
}
