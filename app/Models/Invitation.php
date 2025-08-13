<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $fillable = [
        'email',
        'invited_by',
        'company_id',
        'role',
        'token'
    ];

    public function inviter()
    {
        return $this->belongsTo(User::class, 'invited_by');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
