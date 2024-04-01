<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;


class Customer extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['id', 'nif', 'address', 'default_payment', 'default_payment_ref'];

    public function order() : HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function tshirtImage() : HasMany
    {
        return $this->hasMany(TshirtImage::class);
    }

    public function user() : HasOne
    {
        return $this->hasOne(User::class,'id', 'id');
    }

}
