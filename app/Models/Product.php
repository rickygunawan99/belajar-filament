<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $timestamps = true;

    protected $casts = [
        'is_visible' => 'bool'
    ];

    protected $guarded = ['id'];
}
