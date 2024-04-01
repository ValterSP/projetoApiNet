<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TshirtImage extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'category_id',
        'image_url',
    ];

    public function customer() : BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function categorie() : BelongsTo
    {
        return $this->belongsTo(Categorie::class, 'category_id', 'id');
    }

    public function orderItem() : HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
