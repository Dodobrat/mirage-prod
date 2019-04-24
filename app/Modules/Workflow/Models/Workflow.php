<?php

namespace App\Modules\Workflow\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Workflow extends Model implements HasMedia
{
    use Translatable, HasMediaTrait, NodeTrait;

    protected $table = 'workflow';

    public $translatedAttributes = [
        'title',
        'slug',
    ];

    protected $with = ['translations'];

    protected $fillable = [
        'active',
        'access_key',
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
            ->width(240)
            ->height(240)
            ->sharpen(0)
            ->nonOptimized();
    }
}
