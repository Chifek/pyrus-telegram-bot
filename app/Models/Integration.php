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
        'user_id', 'telegram_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var string[]
     */
    protected $hidden = [
    ];

    public function getToken($state): string {
        if (empty($this->token)) {
            $this->token = Crypt::encrypt(Crypt::generateKey('AES-128-CBC') . $state);
        }
        return $this->token;
    }
}
