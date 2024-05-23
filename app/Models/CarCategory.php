<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CarCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description'];

    public function cars():HasMany {
        return $this->hasMany(Car::class, 'category_id', 'id');
    }

    public function positions(): BelongsToMany {
        return $this->belongsToMany(CarCategory::class, 'car_category_positions', 'position_id', 'car_category_id');
    }
}
