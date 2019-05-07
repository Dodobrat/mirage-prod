<?php

namespace App\Modules\Blocks\Models;

use Illuminate\Database\Eloquent\Model;

class BlockTranslation extends Model
{
    protected $table = 'blocks_translations';

    protected $fillable = [
        'description'
    ];

    public $timestamps = false;
}
