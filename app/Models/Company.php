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
}
