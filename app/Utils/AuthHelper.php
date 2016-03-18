<?php

namespace App\Utils;

use Auth;

class AuthHelper {

    use AuthDegustadorHelper, AuthChefHelper;

    const EMPTY_PROPERTY = 'Nao Cadastrado';

    protected $user;
    protected $chef;
    protected $degustador;

    public function __construct() {
        if ($this->isLoggedIn()) {
            $this->chef   = Auth::user()->chef;
            $this->degustador = Auth::user()->degustador;
        }
    }

    public function isChef() {
        return Auth::user()->ind_chef;
    }

    public function isDegustador() {
        return !Auth::user()->ind_chef;
    }

    public function isLoggedIn() {
        return Auth::check();
    }

    public function getEmail() {
        return Auth::user()->email;
    }

    public function getName() {
        if ($this->isChef()) {
            return sprintf("%s %s", Auth::user()->name, Auth::user()->chef->sobrenome);
        }
        return Auth::user()->name;
    }

    public function getAvatar() {
        if ($this->isChef()) {
            return $this->getChefAvatar();
        } 
        return $this->getDegustadorAvatar();
    }

    public function getMemberSince() {
        return date("d/m/Y", strtotime(Auth::user()->created_at));
    }

}