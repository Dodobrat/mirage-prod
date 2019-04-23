<?php

namespace App\Modules\Workflow\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Workflow extends Model
{
    use Translatable, NodeTrait;

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
}
