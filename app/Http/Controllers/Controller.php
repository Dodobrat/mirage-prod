<?php

namespace App\Http\Controllers;

use App\Modules\Blocks\Models\Block;
use App\Modules\Types\Models\Type;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $types = Type::reversed()->get();
        View::share('types', $types);

        $block = Block::get();
        View::share('block', $block);

    }
}
