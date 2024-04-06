<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Integration extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'form_id', 'token', 'enabled'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var string[]
     */
    protected $hidden = [
    ];

    public static function generateNewToken($formId): string {
        return Crypt::encrypt(Crypt::generateKey('AES-128-CBC') . $formId);
    }
}
