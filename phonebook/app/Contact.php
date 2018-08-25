<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    const DEFAULT_LABEL = '[TODO: Label Me]';

    protected $fillable = ['phone_number', 'identity', 'user_id', 'email'];

    /**
     * Set relationship of single user to multiple contacts
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user() {
        return $this->hasOne(User::class);
    }
}
