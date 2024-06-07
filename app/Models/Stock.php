<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Stock extends Model
{
    public $timestamps = false;

    protected $table = 'ART_STOCK';

    protected $keyType = 'string';
    protected $primaryKey = "DEP_CODE";

    protected $fillable = [
        'DEP_CODE',
        'ART_CODE',
        'STK_REEL',
    ];

    public function article(): HasOne
    {
        return $this->hasOne(Article::class, 'ART_CODE');
    }
}
