<?php

namespace Amitav\SortAndFilter\Tests\TestSupport;

use Amitav\SortAndFilter\SortAndFilter;
use Illuminate\Database\Eloquent\Model;

class TestModelWithProp extends Model
{
    use SortAndFilter;

    protected $table = 'test_models';

    protected $guarded = [];

    protected $sortable = ['age'];

    protected $filterable = ['wins'];
}
