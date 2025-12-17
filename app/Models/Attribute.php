<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $fillable = [
        'attribute_group_id','key','label','type','is_required','sort','meta','is_active',
    ];

    protected $casts = [
        'meta' => 'array',
        'is_required' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function group()
    {
        return $this->belongsTo(AttributeGroup::class, 'attribute_group_id');
    }

    public function options()
    {
        return $this->hasMany(AttributeOption::class);
    }
}
