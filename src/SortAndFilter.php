<?php

namespace Amitav\SortAndFilter;

use Illuminate\Http\Request;

trait SortAndFilter
{
    public function scopeSort($query, Request $req)
    {
        $query->when($req->has('sortBy'), function ($query) use ($req) {
            if ($this->sortable !== null && count($this->sortable) !== 0) {
                if (!in_array($req->input('sortBy'), $this->sortable)) {
                    $message = config("sort-and-filter.sort-not-allowed");
                    abort(400, $message);
                }
            }

            if ($req->has('sortOrder')) {
                $query->orderBy($req->input('sortBy'), $req->input('sortOrder'));
            } else {
                $query->orderBy($req->input('sortBy'), 'asc');
            }
        });
    }

    public function scopeFilter($query, Request $req)
    {
        $query->when(($req->has('filterBy') && $req->has('filterValue')), function ($query) use ($req) {
            if ($this->filterable !== null && count($this->filterable) !== 0) {
                if (!in_array($req->input('filterBy'), $this->filterable)) {
                    $message = config("sort-and-filter.filter-not-allowed");
                    abort(400, $message);
                }
            }

            $query->where($req->input('filterBy'), 'like', "{$req->input('filterValue')}%");
        });
    }
}
