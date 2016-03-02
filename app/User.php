<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'ind_chef', 'ind_confirmou_email'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function degustador() {
        return $this->hasOne('App\Model\DegustadorModel', 'id_degustador', 'id');
    }

    public function chef() {
        return $this->hasOne('App\Model\ChefModel', 'id_chef', 'id');
    }
}
