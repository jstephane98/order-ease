<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Panier extends Model
{
    public $timestamps = false;

    protected $table = 'PANIERS';

//    protected $primaryKey = 'ART_CODE';
//
//    protected $keyType = 'string';

    protected $fillable = [
        'ART_CODE',
        'QUANTITY',
        'STATUS',
        'user_id',
        'order_id',
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class, 'ART_CODE');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
