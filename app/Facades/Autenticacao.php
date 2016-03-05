<?php

namespace App\Facades;

use Auth;
use Illuminate\Contracts\Validation\UnauthorizedException;

class Autenticacao {

    private static $user;

    /**
     * Retorna o ID do usuario logado
     *
     * @return int
     */
    public static function getId() {
        return self::getUsuario()->id;
    }

    /**
     * Retorna o nome do usuario logado
     *
     * @return int
     */
    public static function getNome() {
        return self::getUsuario()->name;
    }

    /**
     * Retorna o email do usuario logado
     *
     * @return int
     */
    public static function getEmail() {
        return self::getUsuario()->email;
    }

    /**
     * Retorna o password do usuario logado
     *
     * @return int
     */
    public static function getPassword() {
        return self::getUsuario()->password;
    }

    /**
     * Retorna os dados do usuario logado
     *
     * @return stdClass
     */
    public static function getUsuario() {
        if (!self::isLogado()) {
            throw new UnauthorizedException;
        }

        if (empty(self::$user)) {
            self::$user = Auth::user();
        }

        return self::$user;
    }

    /**
     * Verifica se o usuario está logado
     *
     * @return bool
     */
    public static function isLogado() {
        return Auth::check();
    }

    /**
     * Verifica se o usuário logado é um chef
     *
     * @return bool
     */
    public static function isChef() {
        return (bool) self::getUsuario()->ind_chef;
    }

    /**
     * Verifica se o usuário logado é um cliente
     *
     * @return bool
     */
    public static function isCliente() {
        return !((bool) self::getUsuario()->ind_chef);
    }

    /**
     * Verifica se o usuário logado já confirmou o email
     *
     * @return bool
     */
    public static function isEmailConfirmado() {
        return !((bool) self::getUsuario()->ind_email_confirmado);
    }

    /**
     * Realiza logout
     *
     * @return bool
     */
    public static function deslogar() {
        return Auth::logout();
    }

}