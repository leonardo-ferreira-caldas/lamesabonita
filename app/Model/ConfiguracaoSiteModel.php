<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ConfiguracaoSiteModel extends Model
{
    protected $table = 'configuracao_site';
    protected $primaryKey = 'chave';
    public $incrementing = false;
    public $timestamps = false;
}
