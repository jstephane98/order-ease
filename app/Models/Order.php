<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $table = "ORDERS";

    protected $fillable = ['NBR_ART', 'status', 'price', 'user_id', 'PCF_CODE'];

    const STATUS = [
        "CREATED" => "En attente",
        "INPROGRESS" => "En cours de traitement",
        "COMPLETED" => "Valider",
        "CANCELED" => "Annuler"
    ];

    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn($value, array $attributes) => $value / 100,
            set: fn($value) => $value * 100,
        );
    }

    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn($value, array $attributes) => self::STATUS[$value],
            set: fn($value) => $value,
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function panier(): HasMany
    {
        return $this->hasMany(Panier::class, 'order_id');
    }

    public function tier(): BelongsTo
    {
        return $this->belongsTo(Tiers::class, 'PCF_CODE');
    }
}
