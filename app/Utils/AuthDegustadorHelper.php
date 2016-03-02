<?php

namespace App\Utils;

use Auth;
use App\Constants\UserConstant;

trait AuthDegustadorHelper {

    public function getDegustador($property, $onEmptyMessage = self::EMPTY_PROPERTY) {
        if (!empty($this->degustador) && !empty($this->degustador->$property)) {
            return $this->degustador->$property;
        }
        return $onEmptyMessage;
    }

    public function getDegustadorEndereco($property, $onEmptyMessage = self::EMPTY_PROPERTY) {
        if ($this->hasDegustadorEndereco()) {
            return $this->degustador->enderecoPrincipal()->$property;
        }
        return $onEmptyMessage;
    }

    public function hasDegustador() {
        return !empty($this->degustador);
    }

    public function hasDegustadorEndereco() {
        return !empty($this->degustador) && !empty($this->degustador->enderecoPrincipal());
    }

    public function getNomeCidade() {
        if ($this->hasDegustadorEndereco()) {
            return $this->degustador->enderecoPrincipal()->cidade->nome_cidade;
        }
        return self::EMPTY_PROPERTY;
    }

    public function getNomePais() {
        if ($this->hasDegustadorEndereco()) {
            return $this->degustador->enderecoPrincipal()->pais->nome_pais;
        }
        return self::EMPTY_PROPERTY;
    }

    public function getNomeEstado() {
        if ($this->hasDegustadorEndereco()) {
            return $this->degustador->enderecoPrincipal()->estado->nome_estado;
        }
        return self::EMPTY_PROPERTY;
    }

    public function getDegustadorAvatar() {
        if ($this->hasDegustador() && !empty($this->degustador->avatar)) {
            return $this->degustador->avatar;
        }

        return UserConstant::DEFAULT_AVATAR;
    }

    public function getDegustadorDataNascimento() {
        $dataNascimento = $this->getDegustador('data_nascimento', '');

        if (empty($dataNascimento) || $dataNascimento == "0000-00-00") {
            return null;
        }

        return date("d/m/Y", strtotime($dataNascimento));
    }

}