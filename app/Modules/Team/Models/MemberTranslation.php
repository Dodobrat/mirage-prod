<?php

namespace App\Modules\Team\Models;

use Illuminate\Database\Eloquent\Model;

class MemberTranslation extends Model
{
    protected $table = 'team_translations';

    protected $fillable = [
        'name',
        'position',
    ];

    public $timestamps = false;
}
