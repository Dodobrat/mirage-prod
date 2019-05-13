<?php

namespace App\Modules\Index\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Index extends Model implements HasMedia
{
    use NodeTrait, HasMediaTrait, SoftDeletes;

    protected $table = 'index';

    protected $fillable = [
        'title',
        'active'
    ];

    public function registerMediaConversions(Media $media = null)
    {

        $this->addMediaConversion('view')
            ->width(1920)
            ->height(1080)
            ->sharpen(0)
            ->nonOptimized();
    }

    protected $casts = [
        'active' => 'boolean'
    ];

    public function scopeActive($query)
    {
        return $query->where($this->table . '.active', 1);
    }
}
