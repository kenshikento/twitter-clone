<?php

namespace App\Values;

use App\Values\Enum;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class SearchType extends Enum
{
    const All 	= '*';
    const ID 	= 'id';
    const Limit = 'limit';
}