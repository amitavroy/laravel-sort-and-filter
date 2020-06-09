<?php

namespace Amitav\SortAndFilter\Tests\TestSupport;

use Amitav\SortAndFilter\SortAndFilter;
use Illuminate\Database\Eloquent\Model;

class TestModel extends Model
{
    use SortAndFilter;

    protected $table = 'test_models';

    protected $guarded = [];
}
