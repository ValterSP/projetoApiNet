<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Color extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $primaryKey = 'code';
    public $incrementing= false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function orderItem(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'color_code', 'code');
    }
}
