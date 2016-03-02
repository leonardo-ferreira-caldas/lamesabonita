<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Socialize;
use App\Repositories\UserRepository;

class FacebookController extends Controller {

    private $auth;
    private $user;

    public function __construct(Guard $auth, UserRepository $user) {
        $this->auth = $auth;
        $this->user = $user;
    }
    
    public function login() {
        return Socialize::driver('facebook')->redirect();
    }
 
    public function callback() {
        $user = Socialize::driver('facebook')->user();

        $userExists = $this->user->findByEmail($user->getEmail());

        if (!empty($userExists) ) {
            $this->auth->login($userExists);
            return redirect('/minha-conta');
        }

        $password = sprintf('facebook:%s', $user->getID());

        $userData = [
            'name'      => $user->getName(),
            'email'     => $user->getEmail(),
            'password'  => $this->user->createPassword($password),
            'is_chef'   => '0'
        ];

        $userCreated = $this->user->create($userData, $this->user->uploadAvatarFromURL($user->getAvatar()));

        $this->auth->login($userCreated);

        return redirect('/minha-conta');

    }

}
