<?php

namespace App\Modules\Projects\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class ProjectTranslation extends Model
{
    use HasSlug;

    protected $table = 'projects_translations';

    protected $fillable = [
        'title',
        'architect',
        'slug',
    ];

    public $timestamps = false;

    public function getSlugOptions(): SlugOptions {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }
}
