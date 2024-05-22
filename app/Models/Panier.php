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

    protected $primaryKey = 'ART_CODE';

    protected $keyType = 'string';

    protected $fillable = [
        'ART_CODE',
        'USR_NAME',
        'QUANTITY',
        'STATUS',
    ];

    public function article(): HasOne
    {
        return $this->hasOne(Article::class, 'ART_CODE');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'USR_NAME');
    }
}
