<?php

namespace App\Utils;

use Auth;
use App\Constants\ChefConstant;
use App\Constants\UserConstant;
use App\Constants\ChefStatusConstant;

trait AuthChefHelper {

    protected $defaultChefCover = 'chef_wallpaper.jpg';
    protected $defaultStatus = 'Inativo';

    public function getChefCover() {
        if ($this->hasChef() && !empty($this->chef->foto_capa)) {
            return $this->chef->foto_capa;
        }
        return config('constants.chef.default.foto_capa');
    }

    public function hasChef() {
        return !empty($this->chef);
    }

    public function getDataNascimento() {
        $dataNascimento = $this->getChef('data_nascimento', '');

        if (empty($dataNascimento) || $dataNascimento == "0000-00-00") {
            return null;
        }

        return date("d/m/Y", strtotime($dataNascimento));
    }

    public function getChef($property, $onEmptyMessage = self::EMPTY_PROPERTY) {
        if ($this->hasChef() && !empty($this->chef->$property)) {
            return $this->chef->$property;
        }
        return $onEmptyMessage;
    }

    public function getChefStatus() {
        if ($this->hasChef()) {
            return $this->chef->status->descricao;
        }
        return config('constants.chef.status.des_aguardando_finalizacao_perfil');
    }

    public function getChefAvatar() {
        if ($this->hasChef() && !empty($this->chef->avatar)) {
            return $this->chef->avatar;
        }
        return config('constants.user.default.avatar');
    }

}