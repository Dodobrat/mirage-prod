<?php

namespace App\Modules\Contacts\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class ContactTranslation extends Model
{
    use HasSlug;

    protected $table = 'contacts_translations';

    protected $fillable = [
        'title',
        'description',
        'working_time',
        'address',
        'email',
        'phone',
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
