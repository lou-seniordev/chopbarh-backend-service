<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class LiaisonAgent extends Model
{
    //
    protected $fillable = [
        'first_name', 'last_name', 'email', 'gender', 'phone_number', 'dob', 'state'
    ];

    public function parent_agent() {
        return $this->belongsTo('App\\Models\\LiaisonAgent','parent', 'token');
    }

    public function child_agents() {
        return $this->hasMany('App\\Models\\LiaisonAgent', 'parent', 'token');
    }

    public function setTokenAttribute() {
        $this->attributes['token'] = Str::random(16);
    }

    public function setGeneratedPasswordAttribute() {
        $this->attributes['generated_password'] = /*bcrypt()*/ Str::random(10);
    }
}
