<?php

namespace App\Modules\Types\Models;

use App\Modules\Categories\Models\Category;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;

class Type extends Model
{
    use Translatable, NodeTrait, SoftDeletes;

    protected $table = 'types';

    public $translatedAttributes = [
        'title',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'slug',
    ];

    protected $with = ['translations'];

    protected $fillable = [
        'active'
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where($this->table . '.active', 1);
    }

    public function categories() {

        return $this->belongsToMany(Category::class,'types_categories','type_id','category_id');

    }
}
