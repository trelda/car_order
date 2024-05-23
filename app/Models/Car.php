<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Car extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['model', 'category_id', 'driver_id'];

    public function driver(): BelongsTo {
        return $this->belongsTo(Driver::class, 'driver_id', 'id');
    }

    public function carCategory(): BelongsTo {
        return $this->belongsTo(CarCategory::class, 'category_id', 'id');
    }
}
