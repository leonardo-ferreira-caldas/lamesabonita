<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FAQModel extends Model
{
    protected $table = 'faq';
    protected $primaryKey = 'id_faq';

    public $timestamps = false;
}
