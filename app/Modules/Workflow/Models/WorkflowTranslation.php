<?php

namespace App\Modules\Workflow\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class WorkflowTranslation extends Model
{
    use HasSlug;

    protected $table = 'workflow_translations';

    protected $fillable = [
        'title',
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
