<?php

namespace App\Modules\Projects\Models;

use App\Modules\Categories\Models\Category;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Project extends Model implements HasMedia
{
    use Translatable, HasMediaTrait, NodeTrait;

    protected $table = 'projects';

    public $translatedAttributes = [
        'title',
        'architect',
        'slug',
    ];

    protected $with = ['translations'];

    protected $fillable = [
        'active',
        'category_id'
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where($this->table . '.active', 1);
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->width(600)
            ->height(600)
            ->sharpen(0)
            ->nonOptimized();
    }

    public function category() {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
