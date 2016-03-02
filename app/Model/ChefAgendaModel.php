<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
use DB;

class ChefAgendaModel extends Model
{
    use SoftDeletes;

    protected $table = 'chef_agenda';
    protected $primaryKey = 'id_chef_agenda';

    protected $fillable = ['fk_chef', 'data', 'hora_de', 'hora_ate'];

}
