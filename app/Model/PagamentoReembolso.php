<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PagamentoReembolso extends Model
{
    const STATUS_COMPLETED = 'COMPLETED';

    protected $table = 'pagamento_reembolso';
    protected $primaryKey = 'id_pagamento_reembolso';
}
