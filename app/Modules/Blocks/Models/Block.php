<?php

namespace App\Modules\Blocks\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;

class Block extends Model
{
    use Translatable, NodeTrait, SoftDeletes;

    protected $table = 'blocks';

    public $translatedAttributes = [
        'description'
    ];

    protected $with = ['translations'];

    protected $fillable = [
        'key',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    public function scopeActive($query)
    {
        return $query->where($this->table . '.active', 1);
    }
}
