<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class CompanyUser extends Model
{
    use SoftDeletes;

    protected $table = 'company_user';
    protected $primaryKey = 'company_user_uuid';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;

    protected $fillable = [
        'company_uuid',
        'user_uuid',
        'approved_uuid'
    ];

    protected static function booted()
    {
        static::creating(function ($user) {
            $user->company_user_uuid = (string) Str::uuid();
        });
    }
}
