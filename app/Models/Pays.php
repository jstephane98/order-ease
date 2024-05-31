<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pays extends Model
{
    public $timestamps = false;

    protected $table = 'PAYS';

    protected $primaryKey = "PAY_CODE";

    protected $keyType = "string";

    protected $fillable = [
        'PAY_CODE',
        'PAY_NOM',
        'PAY_NUMERO',
        'DEV_CODE',
    ];
}
