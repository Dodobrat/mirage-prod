<?php

namespace App\Modules\Types\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Type extends Model
{
    use Translatable, NodeTrait;

    protected $table = 'types';

    public $translatedAttributes = [
        'title',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'slug',
    ];

    protected $fillable = [
        'active'
    ];
}
