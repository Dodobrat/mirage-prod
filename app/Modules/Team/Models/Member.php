<?php

namespace App\Modules\Team\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Member extends Model implements HasMedia
{
    use Translatable, HasMediaTrait, NodeTrait;

    protected $table = 'team';

    public $translatedAttributes = [
        'name',
        'position',
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

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->width(500)
            ->height(500)
            ->sharpen(0)
            ->nonOptimized();
    }
}
