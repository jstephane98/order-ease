<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Tiers extends Model{
    public $timestamps = false;

    protected $table = 'TIERS';

    protected $primaryKey = "PCF_CODE";

    protected $keyType = "string";

    protected $fillable = [
        'PCF_CODE',
        'PCF_TYPE',
        'PCF_RS',
        'PCF_RUE',
        'PCF_REG',
        'PCF_VILLE',
        'PAY_CODE',
        'user_id',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'TIER_CODE', 'PCF_CODE');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'PCF_CODE');
    }

    public function pays(): BelongsTo
    {
        return $this->belongsTo(Pays::class, 'PAY_CODE');
    }
}
