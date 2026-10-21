<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarouselSlide extends Model
{
    protected $fillable = ['item_type', 'item_id', 'position', 'is_visible'];

    protected function casts(): array
    {
        return ['item_id' => 'integer', 'position' => 'integer', 'is_visible' => 'boolean'];
    }
}
