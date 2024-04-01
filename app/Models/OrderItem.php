<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;
    public $timestamps = false;
    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class,'code', 'color_code');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function tshirtImage(): BelongsTo
    {
        return $this->belongsTo(TshirtImage::class)->withTrashed();;
    }
}
