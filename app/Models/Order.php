<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'name', 'email', 'address', 'total',
    ];

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
