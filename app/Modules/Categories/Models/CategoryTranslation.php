<?php

namespace App\Modules\Categories\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class CategoryTranslation extends Model
{
    use HasSlug;

    protected $table = 'categories_translations';

    protected $fillable = [
        'title',
        'slug',
    ];

    public $timestamps = false;

    public function getSlugOptions(): SlugOptions {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }
}
