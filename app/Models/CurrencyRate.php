<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrencyRate extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'currency',
        'common',
        'rate',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'common' => 'bool',
    ];
}
