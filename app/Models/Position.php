<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Position extends Model
{
    use HasFactory, SoftDeletes;

    public function users(): HasMany {
        return $this->hasMany(User::class, 'position_id', 'id');
    }

    public function car_categories(): BelongsToMany {
        return $this->belongsToMany(CarCategory::class, 'car_category_positions', 'position_id', 'car_category_id');
    }
}
