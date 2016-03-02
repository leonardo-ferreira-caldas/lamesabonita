<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PagamentoModel extends Model
{
    protected $table = 'pagamento';
    protected $primaryKey = 'id_pagamento';

    protected $fillable = ['fk_reserva', 'fk_pagamento_metodo', 'fk_pagamento_status', 'pagamento_status_info'];

    public function metodo() {
        return $this->hasOne('App\Model\PagamentoMetodoModel', 'id_pagamento_metodo', 'fk_pagamento_metodo');
    }

    public function cartao() {
        return $this->hasOne('App\Model\PagamentoCartaoModel', 'fk_pagamento', 'id_pagamento');
    }

    public function status() {
        return $this->belongsTo('App\Model\PagamentoStatus', 'fk_pagamento_status', 'id_pagamento_status');
    }

    public function reserva() {
        return $this->belongsTo('App\Model\ReservaModel', 'fk_reserva', 'id_reserva');
    }

}
