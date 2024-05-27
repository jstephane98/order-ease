<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SousFamille extends Model
{
    public $timestamps = false;

    protected $table = 'ART_SFAM';

    protected $primaryKey = 'ART_SFAM';
    protected $keyType = 'string';

    protected $fillable = ["SFA_CODE", "SFA_LIB"];
}
