<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Constants\ReservaConstants;

class ReservaModel extends Model
{
    protected $table = 'reserva';
    protected $primaryKey = 'id_reserva';

    protected $fillable = ['fk_degustador', 'fk_degustador_endereco', 'fk_chef', 'fk_menu',
            'fk_status', 'data_reserva', 'horario_reserva', 'qtd_clientes', 'preco_por_cliente',
            'taxa_lmb', 'preco_total', 'observacao'];

    public function menu() {
        return $this->belongsTo('App\Model\MenuModel', 'fk_menu', 'id_menu');
    }

    public function curso() {
        return $this->belongsTo('App\Model\CursoModel', 'fk_curso', 'id_curso');
    }

    public function chef() {
        return $this->belongsTo('App\Model\ChefModel', 'fk_chef', 'id_chef');
    }

    public function pagamento() {
        return $this->hasOne('App\Model\PagamentoModel', 'fk_reserva', 'id_reserva');
    }

    public function user() {
        return $this->belongsTo('App\User', 'fk_chef', 'id');
    }

    public function userDegustador() {
        return $this->belongsTo('App\User', 'fk_degustador', 'id');
    }

    public function endereco() {
        return $this->belongsTo('App\Model\DegustadorEnderecoModel', 'fk_degustador_endereco', 'id_degustador_endereco');
    }

    public function degustador() {
        return $this->belongsTo('App\Model\DegustadorModel', 'fk_degustador', 'id_degustador');
    }

    public function status() {
        return $this->belongsTo('App\Model\ReservaStatusModel', 'fk_status', 'id_reserva_status');
    }

    public function ativo() {
        return $this->fk_status == ReservaConstants::STATUS_ATIVA;
    }

}
