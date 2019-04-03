<?php

namespace App\Modules\Types\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;

class Type extends Model
{
    use SoftDeletes, Translatable, NodeTrait;

    protected $table = 'types';

    public $translationForeignKey = 'type_id';

    protected $with = ['translations'];

    public $translatedAttributes = [
        'title',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'slug'
    ];

    protected $fillable = [
        'active'
    ];

    public function scopeActive($query)
    {
        return $query->where($this->table . '.active', 1);
    }
}
