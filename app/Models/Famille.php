<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Famille extends Model
{
    public $timestamps = false;

    protected $table = 'ART_FAM';

    protected $primaryKey = "FAR_CODE";

    protected $keyType = "string";

    protected $fillable = ["FAR_CODE", "FAR_LIB"];
}
