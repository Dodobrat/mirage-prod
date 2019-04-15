<?php

namespace App\Modules\Categories\Models;

use App\Modules\Projects\Models\Project;
use App\Modules\Types\Models\Type;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Category extends Model
{
    use Translatable, NodeTrait;

    protected $table = 'categories';

    public $translatedAttributes = [
        'title',
        'slug',
    ];

    protected $with = ['translations'];

    protected $fillable = [
        'active'
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where($this->table . '.active', 1);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function types() {

        return $this->belongsToMany(Type::class,'types_categories','category_id','type_id');

    }
}
