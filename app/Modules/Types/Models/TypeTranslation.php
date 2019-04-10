<?php

namespace App\Modules\Types\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class TypeTranslation extends Model
{
    use HasSlug;

    protected $table = 'types_translations';

    protected $fillable = [
        'title',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'slug',
    ];

    public $timestamps = false;

    public function getSlugOptions(): SlugOptions {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

}
