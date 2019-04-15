<?php

namespace App\Modules\Contacts\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Contact extends Model
{
    use Translatable, NodeTrait;

    protected $table = 'contacts';

    public $translatedAttributes = [
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

    protected $with = ['translations'];

    protected $fillable = [
        'active',
        'lat',
        'lng',
        'show_map'
    ];

    protected $casts = [
        'active' => 'boolean',
        'show_map' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where($this->table . '.active', 1);
    }
}
