<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['category_id','title','slug','description','price_from','image_url','is_active'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    protected $casts = [
        'options_schema' => 'array',
    ];
}
