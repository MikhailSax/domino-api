<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['title','slug','sort','is_active'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function attributeGroups()
    {
        return $this->belongsToMany(\App\Models\AttributeGroup::class, 'category_attribute_group');
    }
}

